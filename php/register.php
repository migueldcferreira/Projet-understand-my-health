<?php include('Bdd_inscription.php'); //appel à la base de donnée
      include('verif_visiteur.php');?>
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
	  <div class="header form_head bg-success">
		<h2>S'inscrire</h2>
	  </div>


	  <form method="post" action="register.php" class ="formulaire_stylise">
	  		<?php include('errors.php');//pour gérer les erreurs lors de la vérification des champs insérés par l'utilisateur ?>

			<div class="input-group form-group">
			  <label>Nom</label>
			  <input type="text" name="NOM" value="<?php echo $NOM; ?>">
			</div>
			<div class="input-group form-group">
			  <label>Prénom</label>
			  <input type="text" name="PRENOM" value="<?php echo $PRENOM; ?>">
			</div>
			<div class="input-group form-group">
			  <label>Adresse mail</label>
			  <input type="email" name="ADRESSE_MAIL" value= "<?php echo $ADRESSE_MAIL; ?>">
			</div>
			<div class="input-group form-group">
			  <label>Date de naissance</label>
			  <input type="date" name="DATE_NAISSANCE" value= "<?php echo $DATE_NAISSANCE; ?>">
			</div>
			<div class="input-group form-group">
			  <label>Mot de passe</label>
			  <input type="password" name="MOT_DE_PASSE_1">
			</div>
			<div class="input-group form-group">
			  <label>Confirmer mot de passe</label>
			  <input type="password" name="MOT_DE_PASSE_2">
			</div>
			<div>
				<label>Choisissez une question secrète</label>
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
			<div class="wthree-text form-group">
					<label class="anim">
					  <input type="checkbox" class="checkbox" required="">
					  <span>j'accepte les termes et conditions</span>
					</label>
			<div class="input-group form-group">
				<button type="submit" class="btn btn-success btn-sm" name="reg_user">S'inscrire</button>
			</div>

	  </form>

	<?php include("script_menu.php"); ?>
</body>


</html>
