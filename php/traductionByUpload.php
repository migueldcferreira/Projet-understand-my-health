<!doctype html>
<html lang="fr">
  <head>
    <?php include("head.php"); ?>
		<link rel="stylesheet" href="../css/traduction.css" />
  </head>
  <body>

    <!--Container principal-->
    <div class="container-fluid">
      <?php include("menu.php"); ?>

<?php
	/*****
		Copyright (c) 2016, Christian Vigh.
		All rights reserved.

		J'utilise la classe "PdfToText.phpclass" appartenant à Christian Vigh pour pouvoir obtenir le texte provenant d'un fichier pdf grâce à la l'instanciation d'un
		objet de la classe PdfToText.
	******/
	include ( 'PdfToText.phpclass' );
	$extension = substr($_FILES['fichier']['name'], -3, 3);
	if ($extension == 'pdf') 
	{
		$pdf 	=  new PdfToText($_FILES["fichier"]["tmp_name"]) ;
		$pdf = str_replace( array( '?', ',', '.', ':', '!', '\''), ' ', $pdf ); 

		$mot = strtok($pdf, " \n\t.");
	}
	elseif ($extension == 'txt')
	{
		$textform = file_get_contents($_FILES["fichier"]["tmp_name"]);
		$textform = str_replace( array( '?', ',', '.', ':', '!', '\''), ' ', $textform ); 
		$mot = strtok($textform, " \n\t.");
	}

	$liste= array("rhume", "gastro", "gastro-entérite", "pneumonie");
	$definition= array("Le rhume est causé par un virus. C'est une infection fréquente du nez et de la gorge nommée aussi rhinite virale ou aiguë.",
					   "Abréviation de gastro-entérite, maladie qui résulte de l'inflammation de l'estomac ou des intestins due à un virus. Le malade souffre alors d'une diarrhée plus ou moins sévère.",
					   "Gastro-entérite désigne une inflammation simultanée de la muqueuse de l'estomac et de celle des intestins.",
					   " La pneumonie est une infection des poumons causée le plus souvent par un virus ou une bactérie.");
	

	
	$i=0;
	$listeMotsTrouves=array();
	$nbMotsTrouves=0;


	while ($mot !== false)
	{
		$indice = -1;
		while($i<4)
		{
			if (strcasecmp($mot, $liste[$i])==0)
			{
				$indice = $i;
				//echo("le mot " . $liste[$i] . " a ete trouve dans votre chaine de caractere <br />");
				//On ajoute le mot de notre $liste[] dans la liste des mots trouv�es
				$listeMotsTrouves[]=$liste[$i];
				//echo("on place le mot dans une liste de mots trouves" . $listeMotsTrouves[$nbMotsTrouves] . "<br />");
				$nbMotsTrouves++;
			}
			$i++;
		}
		if($indice != -1)
		{
			echo '<span class="vocabulaire">
							<span class="expression">'.$mot.'</span>
							<span class="definition hidden">'.$definition[$indice].'</span>
						</span>';
		}
		else
		{
			echo "$mot ";
		}
		$mot = strtok(" \n\t.");
		$i=0;
	}

?>

		</div>
		<?php include("script_menu.php"); ?>
		<script type="text/javascript" src="../javascript/afficherDefinition.js"></script>
	</body>
</html>
