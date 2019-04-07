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
    $ouverture=opendir($chemin_dossier);
    $fichier=readdir($ouverture); //pour ne pas supprimer "."
    $fichier=readdir($ouverture); //pour ne pas supprimer ".."
    while ($fichier=readdir($ouverture))
    {
      unlink("$chemin_dossier/$fichier");
    }
    closedir($ouverture);

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

		$sdl = "select ID_UTILISATEUR FROM TABLE_UTILISATEUR WHERE ADRESSE_MAIL = '".$_SESSION['username']."';";
		$res = $bdd->query($sdl);
		$row = $res->fetch();
		$id = $row['ID_UTILISATEUR'];

		$nbLigne = 0;
		$nbErreurSep = 0;
    $ajoutTable = 0;
    $tab_image = array();

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



		//incrementation du compteur de def acceptee
		if($compacte == 1)
		{
			$sql = "UPDATE TABLE_UTILISATEUR SET NB_DEF_ACCEPTEE = NB_DEF_ACCEPTEE+".$ajoutTable." WHERE ID_UTILISATEUR=".$id.";";
			$res = $bdd->query($sql);
		}

		//echo "Mon id : $id <br/>";
		echo "Nombre de lignes traitées : $nbLigne <br/>";
		echo "Nombre de défitions ajoutées à la table : $ajoutTable <br/>";
		echo "Nombre de lignes ayant une erreur de syntaxe : $nbErreurSep <br/><br/>";
		echo $text;

    //test affichage tableau $tab_image
    foreach ($tab_image as $image)
    {
      echo "Image : ".$image["nom_image"]." <br/>";
      foreach ($image["liste_mot"] as $mot)
      {
        echo "----Mot : ".$mot." <br/>";
      }
      echo "<br/><br/>";
    }

		include("script_menu.php");
	?>
</body>
</html>
