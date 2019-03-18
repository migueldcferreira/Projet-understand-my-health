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


//Promouvoir
$id = isset($_GET['id']) ? (int) $_GET['id'] : null;
if ($id)
{
	//passage d'une definition a confirmer -> definition acceptee
	$sql = "UPDATE TABLE_DEFINITION SET A_CONFIRMER = 0 WHERE ID_DEFINITION= ".$id.";";
	$stmt= $bdd->query($sql);
	$stmt->execute($sql);
	
	//on cherche quel est l'id de l'utilisateur ayant soumis la definition
	$sql = "SELECT ID_UTILISATEUR_MODIF FROM TABLE_DEFINITION WHERE ID_DEFINITION=".$id.";";
	$res = $bdd->query($sql);
	$row = $res->fetch();
	$idU = $row['ID_UTILISATEUR_MODIF'];
	
	//on augmente de 1 son nombre de definition acceptee
	$sql = "UPDATE TABLE_UTILISATEUR SET NB_DEF_ACCEPTEE = NB_DEF_ACCEPTEE+1 WHERE ID_UTILISATEUR=".$idU.";";
	$res = $bdd->query($sql);
	
	header('location: admin_liste_def.php');
}

else{header('location: register.php'); }
?>
