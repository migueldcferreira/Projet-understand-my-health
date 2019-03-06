<?php
  //fichier a supprimer
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

  if (isset($_POST['modifier']))
  {
    $id = $_POST['id'];
    $mot = $_POST['mot'];
    $definition = $_POST['definition'];
    
    //on determine l'id de l'utilisateur qui modifie la definition
    $query = "SELECT ID_UTILISATEUR FROM TABLE_UTILISATEUR WHERE ADRESSE_MAIL = '".$_SESSION['username']."';"; 
    $res = $bdd->query($query); 
    $row = $res->fetch(); 
    $idU = $row['ID_UTILISATEUR']; 

    $tailleDef = strlen($definition);

    $query = "UPDATE TABLE_DEFINITION SET MOT='".$mot."', DEFINITION='".str_replace("'","''",$definition)."', DATE_MODIF=NOW(), ID_UTILISATEUR_MODIF=".$idU.", TAILLE_DEFINITION=".$tailleDef." WHERE ID_DEFINITION=".$id.";";
    echo $query;
    //$res = $bdd->query($query);
    /*$stmt= $bdd->prepare($query);
    $stmt->execute([$mot, $definition]);*/


    //header('location: accueil.php');

  }

?>
