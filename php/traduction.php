<!doctype html>
<html lang="fr">
  <head>
    <?php include("head.php"); ?>
  </head>
  <body>

    <!--Container principal-->
    <div class="container-fluid">
      <?php include("menu.php"); ?>

<?php
	$textform=$_POST["testtext"];
	$liste= array("rhume", "gastro", "gastro-entérite", "pneumonie");
	$definition= array("Le rhume est causé par un virus. C'est une infection fréquente du nez et de la gorge nommée aussi rhinite virale ou aiguë.",
										"Abréviation de gastro-entérite, maladie qui résulte de l'inflammation de l'estomac ou des intestins due à un virus. Le malade souffre alors d'une diarrhée plus ou moins sévère.",
									 	"Gastro-entérite désigne une inflammation simultanée de la muqueuse de l'estomac et de celle des intestins.",
										" La pneumonie est une infection des poumons causée le plus souvent par un virus ou une bactérie.");
	$i=0;
	$listeMotsTrouves=array();
	$nbMotsTrouves=0;

	$mot = strtok($textform, " \n\t");

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
			echo '<p class="vocabulaire">
							<p class="expression">'.$mot.'</p>
							<p class="definition">'.$definition[$indice].'</p>
						</p>';
		}
		else
		{
			echo "$mot ";
		}
		$mot = strtok(" \n\t");
		$i=0;
	}



	/*
	********
	Test 1
	********
	while($i<4)
	{
		if(strpos($textform, $liste[$i])!==false)
		{
			echo("le mot " . $liste[$i] . " a ete trouve dans votre chaine de caractere");

			//On ajoute le mot de notre $liste[] dans la liste des mots trouv�es
			$listeMotsTrouves[]=$liste[$i];
			echo "</br>";
			echo($listeMotsTrouves[$nbMotsTrouves]);
			$nbMotsTrouves++;
		}
		$i++;
	}*/
?>

		</div>
		<?php include("script_menu.php"); ?>
	</body>
</html>
