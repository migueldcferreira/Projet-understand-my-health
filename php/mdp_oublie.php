<?php include('Bdd_interaction.php'); 
      include('verif_visiteur.php');?>
<!DOCTYPE html>
<html>
<head>
<?php include("head.php"); ?>
<title>Mot de Passe oublié</title>
     <meta charset="utf-8">
     <link rel="stylesheet" type="text/css" href="..\css/form_inscr.css">
     
  
</head>

<body>
  <?php include("menu.php"); ?>

  <div class="header form_head bg-success">
  
  	<h2>Mot de passe oublié</h2>
  </div>
	 
  <form method="post" action="mdp_oublie.php" class = "formulaire_stylise">
  	<?php include('errors.php');?>
  	<div class="input-group">
  		<label>Adresse mail</label>
  		<input type="email" name="ADRESSE_MAIL" >
  	</div>
    <div>
        <label>Votre question secrète</label>
        <select class="input-group form-group" name="PICK_QUESTION">
          <option>Quel est le nom de jeune fille de votre mère ?</option>
          <option>Quel était le métier de votre grand père ?</option>
          <option>Comment s'appelait votre premier animal de compagnie ?</option>
          <option>Comment s'appelait votre meilleur ami lorsque vous étiez adolescent ?</option>
          <option>Quel est le nom de la rue où vous avez grandi ?</option>
        </select>
    </div>
    <div class="input-group form-group">
        <label>Réponse à votre question secrète</label>
        <input type="text" name="REPONSE">
    </div>
  	<div class="input-group">
  		<label>Nouveau mot de passe</label>
  		<input type="password" name="MOT_DE_PASSE_1">
  	</div>
    <div class="input-group">
      <label>Confirmez votre nouveau mot de passe</label>
      <input type="password" name="MOT_DE_PASSE_2">
    </div>
  	<div class="input-group form-group">
  		<button type="submit" class="btn btn-success btn-sm"  name="recover">Réinitialiser le mot de passe</button>
  	</div>
  </form>




  <?php include("script_menu.php"); ?>
</body>
</html>
