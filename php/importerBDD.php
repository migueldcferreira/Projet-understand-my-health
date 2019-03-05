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
		echo $extension;		
		/*$ligne = "Erreur lors de l'importation du fichier";
		if ($extension == 'txt' OR $extension == 'csv' OR $extension == 'sql') 
		{
			$ligne = strtok(file_get_contents($_FILES["fichier"]["tmp_name"]),"\r\n");
		}
		else
		{
			die("Veuillez insérer un fichier avec une extension valide (.txt, .csv, .sql)");
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
	
		while ($ligne !== false)
		{
    	echo "Ligne to add= $ligne<br />";
			$ligne = strtok("\r\n");
		}*/

		php include("script_menu.php");
	?>
</body>
</html>
