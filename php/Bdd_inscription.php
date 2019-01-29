<?php
session_start();
require('Bdd.php'); 


// initialisation des variables
$NOM = "";
$PRENOM = "";
$ADRESSE_MAIL    = "";
$errors = array(); 

// connection à la base de donnée
$db = Bdd::connect("BDD_TRADOCTEUR");


// REGISTER USER
if (isset($_POST['reg_user'])) {
  // prendre tous les champs insérés dans le formulaire
  $NOM = $_POST['NOM'];
  $PRENOM = $_POST['PRENOM'];
  $ADRESSE_MAIL = $_POST['ADRESSE_MAIL'];
  $DATE_NAISSANCE=$_POST['DATE_NAISSANCE'];
  $MOT_DE_PASSE_1 = $_POST['MOT_DE_PASSE_1'];
  $MOT_DE_PASSE_2 = $_POST['MOT_DE_PASSE_2'];

  // verification si tous les champs sont remplis
  // on remplit le tableau array des erreurs pour les afficher après la saisie
  if (empty($NOM)) { array_push($errors, "Entrer votre nom de famille "); }
  if (empty($PRENOM)) { array_push($errors, "Entrer votre prénom  "); }
  if (empty($ADRESSE_MAIL)) { array_push($errors, "Entrer votre adresse mail "); }
  if (empty($MOT_DE_PASSE_1)) { array_push($errors, "Entrer un mot de passe"); }
  if ($MOT_DE_PASSE_1 != $MOT_DE_PASSE_2) {
	array_push($errors, "les deux mots de passe ne coincident pas");
  }

  // on fait une recherche dans la base de données
  // deux membres ne peuvent pas avoir des adresses mail identiques
  $user_check_query = "SELECT * FROM TABLE_UTILISATEUR WHERE  ADRESSE_MAIL='$ADRESSE_MAIL' LIMIT 1";
  $result = $db->query($user_check_query);
  $user = $result->fetch();
  
  if ($user) { // if user exists
    
    if ($user['ADRESSE_MAIL'] === $ADRESSE_MAIL) {
      array_push($errors, "ADRESSE_MAIL déjà utilisé");
    }
  }

  // si on a aucune erreur l'inscription est validée
  if (count($errors) == 0) {
  	$MOT_DE_PASSE = md5($MOT_DE_PASSE_1);//on crypte le mot de passe par sécurité

  	$query = "INSERT INTO TABLE_UTILISATEUR (NOM,PRENOM, ADRESSE_MAIL,DATE_NAISSANCE, MOT_DE_PASSE) 
  			  VALUES('$NOM','$PRENOM', '$ADRESSE_MAIL', '$DATE_NAISSANCE' , '$MOT_DE_PASSE')";
  	$tmp=$db->prepare($query);
    $tmp->execute();
  	$_SESSION['PRENOM'] = $PRENOM;
  	$_SESSION['success'] = "Vous étes connecté";
  	header('location: accueil.php');//on revient à la page d'accueil
  }
}




?>
