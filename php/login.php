<?php include('Bdd_inscription.php'); 
      include('verif_visiteur.php');?>
<!DOCTYPE html>
<html>
<head>
<?php include("head.php"); ?>
<title>Connexion </title>
     <meta charset="utf-8">
     <link rel="stylesheet" type="text/css" href="..\css/form_inscr.css">
     
  
</head>

<body>
  <?php include("menu.php"); ?>

  <div class="header form_head bg-success">
  
  	<h2>Se connecter</h2>
  </div>
	 
  <form method="post" action="login.php" class = "formulaire_stylise">
  	<?php include('errors.php');?>
  	<div class="input-group">
  		<label>Adresse mail</label>
  		<input type="email" name="ADRESSE_MAIL" >
  	</div>
  	<div class="input-group">
  		<label>Mot de passe</label>
  		<input type="password" name="MOT_DE_PASSE">
  	</div>
  	<div class="input-group form-group">
  		<button type="submit" class="btn btn-success btn-sm"  name="login_user">Se connecter</button>
  	</div>
  	<p>
  		Pas encore inscrit ? <a href="register.php">Devenir membre</a>
  	</p>
    <p>
      Mot de passe oublié ? <a href="mdp_oublie.php">Réinitialiser le mot de passe</a>
    </p>
  </form>




  <?php include("script_menu.php"); ?>
</body>
</html>
