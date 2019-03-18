<?php 
if(empty($_SESSION['username']) || !($_SESSION['rang']=="super-admin"))
{
	header('location: accueil.php');
	exit();
}
?>