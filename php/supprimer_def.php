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
$id = isset($_GET['id']) ? (int) $_GET['id'] : null;
if ($id) {
		
		//on recupere le classement et le mot associe a l'ID_DEFINITION
		$sql = "SELECT MOT, CLASSEMENT FROM TABLE_DEFINITION WHERE ID_DEFINITION = ".$id.";";
		$res = $bdd->query($sql);
		$row = $res->fetch();
		$mot = $row['MOT'];
		$classement = $row['CLASSEMENT'];
		
		//on met a jour les classements des autres definitions de ce mot		
		$sql = "UPDATE TABLE_DEFINITION SET CLASSEMENT = CLASSEMENT-1 WHERE MOT='".$mot."' AND CLASSEMENT >".$classement.";";
		$stmt= $bdd->query($sql);
		$stmt->execute($sql);
			
		//sql to delete a record
		$sql = 'DELETE FROM TABLE_DEFINITION WHERE ID_DEFINITION = "'.$id.'"';
		$stmt= $bdd->query($sql);
		$stmt->execute($sql);
		header('location: admin_liste_def.php');

}
else{header('location: register.php'); }
?>
