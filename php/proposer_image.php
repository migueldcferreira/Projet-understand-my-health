<!doctype html>
<html lang="fr">
<head>
	<?php
		include('Bdd_inscription.php');
		include('verif_membre.php');
		include("head.php");
	?>

	<link rel="stylesheet" href="..\css/choosetrad.css">
</head>
	
<body>
	<?php include("menu.php"); ?>
	<div class="header form_head bg-success">
		<h2> Proposer l'ajout d'une nouvelle image</h2>
	</div>

	<form enctype="multipart/form-data" method="post" action="proposer_definition_mot.php" class = "formulaire_stylise">
		<?php include('errors.php');?>
		<div class="input-group">
			<label>Mot : </label>
			<input type="text" name="MOT" >
		</div>
		<div class="form-group">
			<label>Image : </label>
			<input type="hidden" name="MAX_FILE_SIZE" value="250000" />
			<input type="file" name="IMAGE" id="js-upload-files" multiple aria-describedby="fileHelp" accept=".png,.jpg,.jpeg">
		</div>
		<div class="input-group form-group">
			<button type="submit" class="btn btn-success btn-sm"  name="proposerDef">Proposer</button>
		</div>




	<?php include("script_menu.php"); ?>

</body>
</html>
