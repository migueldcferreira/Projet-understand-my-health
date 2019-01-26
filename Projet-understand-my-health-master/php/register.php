<!--<?php// include('server.php') ?>-->
<!DOCTYPE html>
<html>
<head>
<?php include("head.php"); ?>


<title>Formulaire d'inscription ! \(^-^)/</title>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <meta name="description" content="Projet">
     <meta name="Oussenan-/-Slaouti" content="Nom prénom">
     <link rel="stylesheet" type="text/css" href="..\css/form_inscr.css">

</head>
<body>
  <?php include("menu.php"); ?>
	
	
	  <div class="header form_head">
		<h2>S'inscrire</h2>
	  </div>


	  <form method="post" action="register.php" class ="formulaire_stylise">
		
			<div class="input-group form-group">
			  <label>Identifiant</label>
			  <input type="text" name="username" value="">
			</div>
			<div class="input-group form-group">
			  <label>Email</label>
			  <input type="email" name="email" value= "">
			</div>
			<div class="input-group form-group">
			  <label>Mot de passe</label>
			  <input type="password" name="password_1">
			</div>
			<div class="input-group form-group">
			  <label>Confirmer mot de passe</label>
			  <input type="password" name="password_2">
			</div>
			<div class="wthree-text form-group">
					<label class="anim">
					  <input type="checkbox" class="checkbox" required="">
					  <span>j'accepte les termes et conditions</span>
					</label>
			<div class="input-group form-group">
			  <button type="submit" class="btn1" name="reg_user">s'inscrire</button>
			</div>

	  </form>
	
	<?php include("script_menu.php"); ?>
</body>


</html>