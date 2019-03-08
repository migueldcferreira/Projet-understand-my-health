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
      echo $texteSimplifie;
	    echo '</div>';
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
