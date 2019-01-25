<?php
	$monfichier = fopen('../../maj.txt', 'r+');
	fputs($monfichier, '2');
	fclose($monfichier);
	header('location:accueil.php');
?>
