<?php
  require('Bdd.php');

	function plurielVersSingulier($mot)
	{
		//fonction generique qui n'est pas fiable a 100%
		$tabConversion = array
		(
			array("pluriel" => "eaux","singulier" => "eau","taille" => 4),
			array("pluriel" => "eux","singulier" => "eu","taille" => 3),
			array("pluriel" => "aux","singulier" => "al","taille" => 3),
			//array("pluriel" => "aux","singulier" => "au","taille" => 3),
			//array("pluriel" => "aux","singulier" => "ail","taille" => 3),
			array("pluriel" => "s","singulier" => "","taille" => 1),
		);
		
		$taille = strlen($mot);
		
		foreach($tabConversion as $conv)
		{
			if($conv["taille"]<=$taille)
			{
				if(substr($mot, -$conv["taille"]) === $conv["pluriel"])
					return substr($mot, 0, $taille - $conv["taille"]).$conv["singulier"];
			}
		}
		return $mot;
	}

	function chercherExpressionBDD($mot, &$bdd, &$expressionDejaSimplifies, &$tabExpression, &$tabExpressionSingulier, &$motPourAlgoWeka)
	{
		
		
    $texteRetour = "";
    $textePdf = [
      "texte" => "",
      "traduction" => "",
    ];
    if(strlen($mot) > 0)
    {
      array_push($tabExpression,$mot);
			array_push($tabExpressionSingulier, plurielVersSingulier($mot));
    }
    else
    {
      $tailleTab = count($tabExpression);
      while($tailleTab>0)
      {
        $nbMotExpressionDansBDD = 0;

        //on cherche toutes les combinaisons d'expression dans tabExpression
        for($i=1 ; $i<=$tailleTab ; $i++)
        {
          $expression = $tabExpression[0];
					$expressionSingulier = $tabExpressionSingulier[0];
          for($j=1 ; $j<$i ; $j++)
          {
            $expression .= " ".$tabExpression[$j];
						$expressionSingulier .= " ".$tabExpressionSingulier[$j];
          }
          //on regarde dans la BDD si l'expression $expression + n'importe quoi est presente dans la BDD definition ou image
					$sql = "(SELECT MOT FROM TABLE_DEFINITION WHERE (MOT LIKE '$expression%' OR MOT LIKE '$expressionSingulier%') AND A_CONFIRMER=0)";
					$sql .= " UNION";
					$sql .= " (SELECT MOT FROM TABLE_IMAGE NATURAL JOIN TABLE_LIEN_MOT_IMAGE WHERE (MOT LIKE '$expression%' OR MOT LIKE '$expressionSingulier%') AND A_CONFIRMER=0);";
					$res = $bdd->query($sql);

          //Si on a une definition pour cette expression + potentiellement d'autres mots dans la BDD
          if(!empty($row = $res->fetch()))
          {
            //on test alors s'il y a une definition pour l'expression exacte (sans le %)
            $sql = "(SELECT DEFINITION FROM TABLE_DEFINITION WHERE MOT = '$expression' OR MOT = '$expressionSingulier' AND A_CONFIRMER=0 ORDER BY CLASSEMENT)";
            $sql .= " UNION";
						$sql .= " (SELECT ' ' AS DEFINITION FROM TABLE_IMAGE NATURAL JOIN TABLE_LIEN_MOT_IMAGE WHERE (MOT = '$expression' OR MOT = '$expressionSingulier') AND A_CONFIRMER=0";
						$sql .= " AND MOT NOT IN";
						$sql .= " (SELECT DISTINCT MOT FROM TABLE_DEFINITION))";
						$res = $bdd->query($sql);

            //Si on a une definition pour cette expression dans la BDD
            if(!empty($row = $res->fetch()))
            {
              //on regarde s'il existe aussi une image pour cette expression
              $sdl = "SELECT ID_IMAGE FROM TABLE_IMAGE NATURAL JOIN TABLE_LIEN_MOT_IMAGE WHERE (MOT = '$expression' OR MOT = '$expressionSingulier') AND A_CONFIRMER=0 ORDER BY CLASSEMENT;";
              $resimg = $bdd->query($sdl);
              if(!empty($rowimg = $resimg->fetch()))
              {
                $idImage = $rowimg['ID_IMAGE'];
                $texteRetour_tmp = '
                      <button type="button" class="btn btn-outline-primary" data-toggle="tooltip" title=" <img class=\'imageInfoBulle\' src=\'genererImage.php?id='.$idImage.'\' > <br/>'.htmlspecialchars($row['DEFINITION']).'">
                        '.$expression.'
                      </button>';
              }
              else
              {
                 $texteRetour_tmp = '
                  <button type="button" class="btn btn-outline-primary" data-toggle="tooltip" title="'.htmlspecialchars($row['DEFINITION']).'">
                    '.$expression.'
                  </button>';
              }
              $expression_lower = (str_replace(' ', '-', strtolower($expression)));
              $textePdf_texte = '<a href="#'.$expression_lower.'">'.$expression.'</a>';
              if (!in_array($expression_lower, $expressionDejaSimplifies))
              {
		/*if(!empty($rowimg))
		{
			$textePdf_traduction = '<div><a name='.$expression_lower.'>'.$expression.' : '.htmlspecialchars($row['DEFINITION']).' <img src=\'genererImage.php?id='.$idImage.'\' > <br/> </a></div>';
		}
		else
		{*/
                
		$textePdf_traduction = '<div><a name='.$expression_lower.'><u>'.$expression.'</u> : '.htmlspecialchars($row['DEFINITION']).' <br/> <br/> </a></div>';
		//}
	       	$expressionDejaSimplifies[] = $expression_lower;
              }
              $nbMotExpressionDansBDD = $i;
            }
          }
          else
          {
            //on ne peut plus trouver d'expression plus grande dans la BDD
            break;
          }
        }
        if($nbMotExpressionDansBDD == 0)
        {
          //on a trouve aucune expression commencant par le premier mot de $tabExpression
          $premierMot = array_shift($tabExpression);
					array_shift($tabExpressionSingulier);
          $textePdf["texte"] .= "$premierMot";
          $texteRetour .= "$premierMot";
					
					//on ajoute le mot dans le tableau des mots a traiter par l'algo weka
					$motPourAlgoWeka .= "$premierMot\n";
        }
        else
        {
          //on ajoute l'expression et sa definition au texte qu'on affichera sur la page et celui pour la generation du pdf
          $texteRetour .= $texteRetour_tmp;
          $textePdf["texte"] .= $textePdf_texte;
          $textePdf["traduction"] .= $textePdf_traduction;
          //on supprime du debut du tableau le nombre de mot qui compose l'expression (la plus grande) qui a ete trouvee dans la BDD
          for($i=0 ; $i<$nbMotExpressionDansBDD ; $i++)
          {
            array_shift($tabExpression);
						array_shift($tabExpressionSingulier);
          }
        }
        $tailleTab = count($tabExpression);
        //s'il y a encore des mots a traiter alors on rajoute un espace
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
		$tabExpressionSingulier = array();
		$motPourAlgoWeka = "";
    $texteSimplifie = "";
    $textePDF = [
      "texte" => "",
      "traduction" => "",
    ];
    $mot = "";
    $nbBaliseOuvrante = 0;
		$nbEspaceAAjouter = 0;
    //le text doit etre sous la forme d'un tableau
    if(gettype($text) == "string")
      $text = str_split($text);
    foreach($text as $lettre)
    {
      if($nbBaliseOuvrante==0 and preg_match("#[a-zA-Z0-9éèàêâùïüëÉÈÀÊÂÙÏÜË]#",$lettre) or (strlen($mot)>0 and $lettre=="-"))
      {
        $mot = $mot . "$lettre";
				$nbEspaceAAjouter = 0;
      }
      else
      {
        if(strlen($mot) > 0)
        {
          $texteArray = chercherExpressionBDD($mot, $bdd, $expressionDejaSimplifies, $tabExpression, $tabExpressionSingulier, $motPourAlgoWeka);
        }
        if($lettre != " ")
        {
          $texteArray = chercherExpressionBDD("", $bdd, $expressionDejaSimplifies, $tabExpression, $tabExpressionSingulier, $motPourAlgoWeka);
          $texteSimplifie .= $texteArray["retour"];
          $textePDF["texte"] .= $texteArray["PDF"]["texte"];
          $textePDF["traduction"] .= $texteArray["PDF"]["traduction"];
        }
				else if(count($tabExpression)>0)
				{
					$nbEspaceAAjouter ++;
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
              if($lettre != ' ' or count($tabExpression)==0)
              {
								while($nbEspaceAAjouter>0)
								{
									$texteSimplifie .= " ";
                	$textePDF["texte"] .= " ";
									$nbEspaceAAjouter--;
								}
                $texteSimplifie .= "$lettre";
                $textePDF["texte"] .= "$lettre";
              }
            }
          }
        }
      }
    }
    if(strlen($mot) > 0)
    {
      $texteArray = chercherExpressionBDD($mot, $bdd, $expressionDejaSimplifies, $tabExpression, $tabExpressionSingulier, $motPourAlgoWeka);
    }
    $texteArray = chercherExpressionBDD("", $bdd, $expressionDejaSimplifies, $tabExpression, $tabExpressionSingulier, $motPourAlgoWeka);
    
		//on ecrit les mots sur le serveur pour que l'algo weka puisse decouvrir de nouveaux mots difficiles
		//on recupere la valeur du compteur et on l'incremente
		$fichierCompteur = fopen('../../weka/Atraiter/compteur.var', 'r+');
		$compteur = fgets($fichierCompteur);
		$compteur += 1;
		fseek($fichierCompteur, 0);
		fputs($fichierCompteur, $compteur);
		fclose($fichierCompteur);
		$nomFichierWeka = "../../weka/Atraiter/motWeka$compteur.txt";
		file_put_contents($nomFichierWeka,$motPourAlgoWeka);
		
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
