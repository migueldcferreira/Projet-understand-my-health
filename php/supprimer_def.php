<?php

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


//Supprimer definition
$suppr = 'supprimer';
if (isset($_GET['id'])) {
	$supprimerID = is_int($_GET['id']) ? $_GET['id'] : false;
	if($supprimerID){

	// sql to delete a record
		$sql = 'DELETE FROM TABLE_DEFINITION WHERE ID_DEFINITION = "'.$supprimerID.'"';
		$stmt= $bdd->prepare($sql);
		$stmt->execute($sql);
    header('location: accueil.php');
	}

header('location: admin_liste_def.php');



}
else{header('location: register.php'); }
?>
