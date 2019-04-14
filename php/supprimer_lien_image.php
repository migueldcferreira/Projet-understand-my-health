<?php
session_start();
include('verif_admin.php');
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
//Supprimer lien du mot avec une image
$id = isset($_GET['id']) ? (int) $_GET['id'] : null;
if ($id) {

	//on recupere le mot, l'id de l'image et le classement associe
	$sql = "SELECT MOT, ID_IMAGE, CLASSEMENT FROM TABLE_LIEN_MOT_IMAGE WHERE ID_LIEN = ".$id.";";
	$res = $bdd->query($sql);
	$row = $res->fetch();
  $mot = $row['MOT'];
	$id_image = $row['ID_IMAGE'];
	$classement = $row['CLASSEMENT'];

	//on met a jour les classements des autres liens de ce mot
	$sql = "UPDATE TABLE_LIEN_MOT_IMAGE SET CLASSEMENT = CLASSEMENT-1 WHERE MOT='".str_replace("'","''",$mot)."' AND CLASSEMENT >".$classement.";";
	$res = $bdd->query($sql);

  //on supprime le lien de la table
	$sql = "DELETE FROM TABLE_LIEN_MOT_IMAGE WHERE ID_LIEN = ".$id.";";
	$res = $bdd->query($sql);

	//on regarde si l'image est relie a d'autre mot que celui-ci, si ce n'est pas le cas alors on supprime l'image
  $sql = "SELECT COUNT(*) AS NB_LIEN FROM TABLE_LIEN_MOT_IMAGE WHERE ID_IMAGE = ".$id_image.";";
	$res = $bdd->query($sql);
	$row = $res->fetch();
  $nb_lien = $row['NB_LIEN'];
  if($nb_lien == 0)
  {
    $sql = "DELETE FROM TABLE_IMAGE WHERE ID_IMAGE = ".$id_image.";";
  	$res = $bdd->query($sql);
  }

	//on retourne sur la page web appelante
	$url_source=$_SERVER['HTTP_REFERER'];
	header('location: '.$url_source);
}
else{header('location: register.php'); }
?>
