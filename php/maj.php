<?php
	$monfichier = fopen('../../maj.txt', 'r+');
	fputs($monfichier, '1');
	fclose($monfichier);
	header('location:accueil.php');
?>
