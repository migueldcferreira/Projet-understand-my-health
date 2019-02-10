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
	echo "1";
    	if(empty($_POST["testtext"]))
    	{
    		die("Veuillez insérer du texte à simplifier");
    	}
	echo "2";
    	$textForm=str_split($_POST["testtext"]);
	echo "2";
    	require_once("simplifier.php");
	echo "2";
    	simplifierTexteBrut($textForm,0);
	echo "3";
	echo "Fin du texte simplifié";
    ?>

	  <?php include("script_menu.php"); ?>
		<script type="text/javascript" src="../javascript/afficherDefinition.js"></script>
	</body>
</html>
