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

    //verification de l'importation sans erreur
    if ($_FILES['fichier']['error'] > 0)
    {
      $phpFileUploadErrors = array(
          0 => 'There is no error, the file uploaded with success',
          1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
          2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
          3 => 'The uploaded file was only partially uploaded',
          4 => 'No file was uploaded',
          6 => 'Missing a temporary folder',
          7 => 'Failed to write file to disk.',
          8 => 'A PHP extension stopped the file upload.',
      );
      die("Erreur lors du transfert : ".$phpFileUploadErrors[$_FILES['fichier']['error']]);
    }

		//verification de l'extension du fichier en entre
		$extension = substr($_FILES['fichier']['name'], -6, 6);
		if ($extension != 'tar.gz')
		{
      die("Veuillez insérer une archive avec une extension valide (.tar.gz)");
		}

    //definition des differents noms utilises
    $chemin_dossier = "../../import_img/";
    $nom_tar = $chemin_dossier . "archive_image.tar";
    $nom_archive = $nom_tar . ".gz";
    $nom_fichier_txt = $chemin_dossier . "images.txt";

    //on vide le dossier qui va comptenir l'archive
		$fichiers = glob($chemin_dossier . '/*');
		foreach($fichiers as $fichier)
		{
			//permet de ne pas supprimer les dossiers
			if(is_file($fichier))
			{
				unlink($fichier);
			}
		}

    //on copie l'archive sur le serveur
    $resultat = move_uploaded_file($_FILES['fichier']['tmp_name'],$nom_archive);
    if (!$resultat)
    {
      die("Erreur lors du deplacement de l'archive");
    }

    //on decompresse l'archive
    $p = new PharData($nom_archive);
    $p->decompress(); // cree $nom_tar

    $phar = new PharData($nom_tar);
    $phar->extractTo($chemin_dossier);

    //on lit le fichier comptenant les informations sur les images
    $fichier_txt = file_get_contents($nom_fichier_txt);
    if(!$fichier_txt)
    {
      die("Impossible de lire le fichier images.txt");
    }

    $ligne = strtok($fichier_txt,"\r\n");

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

		//on recupere l'id de l'admin qui fait l'import d'image
		$sdl = "select ID_UTILISATEUR FROM TABLE_UTILISATEUR WHERE ADRESSE_MAIL = '".$_SESSION['username']."';";
		$res = $bdd->query($sdl);
		$row = $res->fetch();
		$id = $row['ID_UTILISATEUR'];

		$nbLigne = 0;
		$nbErreurImg = 0;
    $ajoutTable = 0;
		$text = "<br/>Traitement :<br/><br/>";
    $tab_image = array();

		//on recupere un tableau qui fait correspondre chaque mot ou expression a une image
		while ($ligne !== false)
		{
			$champs = preg_split("#[|]#",$ligne);
      //on ne prend pas en compte les sauts de ligne
      if(count($champs) == 2)
      {
        $nbLigne += 1;
        $absent_tab_image = 1;
        foreach($tab_image as &$image)
        {
          if($image["nom_image"] == $champs[1])
          {
            array_push($image["liste_mot"],$champs[0]);
            $absent_tab_image = 0;
            break;
          }
        }
        if($absent_tab_image == 1)
        {
          array_push($tab_image,array("nom_image" => $champs[1],"liste_mot" => array($champs[0])));
        }
      }
      $ligne = strtok("\r\n");
    }

	
		//ajout des images et des liens avec les expressions dans la BDD
    foreach ($tab_image as $image)
    {
      echo "Image : ".$image["nom_image"]." <br/>";
			//on test si l'image existe bien
			if(!file_exists($chemin_dossier.$image["nom_image"]))
			{
				//on passe a l'image suivante
				$nbErreurImg++;
				echo "L'image '".$chemin_dossier.$image["nom_image"]."' est introuvable.<br/>";
				continue;
			}
			
			//on recupere l'image dans le dossier
			try{
			$image = addslashes(file_get_contents($chemin_dossier.$image["nom_image"]));
			$type = filetype($chemin_dossier.$image["nom_image"]);
			$taille = filesize($chemin_dossier.$image["nom_image"]);
			
			
			//on determine l'id de l'image
			$sql = "SELECT COALESCE(MIN(ID_IMAGE)+1,1) AS ID FROM TABLE_IMAGE WHERE ID_IMAGE+1 NOT IN (SELECT ID_IMAGE FROM TABLE_IMAGE);";
			$res = $bdd->query($sql);
			$row = $res->fetch();
			$id_image = $row['ID'];

			//on ajoute l'image a la bdd
			$sql = "INSERT INTO TABLE_IMAGE (ID_IMAGE, IMAGE, TAILLE, TYPE, ID_UTILISATEUR_MODIF, A_CONFIRMER) VALUES (".$id_image.", '".$image."', ".$taille.", '".$type."', ".$id.", 0) ;";
			$res = $bdd->query($sql);
			
			//pour chaque mot/expression defini par l'image
      foreach ($image["liste_mot"] as $mot)
      {
        echo "----Mot : ".$mot." <br/>";
				//on determine le classement selon le nombre d'image deja presente pour definir ce mot
				$sql = "SELECT COALESCE(MAX(CLASSEMENT),0) AS CLA FROM TABLE_LIEN_MOT_IMAGE WHERE MOT='".$mot."';";
				$res = $bdd->query($sql);
				$row = $res->fetch();
				$classement = $row['CLA']+1;
				
				//on determine l'id du lien
				$sql = "SELECT COALESCE(MIN(ID_LIEN)+1,1) AS ID FROM TABLE_LIEN_MOT_IMAGE WHERE ID_LIEN+1 NOT IN (SELECT ID_LIEN FROM TABLE_LIEN_MOT_IMAGE);";
				$res = $bdd->query($sql);
				$row = $res->fetch();
				$id_lien = $row['ID'];
				
				//on ajoute le lien entre l'image et les mots saisies
				$sql = "INSERT INTO TABLE_LIEN_MOT_IMAGE (ID_LIEN, MOT, ID_IMAGE, CLASSEMENT) VALUES (".$id_lien.", '".$mot."' ,".$id_image.", ".$classement.") ;";
				$res = $bdd->query($sql);
				}
				catch (Exception $e)
				{
					echo 'Erreur : ' . $e->getMessage();
				}
				$ajoutTable ++;
      }
      echo "<br/><br/>";
    }

		//incrementation du compteur de def acceptee
		$sql = "UPDATE TABLE_UTILISATEUR SET NB_DEF_ACCEPTEE = NB_DEF_ACCEPTEE+".$ajoutTable." WHERE ID_UTILISATEUR=".$id.";";
		$res = $bdd->query($sql);

		//echo "Mon id : $id <br/>";
		echo "<br />Nombre de lignes traitées : $nbLigne <br/>";
		echo "Nombre de défitions ajoutées à la table : $ajoutTable <br/>";
		echo "Nombre d'image non presente dans la table : $nbErreurImg <br/><br/>";
		echo $text;

    

		include("script_menu.php");
	?>
</body>
</html>
