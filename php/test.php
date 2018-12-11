<?php 
	$textform=$_POST["testtext"];
	$liste= array("rhume", "gastro", "gastro-entérite", "pneumonie");
	$i=0;
	$listeMotsTrouves=array();
	$nbMotsTrouves=0;

	$mot = strtok($textform, " \n\t");

	while ($mot !== false)
	{
		echo "Word=$mot<br />";
		while($i<4)
		{
			if (strcasecmp($mot, $liste[$i])==0)
			{
				echo("le mot " . $liste[$i] . " a ete trouve dans votre chaine de caractere <br />");
				//On ajoute le mot de notre $liste[] dans la liste des mots trouvées 
				$listeMotsTrouves[]=$liste[$i];
				echo("on place le mot dans une liste de mots trouves" . $listeMotsTrouves[$nbMotsTrouves] . "<br />");
				$nbMotsTrouves++;
			}
			$i++;
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

			//On ajoute le mot de notre $liste[] dans la liste des mots trouvées 
			$listeMotsTrouves[]=$liste[$i];
			echo "</br>";
			echo($listeMotsTrouves[$nbMotsTrouves]);
			$nbMotsTrouves++;
		}
		$i++;
	}*/
?>