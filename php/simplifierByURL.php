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
    	if(empty($_POST["testurl"]))
    	{
    		die("Veuillez insérer une URL");
    	}
	  
	//on recupere le texte a l'URL
	$textURL = file_get_contents($_POST["testurl"]);
	//on garde seulement le body de la page
      	//$textBrut = preg_replace("#^.*<body[^>]*>|</body>.*$#s" , "", $textURL);
	preg_match('#<body[^>]*>'.$textBrut.'</body>#s',$textURL);
	//$textBrut = preg_replace("#<script[^>]*>.*</script>#s" , "", $textBrut);
	//$textBrut = preg_replace("#<a[^>]*>|</a>#s" , "", $textBrut);
	//supprime la balise header et son contenu
  	//$textBrut = preg_replace("#<header[^>]*>.*</header>#s" , "", $textBrut);
	//supprime la balise footer et son contenu
  	//$textBrut = preg_replace("#<footer[^>]*>.*</footer>#s" , "", $textBrut);
	//permet de supprimer les <div> en relation avec la navigation et leur contenu
	//$textBrut = preg_replace("#<div[^>]*navigation[^>]*>(((?!<div).)*<div[^>]*>((?!</div).)*</div>((?!</*div).)*)*</div>#s","",$textBrut);
	
	$textBrut = preg_replace("#<((a[^>]*>)|(/a>)|(header[^>]*>.*</header>)|(footer[^>]*>.*</footer>))#s" , "", $textBrut);
	  
    	require_once("simplifier.php");
    	$texteSimplifie = simplifierTexteBrut($textBrut,0);
	echo $texteSimplifie;
    ?>

	  <?php include("script_menu.php"); ?>
		<script type="text/javascript" src="../javascript/afficherDefinition.js"></script>
	</body>
</html>
