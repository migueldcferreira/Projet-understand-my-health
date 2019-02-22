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

//Modifier definition

if (isset($_POST['modifier'])) {
  $id = $_POST['id'];
  $mot = $_POST['mot'];
  $definition = $_POST['definition'];






    $query = 'UPDATE TABLE_DEFINITION SET MOT= "'.$mot.'", DEFINITION = "'.$definition.'" WHERE ID_DEFINITION = "'.$id.'"';
    $stmt= $bdd->prepare($query);
    $stmt->execute([$mot, $definition]);



    header('location: accueil.php');

}





?>
