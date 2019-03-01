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


//Promouvoir
$id = isset($_GET['id']) ? (int) $_GET['id'] : null;
if ($id) {


	// sql to delete a record
		$sql = 'UPDATE TABLE_DEFINITION SET A_CONFIRMER = 0 WHERE ID_DEFINITION= "'.$id.'"';
		$stmt= $bdd->query($sql);
		$stmt->execute($sql);
    header('location: admin_liste_def.php');

}
else{header('location: register.php'); }
?>
