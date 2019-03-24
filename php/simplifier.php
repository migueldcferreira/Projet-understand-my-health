<?php
  require('Bdd.php');
  
  function chercherMotBDD($mot, &$bdd, &$numModal,&$motDejaSimplifies)
  {
    $texteRetour = "";
    $textePdf = [
      "texte" => "",
      "traduction" => "",
    ];
    $sql = "SELECT DEFINITION FROM TABLE_DEFINITION WHERE MOT LIKE '$mot' AND CLASSEMENT = 1;";
    $res = $bdd->query($sql); //On récupère (s'il en existe) les lignes de notre table "produits" qui répondent à notre requête $sql.
                  //Ces lignes sont stockées dans la variables $res qui est un tableau du jeu de résultat de notre requête.
    if(!empty($row = $res->fetch())) //La méthode fetch() permet de récupérer la ligne suivante du résultat de notre requete qui sont stockés dans la variable $res.
    {         
      $sdl = "SELECT ID_IMAGE FROM TABLE_IMAGE NATURAL JOIN TABLE_LIEN_MOT_IMAGE WHERE MOT = '".$mot."' AND A_CONFIRMER=0 ORDER BY CLASSEMENT;"; 
      $resimg = $bdd->query($sdl);
      
      if(!empty($rowimg = $resimg->fetch()))
      {

			$idImage = $rowimg['ID_IMAGE'];
			$texteRetour .= '
					  <button type="button" class="btn btn-outline-primary" data-toggle="tooltip" title=" <img style=\'max-height: 800px; max-width: 650px;\' src=\'genererImage.php?id='.$idImage.'\' > <br/>'.$row['DEFINITION'].'">
						'.$mot.'
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
					'.$mot.'
				</button>';	     
      }

      $mot_lower = strtolower($mot);
      $textePdf["texte"] .= '<a href="#'.$mot_lower.'">'.$mot.'</a>';
      if (!in_array($mot_lower, $motDejaSimplifies))
      {
	  $textePdf["traduction"] .= '<div><a name='.$mot_lower.'>'.$mot.' : '.$row['DEFINITION'].' <br/> </a></div>';
	  $motDejaSimplifies[] = $mot_lower;
      }
	    
        //$numModal += 1;
    }
    else
    {
      $textePdf["texte"] .= "$mot";
      $texteRetour .= "$mot";            
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


    $motDejaSimplifies = [];
    $texteSimplifie = "";
    $textePDF = [
      "texte" => "",
      "traduction" => "",
    ];
    $mot = "";
    $nbBaliseOuvrante = 0;
    $numModal = 0;
    
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
        if(strlen($mot) > 0)
        {
          $texteArray = chercherMotBDD($mot, $bdd, $numModal,$motDejaSimplifies);
          $texteSimplifie .= $texteArray["retour"];
          $textePDF["texte"] .= $texteArray["PDF"]["texte"];
          $textePDF["traduction"] .= $texteArray["PDF"]["traduction"];
        }
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
    if(strlen($mot) > 0)
        {
          $texteArray = chercherMotBDD($mot, $bdd, $numModal,$motDejaSimplifies);
          $texteSimplifie .= $texteArray["retour"];
          $textePDF["texte"] .= $texteArray["PDF"]["texte"];
          $textePDF["traduction"] .= $texteArray["PDF"]["traduction"];

        }
    $arrayRetour = [
      "retour" => $texteSimplifie,
      "PDF" => $textePDF,

    ];
    return $arrayRetour;
  }
?>
