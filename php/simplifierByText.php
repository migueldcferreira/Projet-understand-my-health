<!doctype html>
<html lang="fr">
  <head>
    <?php session_start();
    include("head.php"); ?>
		<link rel="stylesheet" href="../css/traduction.css" />
        <link rel="stylesheet" href="../css/simplifier.css" />
  </head>
  <body>

    <!--Container principal-->
    <?php include("menu.php"); ?>
    <br/>
   <h1 class="title"><span> Texte Simplifié </span></h1>




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
    ?>   
    

    <form method = "post" class= "export" action="export_pdf.php" target="_blank">
      <input type="hidden" id="texte" name="texte" value="<?php echo htmlspecialchars($textePDF["texte"]);?>">
      <input type="hidden" id="traduction" name="traduction" value="<?php echo $textePDF["traduction"];?>">
      <input class="btn btn-secondary" type="submit" name="simplifier" value="Export PDF">
    </form>


    <?php
	echo '<blockquote class="blockquote mx-4 my-3 text-justify"><p>';
        echo $texteSimplifie;
        echo '</p></blockquote></div>';
        //echo htmlspecialchars($textePDF["texte"]);
    ?>


	  <?php include("script_menu.php"); ?>
		<script type="text/javascript" src="../javascript/afficherDefinition.js"></script>
	  	<script type="text/javascript" src="..\javascript/tooltipsMotDifficile.js"></script>
	</body>
</html>
