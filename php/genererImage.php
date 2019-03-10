<?php
  require("Bdd.php");
  
  //connexion a la base de donnees   
  try
  {
    $bdd = Bdd::connect("BDD_TRADOCTEUR");
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //Permet de récuperer une exception lorsque il y a une erreur au niveau de la base de donnée.
    //On pourra donc traiter l'erreur plus simplement avec un try et catch.
  }
  catch (Exception $e)
  {
    die("Erreur connexion base de données);
  }
  
  //on verifie que l'id a bien ete donne
  if(isset($_GET['id']))
  {
    $idImage = $_GET['id'];
  
    //on cherche l'image dans la bdd
    $sdl = "SELECT IMAGE FROM TABLE_IMAGE WHERE ID_IMAGE = ".$idImage.";"; 
    $res = $bdd->query($sdl); 
    $row = $res->fetch(); 

    header('Content-Type: image');
    echo $row['IMAGE'];
  }
?>
