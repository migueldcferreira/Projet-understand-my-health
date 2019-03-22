<!doctype html>
<html lang="fr">
  <head>
    <?php
			session_start();
			include('verif_membre.php');
			include("head.php");
		?>
    <link rel="stylesheet" href="..\css/choosetrad.css">
  </head>
	
  <body>
	<?php include("menu.php"); ?>
		
	<?php
		//gestion des erreurs
		$errors = array();
		
		//connecion a la BDD
		require('Bdd.php');
		$db = Bdd::connect("BDD_TRADOCTEUR");
		
		// Si l'utilisateur a propose une nouvelle definition
		if (isset($_POST['proposerDef']))
		{
			$USERNAME = $_POST['username'];
			$NOUVEAU_MOT = $_POST['MOT'];
			$DEFINITION = $_POST['DEFINITION'];
			if (empty($NOUVEAU_MOT))
			{
				array_push($errors, "Entrer votre nouveau mot");
			}
			if (empty($DEFINITION))
			{
				array_push($errors, "Entrer une definition");
			}
			if (count($errors) == 0)
			{

				//on determine l'id de l'utilisateur qui ajoute la definition
				$query = 'select ID_UTILISATEUR FROM TABLE_UTILISATEUR WHERE ADRESSE_MAIL = "'.$USERNAME.'"'; 
				$res = $db->query($query); 
				$row = $res->fetch(); 
				$id = $row[0]; 

				//on cherche le rang de l'utilisateur pour savoir si la definition doit etre confirmee ou non
				$confirmation = 1;
				if($_SESSION['rang'] == "membre spécialisé" OR $_SESSION['rang'] == "admin" OR $_SESSION['rang'] == "super-admin")
				{
					$confirmation = 0;
					//incrementation de son nombre de definitions acceptees
					$sql = "UPDATE TABLE_UTILISATEUR SET NB_DEF_ACCEPTEE = NB_DEF_ACCEPTEE+1 WHERE ID_UTILISATEUR=".$id.";";
					$res = $db->query($sql);
				}
				$tailleDef = strlen($DEFINITION);

				//on determine le classement de la definition selon sa taille
				$query = "SELECT COALESCE(MAX(CLASSEMENT),0) AS CLA FROM TABLE_DEFINITION WHERE MOT='".$NOUVEAU_MOT."' AND TAILLE_DEFINITION<=".$tailleDef.";";
				$res = $db->query($query);
				$row = $res->fetch();
				$classement = $row['CLA']+1;

				//on met a jour les classements des definitions du meme mot de taille superieur a cette definition
				$query = "UPDATE TABLE_DEFINITION SET CLASSEMENT = CLASSEMENT+1 WHERE MOT='".$NOUVEAU_MOT."' AND CLASSEMENT >=".$classement.";";
				$stmt= $db->prepare($query); 
				$stmt->execute(); 

				//on insere dans la table la nouvelle definition
				$query = "INSERT INTO TABLE_DEFINITION (MOT, DEFINITION, ID_UTILISATEUR_MODIF, TAILLE_DEFINITION, CLASSEMENT, A_CONFIRMER) VALUES ('".$NOUVEAU_MOT."' ,'".str_replace("'","''",$DEFINITION)."', ".$id.", ".$tailleDef.", ".$classement.", ".$confirmation.") ;";
				$stmt= $db->prepare($query); 
				$stmt->execute(); 

			}
		}
	?>
		
	<div class="header form_head bg-success">
		<h2> Proposer l'ajout d'une nouvelle définition</h2>
	</div>

	<form method="post" action="proposer_definition_mot.php" class = "formulaire_stylise">
  	<?php include('errors.php');?>
  	<div class="input-group">
  		<label>Mot : </label>
  		<input type="text" name="MOT" >
  	</div>
  	<div class="form-group">
  		<label>Definition : </label>
  		<textarea class="form-control" type="text" name="DEFINITION" rows="3"></textarea>
  	</div>
    <div class="input-group">
      <input type="hidden" name="username" value= "<?php echo $_SESSION['username']; ?>">
    </div>
  	<div class="input-group form-group">
  		<button type="submit" class="btn btn-success btn-sm"  name="proposerDef">Proposer</button>
  	</div>




	<?php include("script_menu.php"); ?>

  </body>
</html>

