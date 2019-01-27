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

	if(empty($_POST["testtext"]))
	{
		die("Veuillez insérer du texte à simplifier");
	}
	require('Bdd.php');
	
	try
	{
		$bdd = Bdd::connect("BDD_TRADOCTEUR");
		$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Permet de récuperer une exception lorsque il y a une erreur au niveau de la base de donnée.
																	   //On pourra donc traiter l'erreur plus simplement avec un try et catch.
	}
	catch (Exception $e)
	{
			die('Erreur : ' . $e->getMessage());
	}
	
	$textform=$_POST["testtext"];
	/*$liste= array("rhume", "gastro", "gastro-entérite", "pneumonie");
	$definition= array("Le rhume est causé par un virus. C'est une infection fréquente du nez et de la gorge nommée aussi rhinite virale ou aiguë.",
										"Abréviation de gastro-entérite, maladie qui résulte de l'inflammation de l'estomac ou des intestins due à un virus. Le malade souffre alors d'une diarrhée plus ou moins sévère.",
									 	"Gastro-entérite désigne une inflammation simultanée de la muqueuse de l'estomac et de celle des intestins.",
										" La pneumonie est une infection des poumons causée le plus souvent par un virus ou une bactérie.");
	*/
	$listeMotsTrouves=array();
	$nbMotsTrouves=0;

	$textform = str_replace( array( '?', ',', '.', ':', '!', '\''), ' ', $textform );

	$mot = strtok($textform, " \n\t");

	while ($mot !== false)
	{
		$sql = "SELECT DEFINITION FROM TABLE_DEFINITION WHERE MOT LIKE '$mot';";
		$res = $bdd->query($sql); //On récupère (s'il en existe) les lignes de notre table "produits" qui répondent à notre requête $sql. 
								  //Ces lignes sont stockées dans la variables $res qui est un tableau du jeu de résultat de notre requête.

		if(!empty($row = $res->fetch())) //La méthode fetch() permet de récupérer la ligne suivante du résultat de notre requete qui sont stockés dans la variable $res. 
		{
			/*while (!empty($row))
			{*/
				echo '<span class="vocabulaire">
							<span class="expression">'.$mot.'</span>
							<span class="definition hidden">'.$row['DEFINITION'].'</span>
						</span>';
				$row = $res->fetch();
			//}
		}
		else
		{
			echo "$mot ";
		}
		$mot = strtok(" \n\t");
	}
?>

		</div>
		<?php include("script_menu.php"); ?>
		<script type="text/javascript" src="../javascript/afficherDefinition.js"></script>
	</body>
</html>
