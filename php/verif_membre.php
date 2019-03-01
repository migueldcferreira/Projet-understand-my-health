<?php 
if(empty($_SESSION['username']))
{
	header('location: accueil.php');
	exit();
}
?>