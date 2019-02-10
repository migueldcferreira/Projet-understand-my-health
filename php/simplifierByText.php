<!doctype html>
<html lang="fr">
  <head>
    <?php include("head.php"); ?>
		<link rel="stylesheet" href="../css/traduction.css" />
  </head>
  <body>

    <!--Container principal-->
    <?php include("menu.php"); ?>
    <?php
	echo '<pre>';
    	if(empty($_POST["testtext"]))
    	{
    		die("Veuillez insérer du texte à simplifier");
    	}
    	$textForm=str_split($_POST["testtext"]);
    	require_once("simplifier.php");
    	echo simplifierTexteBrut($textForm,0);
	echo '</pre>';
    ?>

	  <?php include("script_menu.php"); ?>
		<script type="text/javascript" src="../javascript/afficherDefinition.js"></script>
	</body>
</html>
