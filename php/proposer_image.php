<!doctype html>
<html lang="fr">
<head>
	<?php
		session_start();
		include("verif_membre.php");
		include("head.php");
	?>

	<link rel="stylesheet" href="..\css/choosetrad.css">
</head>
	
<body>
	<?php include("menu.php"); ?>
	
	<?php
		$TAILLE_MAX = 5000000;
		$errors = array();
		require('Bdd.php');
	
		//si le membre a appuye sur le bouton "proposer"
		if(isset($_POST['proposerImage']))
		{
			//on verifie que le champ du mot n'est pas vide
			$mot = $_POST['MOT'];
			if(empty($mot))
			{
				array_push($errors, "Veuillez entrer un mot");
			}
			
			//on verifie si on a bien recupere l'image
			$verifImage = false;
			$verifImage = is_uploaded_file($_FILES['IMAGE']['tmp_name']);
			if(!$verifImage)
			{
				array_push($errors, "Erreur lors de l'upload de l'image");
			}
			
			//on s'assure que la taille de l'image est bien inferieur a la taille maximale
			$taille = $_FILES['IMAGE']['size'];
			if($taille > $TAILLE_MAX)
			{
				array_push($errors, "Image trop grosse");
			}
			
			$image = addslashes(file_get_contents($_FILES['IMAGE']['tmp_name']));
			$type = $_FILES['IMAGE']['type'];									
			
			//si il n'y a pas eu d'erreur dans le remplissage du formulaire
			if(count($errors) == 0)
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
				
				//on recupere l'id de l'utilisateur
				$sdl = "select ID_UTILISATEUR FROM TABLE_UTILISATEUR WHERE ADRESSE_MAIL = '".$_SESSION['username']."';"; 
				$res = $bdd->query($sdl); 
				$row = $res->fetch(); 
				$id = $row['ID_UTILISATEUR'];
				
				//on cherche le rang de l'utilisateur pour savoir si la definition doit etre confirmee ou non
				$confirmation = 1;
				if($_SESSION['rang'] == "membre spécialisé" OR $_SESSION['rang'] == "admin" OR $_SESSION['rang'] == "super-admin")
				{
					$confirmation = 0;
					//incrementation de son nombre de definitions acceptees
					$sql = "UPDATE TABLE_UTILISATEUR SET NB_DEF_ACCEPTEE = NB_DEF_ACCEPTEE+1 WHERE ID_UTILISATEUR=".$id.";";
					$res = $bdd->query($sql);
				}
			
				//on determine l'id de l'image
				$sql = "SELECT COALESCE(MIN(ID_IMAGE)+1,1) AS ID FROM TABLE_IMAGE WHERE ID_IMAGE+1 NOT IN (SELECT ID_IMAGE FROM TABLE_IMAGE);"
				$res = $bdd->query($sql);
				$row = $res->fetch();
				$id_image = $row['ID'];
				
				//on ajoute l'image a la bdd
				$sql = "INSERT INTO TABLE_IMAGE (ID_IMAGE, IMAGE, TAILLE, TYPE, ID_UTILISATEUR_MODIF, A_CONFIRMER) VALUES (".$id_image.", '".$image."', ".$taille.", '".$type."', ".$id.", ".$confirmation.") ;";
				$res = $bdd->query($sql);
				
				//a faire pour chaque mot defini par l'image
				
				//on determine le classement selon le nombre d'image deja presente pour definir ce mot
				$sql = "SELECT COALESCE(MAX(CLASSEMENT),0) AS CLA FROM TABLE_LIEN_MOT_IMAGE WHERE MOT='".$mot."';";
				$res = $bdd->query($sql);
				$row = $res->fetch();
				$classement = $row['CLA']+1;
				
				//on determine l'id du lien
				$sql = "SELECT COALESCE(MIN(ID_LIEN)+1,1) AS ID FROM TABLE_LIEN_MOT_IMAGE WHERE ID_LIEN+1 NOT IN (SELECT ID_LIEN FROM TABLE_LIEN_MOT_IMAGE);"
				$res = $bdd->query($sql);
				$row = $res->fetch();
				$id_lien = $row['ID'];
				
				//on ajoute le lien entre l'image et les mots saisies
				$sql = "INSERT INTO TABLE_LIEN_MOT_IMAGE (ID_LIEN, MOT, ID_IMAGE, CLASSEMENT) VALUES (".$id_lien.", '".$mot."' ,".$id_image.", ".$classement.") ;";
				$res = $bdd->query($sql);
			}
		}
	?>
	
	<div class="header form_head bg-success">
		<h2> Proposer l'ajout d'une nouvelle image</h2>
	</div>

	<form enctype="multipart/form-data" method="post" action="proposer_image.php" class = "formulaire_stylise">
		<?php include("errors.php");?>
		<div class="input-group">
			<label>Mot : </label>
			<input type="text" name="MOT" >
		</div>
		<div class="form-group">
			<label>Image : </label>
			<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $TAILLE_MAX; ?>" />
			<input type="file" name="IMAGE" id="js-upload-files" multiple aria-describedby="fileHelp" accept=".png,.jpg,.jpeg">
		</div>
		<div class="input-group form-group">
			<button type="submit" class="btn btn-success btn-sm"  name="proposerImage">Proposer</button>
		</div>




	<?php include("script_menu.php"); ?>

</body>
</html>
