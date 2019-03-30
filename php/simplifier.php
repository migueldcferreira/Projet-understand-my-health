<?php
  require('Bdd.php');


	function chercherExpressionBDD($mot, &$bdd, &$expressionDejaSimplifies, &$tabExpression)
	{
    $texteRetour = "";
    $textePdf = [
      "texte" => "",
      "traduction" => "",
    ];

    if(strlen($mot) > 0)
    {
      array_push($tabExpression,$mot);
    }
    else
    {
      $tailleTab = count($tabExpression);
      while($tailleTab>0)
      {
        $nbMotExpressionDansBDD = 0;

        //on cherche toutes les combinaisons d'expression dans tabExpression
        for($i=$tailleTab ; $i>0 ; $i--)
        {
          $expression = $tabExpression[0];
          for($j=1 ; $j<$i ; $j++)
          {
            $expression .= " ".$tabExpression[j];
          }
          //on regarde dans la BDD si l'expression $expression est presente
          $sql = "SELECT DEFINITION FROM TABLE_DEFINITION WHERE MOT LIKE '$expression' ORDER BY CLASSEMENT;";
          $res = $bdd->query($sql);
          if(!empty($row = $res->fetch())) //Si on a une definition pour ce mot dans la BDD
          {

            //on regarde si il existe aussi une image pour cette expression
            $sdl = "SELECT ID_IMAGE FROM TABLE_IMAGE NATURAL JOIN TABLE_LIEN_MOT_IMAGE WHERE MOT = '$expression' AND A_CONFIRMER=0 ORDER BY CLASSEMENT;";
            $resimg = $bdd->query($sdl);

            if(!empty($rowimg = $resimg->fetch()))
            {
              $idImage = $rowimg['ID_IMAGE'];
              $texteRetour .= '
                    <button type="button" class="btn btn-outline-primary" data-toggle="tooltip" title=" <img class=\'imageInfoBulle\' src=\'genererImage.php?id='.$idImage.'\' > <br/>'.$row['DEFINITION'].'">
                      '.$expression.'
                    </button>';

            }
            else
            {
              //Pour la gestion des images dans les info-bulle, faudra vérifier s'il existe bien une image quand
              //on a un mot difficile. Le cas échéant, il faudra faire une balise bouton type de ce type:
              //<button type="button" class="btn btn-primary" data-toggle="tooltip" title="<img src=\'https://www.docteurclic.com/galerie-photos/image_4155_400.jpg\'/>' .$row['DEFINITION'] .'">

              $texteRetour .= '
              <span class="vocabulaireSpecifique">
                <button type="button" class="btn btn-outline-primary" data-toggle="tooltip" title="'.$row['DEFINITION'].'">
                  '.$expression.'
                </button>
              </span>';
            }

            $expression_lower = strtolower($expression);
            $textePdf["texte"] .= '<a href="#'.$expression_lower.'">'.$expression.'</a>';
            if (!in_array($expression_lower, $expressionDejaSimplifies))
            {
              $textePdf["traduction"] .= '<div><a name='.$expression_lower.'>'.$expression.' : '.$row['DEFINITION'].' <br/> </a></div>';
              $expressionDejaSimplifies[] = $expression_lower;
            }

            $nbMotExpressionDansBDD = $i;
            break;
          }
        }
        if($nbMotExpressionDansBDD == 0)
        {
          //on a trouve aucune expression commencant par le premier mot de $tabExpression
          $premierMot = array_shift($tabExpression);
          $textePdf["texte"] .= "$premierMot";
          $texteRetour .= "$premierMot";
        }
        else
        {
          //on supprime du debut du tableau le nombre de mot qui compose l'expression (la plus grande) qui a ete trouvee dans la BDD
          for($i=0 ; $i<$nbMotExpressionDansBDD ; $i++)
          {
            array_shift($tabExpression);
          }
        }

        $tailleTab = count($tabExpression);
        //si il y a encore des mots a traiter alors on rajoute un espace
        if($tailleTab>0)
        {
          $textePdf["texte"] .= " ";
          $texteRetour .= " ";
        }
      }
    }

    $arrayRetour = [
      "retour" => $texteRetour,
      "PDF" => $textePdf,
    ];
    return $arrayRetour;

	}





  //$balise =
  //0: on cherche des mots difficiles dans les balises (<>),
  //1: on supprime les balises et leur contenue,
  //2: on laisse les balises mais on ne cherche pas de mots difficiles dedans
  function simplifierTexteBrut($text, $balise, $sautLigne = false)
  {
    //connexion a la base de donnees
    try
    {
      $bdd = Bdd::connect("BDD_TRADOCTEUR");
      $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      //Permet de récuperer une exception lorsque il y a une erreur au niveau de la base de donnée.
      //On pourra donc traiter l'erreur plus simplement avec un try et catch.
    }
    catch (Exception $e)
    {
        die('Erreur : ' . $e->getMessage());
    }


    $expressionDejaSimplifies = [];
    $tabExpression = array();
    $texteSimplifie = "";
    $textePDF = [
      "texte" => "",
      "traduction" => "",
    ];
    $mot = "";
    $nbBaliseOuvrante = 0;

    //le text doit etre sous la forme d'un tableau
    if(gettype($text) == "string")
      $text = str_split($text);
    foreach($text as $lettre)
    {
      if($nbBaliseOuvrante==0 and preg_match("#[a-zA-ZéèàêâùïüëÉÈÀÊÂÙÏÜË]#",$lettre) or (strlen($mot)>0 and $lettre=="-"))
      {
        $mot = $mot . "$lettre";
      }
      else
      {

        $texteArray = chercherExpressionBDD($mot, $bdd, $expressionDejaSimplifies, $tabExpression);
        $texteSimplifie .= $texteArray["retour"];
        $textePDF["texte"] .= $texteArray["PDF"]["texte"];
        $textePDF["traduction"] .= $texteArray["PDF"]["traduction"];

        $mot = "";
        if($balise>0 and $lettre == "<")
        {
          $nbBaliseOuvrante += 1;
        }
        elseif($balise>0 and $nbBaliseOuvrante > 0 and $lettre == ">")
        {
          $nbBaliseOuvrante -= 1;
        }
        else
        {
          if(!($balise == 1) or $nbBaliseOuvrante==0)
          {
            if($sautLigne == true and $lettre == "\n")
            {
              $texteSimplifie .= "<br />";
              $textePDF["texte"] .= "<br />";
            }
            else
            {
              $texteSimplifie .= "$lettre";
              $textePDF["texte"] .= "$lettre";
            }
          }
        }
      }
    }

    $texteArray = chercherExpressionBDD($mot, $bdd, $expressionDejaSimplifies, $tabExpression);
    $texteSimplifie .= $texteArray["retour"];
    $textePDF["texte"] .= $texteArray["PDF"]["texte"];
    $textePDF["traduction"] .= $texteArray["PDF"]["traduction"];


    $arrayRetour = [
      "retour" => $texteSimplifie,
      "PDF" => $textePDF,

    ];
    return $arrayRetour;
  }
?>
