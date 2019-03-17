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
      /*****
        Copyright (c) 2016, Christian Vigh.
        All rights reserved.
        Utilisation de la classe "PdfToText.phpclass" appartenant à Christian Vigh pour pouvoir obtenir le texte provenant d'un fichier pdf grâce à la l'instanciation d'un
        objet de la classe PdfToText.
	    ******/
	    include ( 'PdfToText.phpclass' );
      
	    echo '<div>';
      $extension = substr($_FILES['fichier']['name'], -3, 3);
      $texteForm = "Erreur lors de l'import du fichier";
      if ($extension == 'pdf') 
      {
        $pdf = new PdfToText($_FILES["fichier"]["tmp_name"]);
        $textForm = str_split($pdf);
      }
      elseif ($extension == 'txt')
      {
        $textForm = str_split(file_get_contents($_FILES["fichier"]["tmp_name"]));
      }
    	else
    	{
    		die("Veuillez insérer un fichier avec une extension valide");
    	}
      
    	require_once("simplifier.php");
      $texteSimplifieArray = simplifierTexteBrut($textForm,0,true);
      $texteSimplifie = $texteSimplifieArray["retour"];
      $textePDF = $texteSimplifieArray["PDF"];
    ?>
  <form method = "post" class = "export" action="export_pdf.php" target="_blank">
    <input type="hidden" id="texte" name="texte" value="<?php echo htmlspecialchars($textePDF["texte"]);?>">
    <input type="hidden" id="traduction" name="traduction" value="<?php echo $textePDF["traduction"];?>">
    <input class="btn btn-secondary" type="submit" name="simplifier" value="Export PDF">
  </form>
  <?php
      echo '<blockquote class="blockquote mx-4 my-3 text-justify" style="line-height:200%"><p>';
      echo $texteSimplifie;
      echo '</p></blockquote></div>';
  ?>
	  <?php include("script_menu.php"); ?>
		<script type="text/javascript" src="../javascript/afficherDefinition.js"></script>
	  	<script type="text/javascript" src="..\javascript/tooltipsMotDifficile.js"></script>

	</body>
</html>
