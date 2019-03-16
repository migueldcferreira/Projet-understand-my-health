<!doctype html>
<html lang="fr">
  <head>
  	<?php session_start();
     include("head.php"); ?>
		<link rel="stylesheet" href="../css/traduction.css" />
		<link rel="stylesheet" href="../css/simplifier.css" />
  </head>
    <!--Container principal-->
    <?php include("menu.php"); ?>
    <br/>
    <h1 class="title"><span> Texte Simplifié </span></h1>
    <?php
    	if(empty($_POST["testurl"]))
    	{
    		die("Veuillez insérer une URL");
    	}
	  
	//on recupere le texte a l'URL
	$textURL = file_get_contents($_POST["testurl"]);
	//on garde seulement le body de la page
      	//$textBrut = preg_replace("#^.*<body[^>]*>|</body>.*$#s" , "", $textURL);
	preg_match("#<body[^>]*>.*</body>#s",$textURL,$match);
	$textBrut = preg_replace("#<body[^>]*>#s","<body>",$match[0],1);
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
	$time_start = time();	
    $texteSimplifieArray = simplifierTexteBrut($textBrut,0);
    $texteSimplifie = $texteSimplifieArray["retour"];
    $textePDF = $texteSimplifieArray["PDF"];
	$time_end = time();
	$timer = $time_end - $time_start;
	echo $timer;
	?>
	<form method = "post" class = "export" action="export_pdf.php" target="_blank">
	  <input type="hidden" id="texte" name="texte" value="<?php echo htmlspecialchars($textePDF["texte"]);?>">
	  <input type="hidden" id="traduction" name="traduction" value="<?php echo $textePDF["traduction"];?>">
	  <input type="submit" name="simplifier" value="Export PDF">
	</form>
	<?php
	echo $texteSimplifie;
    ?>

   
	  <?php include("script_menu.php"); ?>
		<script type="text/javascript" src="../javascript/afficherDefinition.js"></script>
		<script type="text/javascript" src="..\javascript/tooltipsMotDifficile.js"></script>
</html>
