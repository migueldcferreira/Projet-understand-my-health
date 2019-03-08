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
	echo '<div>';
    	if(empty($_POST["testtext"]))
    	{
    		die("Veuillez insérer du texte à simplifier");
    	}
    	$textForm=str_split($_POST["testtext"]);
    	require_once("simplifier.php");
        $texteSimplifieArray = simplifierTexteBrut($textForm,0,true);
    	$texteSimplifie = $texteSimplifieArray["retour"];
        $textePDF = $texteSimplifieArray["PDF"];
	//echo str_replace("\n","<br />",$texteSimplifie);

	echo $texteSimplifie;
	echo '</div>';
    //echo htmlspecialchars($textePDF["texte"]);
    
    ?>
    <form method = "post" action="export_pdf.php" target="_blank">
      <input type="hidden" id="texte" name="texte" value="<?php echo htmlspecialchars($textePDF["texte"]);?>">
      <input type="hidden" id="traduction" name="traduction" value="<?php echo $textePDF["traduction"];?>">
      <input type="submit" name="simplifier" value="Export PDF">
    </form>

	  <?php include("script_menu.php"); ?>
		<script type="text/javascript" src="../javascript/afficherDefinition.js"></script>
	</body>
</html>
