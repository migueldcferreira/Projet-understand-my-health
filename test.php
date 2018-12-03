<?php 
$textform=$_POST["testtext"];
$liste= array("rhume", "gastro", "gastro-entérite", "pneumonie");
$i=0;
$listeMotsTrouves=array();
$nbMotsTrouves=0;
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
}
?>