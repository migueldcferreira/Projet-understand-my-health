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

  //on determine l'id de l'utilisateur qui modifie la definition
  $query = 'select ID_UTILISATEUR FROM TABLE_UTILISATEUR WHERE ADRESSE_MAIL = "'.$_SESSION['username'].'"'; 
  $res = $db->query($query); 
  $row = $res->fetch(); 
  $idU = $row[0]; 

  $tailleDef = strlen($definition);
  
  $query = "UPDATE TABLE_DEFINITION SET MOT= '".$mot."', DEFINITION ='".str_replace("'","''",$definition)."', DATE_MODIF = NOW(), ID_UTILISATEUR_MODIF =".$idU.", TAILLE_DEFINITION=".$tailleDef." WHERE ID_DEFINITION = ".$id.";";
  $stmt= $bdd->prepare($query);
  $stmt->execute([$mot, $definition]);



    header('location: accueil.php');

}





?>
