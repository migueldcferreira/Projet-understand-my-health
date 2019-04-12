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
  $QUESTION = $_POST['PICK_QUESTION'];
  $REPONSE = substr($_POST['REPONSE'], 0, 100);

  // verification si tous les champs sont remplis
  // on remplit le tableau array des erreurs pour les afficher après la saisie
  if (empty($NOM)) { array_push($errors, "Entrez votre nom de famille "); }
  if (empty($PRENOM)) { array_push($errors, "Entrez votre prénom  "); }
  if (empty($ADRESSE_MAIL)) { array_push($errors, "Entrez votre adresse mail "); }
  if (empty($MOT_DE_PASSE_1)) { array_push($errors, "Entrez un mot de passe"); }
  if (empty($MOT_DE_PASSE_2)) { array_push($errors, "Confirmez votre mot de passe"); }
  if (empty($REPONSE)) { array_push($errors, "Entrez une reponse à la question secrète"); }
  if ($MOT_DE_PASSE_1 != $MOT_DE_PASSE_2) {
	array_push($errors, "Les deux mots de passe ne coincident pas");
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
    $REPONSE_CRYPTEE = md5($REPONSE);//on crypte la réponse à la question secrète par sécurité

  	$query = "INSERT INTO TABLE_UTILISATEUR (NOM,PRENOM, ADRESSE_MAIL,DATE_NAISSANCE, MOT_DE_PASSE, QUESTION_SECRETE, REPONSE)
  			  VALUES('$NOM','$PRENOM', '$ADRESSE_MAIL', '$DATE_NAISSANCE' , '$MOT_DE_PASSE', '$QUESTION', '$REPONSE_CRYPTEE')";

  	$tmp=$db->prepare($query);
    $tmp->execute();
	$_SESSION['username'] = $ADRESSE_MAIL;
  	$_SESSION['success'] = "Vous étes connecté";
	$_SESSION['rang']="membre"; 
	$_SESSION['prenom'] = $PRENOM;
  	header('location: accueil.php');//on revient à la page d'accueil
  }
}




// LOGIN USER
if (isset($_POST['login_user'])) {
  $ADRESSE_MAIL = $_POST['ADRESSE_MAIL'];
  $MOT_DE_PASSE = $_POST['MOT_DE_PASSE'];

  if (empty($ADRESSE_MAIL)) {
    array_push($errors, "Entrer votre identifiant(adresse mail)");
  }
  if (empty($MOT_DE_PASSE)) {
    array_push($errors, "Entrer un mot de passe");
  }

  if (count($errors) == 0) {
    $MOT_DE_PASSE = md5($MOT_DE_PASSE);
    $sts = "SELECT * FROM TABLE_UTILISATEUR WHERE ADRESSE_MAIL='$ADRESSE_MAIL' AND MOT_DE_PASSE='$MOT_DE_PASSE' AND ACTIF=1";


    if ($results = $db->query($sts))
    {
    	if (!empty($row = $results->fetch()))
    	{
            	$_SESSION['username'] = $ADRESSE_MAIL;
            	$_SESSION['success'] = "vous etes connecté";
    		$_SESSION['rang']=$row['RANG'];
    		$_SESSION['prenom']=$row['PRENOM'];
        $upd = "UPDATE TABLE_UTILISATEUR SET DATE_DERNIERE_CONNEXION = NOW() WHERE ID_UTILISATEUR = " .$row['ID_UTILISATEUR']. ";";
        $query= $db->prepare($upd);
        $query->execute();
             	header('location: accueil.php');
        	}
    	else
    	{
    		array_push($errors, "Mot de passe ou identifiant incorrect ");
      	}
    }
  }
}

?>
