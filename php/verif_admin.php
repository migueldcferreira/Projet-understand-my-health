<?php 
if(empty($_SESSION['username']) || !($_SESSION['rang']=="super-admin" || $_SESSION['rang']=="admin" ))
{
	header('location: accueil.php');
	exit();
}
?>