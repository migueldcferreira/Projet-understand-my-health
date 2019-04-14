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


//Supprimer membre
$id = isset($_GET['id']) ? (int) $_GET['id'] : null;
if ($id) {


	// sql to delete a record
		$sql = 'UPDATE TABLE_UTILISATEUR SET ACTIF=1 WHERE ID_UTILISATEUR = "'.$id.'"';
		$stmt= $bdd->query($sql);
		$stmt->execute($sql);
    header('location: admin_liste_membres.php');

}
else{header('location: register.php'); }
?>
