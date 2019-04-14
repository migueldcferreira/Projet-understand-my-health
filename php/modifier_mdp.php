<?php 
      include('Bdd_interaction.php'); 
      include('verif_membre.php');?>
<!DOCTYPE html>
<html>
<head>
<?php include("head.php"); ?>
<title>Modifier le mot de passe</title>
     <meta charset="utf-8">
     <link rel="stylesheet" type="text/css" href="..\css/form_inscr.css">
     
  
</head>

<body>
  <?php include("menu.php"); ?>

  <div class="header form_head bg-success">
  
    <h2>Modifier le mot de passe</h2>
  </div>
   
  <form method="post" action="modifier_mdp.php" class = "formulaire_stylise">
    <?php include('errors.php');?>
    <div class="input-group">
      <label>Ancien mot de passe</label>
      <input type="text" name="OLD_MDP" >
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
      <button type="submit" class="btn btn-success btn-sm"  name="modify">Modifier le mot de passe</button>
    </div>
  </form>




  <?php include("script_menu.php"); ?>
</body>
</html>
