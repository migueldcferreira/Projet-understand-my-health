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
	//on recupere le texte a l'URL
	$textURL = file_get_contents($_POST["testurl"]);
	//on garde seulement le body de la page
      	$textBrut = preg_replace("#^.*<body[^>]*>|</body>.*$#s" , " ", $textURL);
	echo $textBrut;
  
    	require_once("simplifier.php");
    	$texteSimplifie = simplifierTexteBrut($textBrut,0);
	echo preg_replace("\n","<br />",$texteSimplifie);
	echo '</p>';
    ?>

	  <?php include("script_menu.php"); ?>
		<script type="text/javascript" src="../javascript/afficherDefinition.js"></script>
	</body>
</html>
