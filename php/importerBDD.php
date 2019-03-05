<!doctype html>
<html lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<?php
		session_start();
		include('verif_admin.php'); 
		include("head.php");
	?>
  <link rel="stylesheet" href="..\css/choosetrad.css">
</head>

<body>
	<?php 
		include("menu_admin.php");
		require('Bdd.php');

		//verification de l'extension du fichier en entre
		$extension = substr($_FILES['fichier']['name'], -3, 3);
		$ligne = "Erreur lors de l'importation du fichier";
		if ($extension == 'txt' OR $extension == 'csv' OR $extension == 'sql') 
		{
			$ligne = strtok(file_get_contents($_FILES["fichier"]["tmp_name"]),"\r\n");
		}
		else
		{
			die("Veuillez insérer un fichier avec une extension valide (.txt, .csv, .sql)");
		}

		if(isset($_POST["formeCompacte"]))
		{
			$compacte = 1;
		}
		else
		{
			$compacte = 0;
		}
	
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
	
		$sdl = "select ID_UTILISATEUR FROM TABLE_UTILISATEUR WHERE ADRESSE_MAIL = '".$_SESSION['username']."';"; 
		$res = $bdd->query($sdl); 
		$row = $res->fetch(); 
		$id = $row['ID_UTILISATEUR']; 
	
		$nbLigne = 0;
		$presentTable = 0;
		$ajoutTable = 0;
		$nbErreurSep = 0;
		$text = "";
		
		while ($ligne !== false)
		{
			$nbLigne += 1;
			$champs = preg_split("#[|]#",$ligne);
			
			if($compacte == 1)
			{
				if(count($champs)!= 3)
				{
					$text .= "Erreur separateurs ligne $nbLigne : $ligne";
					$text .= "<br />";
					$nbErreurSep += 1;
				}
				else
				{
					$sql = "SELECT COUNT(*) AS NB FROM TABLE_DEFINITION WHERE MOT='".$champs[0]."' AND DEFINITION='".str_replace("'","''",$champs[1])."';";
					$res = $bdd->query($sql);
					$row = $res->fetch();
					if($row['NB'] == 0)
					{
						$tailleDef = strlen($champs[1]);
						
						//on determine le classement de la definition selon sa taille
						$sql = "SELECT NVL(MAX(CLASSEMENT),0) AS CLA FROM TABLE_DEFINITION WHERE MOT='".$champs[0]."' AND TAILLE_DEFINITION<=".$tailleDef.";";
						$res = $bdd->query($sql);
						$row = $res->fetch();
						$classement = $row['CLA']+1;
						
						//on met a jour les classements des definitions du meme mot de taille superieur a cette definition
						$sql = "UPDATE TABLE_DEFINITION SET CLASSEMENT = CLASSEMENT+1 WHERE MOT='".$champs[0]."' AND CLASSEMENT >=".$classement.";";
						$res = $bdd->query($sql);
						
						//on insere dans la table la nouvelle definition
						$sql = "INSERT INTO TABLE_DEFINITION (MOT, DEFINITION, METHODE, ID_UTILISATEUR_MODIF, TAILLE_DEFINITION, CLASSEMENT) VALUES ('".$champs[0]."' ,'".str_replace("'","''",$champs[1])."', '".$champs[2]."', ".$id.", ".$tailleDef.", ".$classement.") ;";
						$res = $bdd->query($sql);
						
						$ajoutTable += 1;
					}
					else
					{
						$presentTable += 1;
					}
				}
			}
			else
			{
				if(count($champs)!= 8)
				{
					$text .= "Erreur separateurs ligne $nbLigne : $ligne";
					$text .= "<br />";
					$nbErreurSep += 1;

				}
				else
				{
				}
			}	
			
			$ligne = strtok("\r\n");			
		}

		//echo "Mon id : $id <br/>";
		echo "Nombre de lignes traitées : $nbLigne <br/>";
		echo "Nombre de défitions ajoutées à la table : $ajoutTable <br/>";
		echo "Nombre de définitions déjà présentes dans la table : $presentTable <br/>";
		echo "Nombre de lignes ayant une erreur de syntaxe : $nbErreurSep <br/><br/>"; 
		echo $text;
	
		include("script_menu.php");
	?>
</body>
</html>
