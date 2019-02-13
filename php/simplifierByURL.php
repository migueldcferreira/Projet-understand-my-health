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
	echo '<p>';
    	if(empty($_POST["testurl"]))
    	{
    		die("Veuillez insérer une URL");
    	}
      $textForm = str_replace(array("#.*<body>#","#</body>.*#") , "", file_get_contents($_POST["testurl"]);
    	require_once("simplifier.php");
    	$texteSimplifie = simplifierTexteBrut($textForm,2);
	echo str_replace("\n","<br />",$texteSimplifie);
	echo '</p>';
    ?>

	  <?php include("script_menu.php"); ?>
		<script type="text/javascript" src="../javascript/afficherDefinition.js"></script>
	</body>
</html>
