

<div id="topheader">
	<nav class="navbar navbar-expand-lg navbar-dark bg-success " role="navigation">
		<div class="container-fluid">
			
				<a class="navbar-brand" href="accueil.php"><i class="fas fa-file-medical-alt"></i> Tradocteur</a>
				<button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">

				   <span class="icon-bar top-bar"></span>
				   <span class="icon-bar middle-bar"></span>
				   <span class="icon-bar bottom-bar"></span>
				   <span class="sr-only">Toggle navigation</span>
				</button>
				
				
			

			<div class="navbar-collapse collapse" id="navbar">
				<ul class="nav navbar-nav mr-auto">
					<li class="nav-item " data-toggle="collapse" data-target="#navbar-collapse.in">
						<a href="accueil.php" class="nav-link">Traduire un contenu médical<span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item" data-toggle="collapse" data-target="#navbar-collapse.in">
						<a href="dictionnaire.php" class="nav-link">Dictionnaire</a>
					</li>
					
					
					<?php if (!empty($_SESSION['username'])): ?>
					
					<li class="nav-item" data-toggle="collapse" data-target="#navbar-collapse.in">
						<a href="proposer_definition_mot.php" class="nav-link">Ajouter une définition</a>
					</li>
					<li class="nav-item" data-toggle="collapse" data-target="#navbar-collapse.in">
						<a href="proposer_image.php" class="nav-link">Ajouter une image</a>
					</li>

					<?php else: ?>

					<li class="nav-item" data-toggle="collapse" data-target="#navbar-collapse.in">
						<a href="register.php" class="nav-link">Devenir membre</a>
					</li>
					<li class="nav-item" data-toggle="collapse" data-target="#navbar-collapse.in">
						<a href="login.php" class="nav-link">Se connecter</a>
					</li>

					<?php endif ?>
					
					
					</li>
					<li class="nav-item" data-toggle="collapse" data-target="#navbar-collapse.in">
						<a href="#top" class="nav-link">À propos</a>
					</li>
	
					
					<?php if (!empty($_SESSION['username']) && ( $_SESSION['rang']=="super-admin" || $_SESSION['rang']=="admin")): ?>
					<li class="nav-item" data-toggle="collapse" data-target="#navbar-collapse.in">
						<a href="admin_liste_membres.php" class="nav-link">Espace Admin</a>
					</li>
					<?php endif ?>
				
				
					<li class="nav-item" data-toggle="collapse" data-target="#navbar-collapse.in">
						<div class="btn-group">
  							<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    								Mettre à jour
  							</button>
  							<div class="dropdown-menu">
    								<a class="dropdown-item" href="majStable.php">Version stable</a>
    								<div class="dropdown-divider"></div>
    								<a class="dropdown-item" href="majTest.php">Version test</a>
  							</div>
						</div>
					</li>
					<!--<li class="nav-item" data-toggle="collapse" data-target="#navbar-collapse.in">
						<a href="maj.php" class="nav-link">Mettre à jour</a>
					</li>-->
				</ul>
			<p class="mx-1 my-2 my-sm-0" style="color:white">
				Bonjour <?php if(!empty($_SESSION['prenom'])) {echo $_SESSION['prenom'];}
							      else {echo "Visiteur";}?>
			</p>
				<?php if (!empty($_SESSION['username'])): ?>
					<a href="deconnexion.php" class="btn btn-secondary my-2 my-sm-0 btn-sm"><i class="fas fa-caret-right"></i> Se déconnecter</a>
				<?php endif ?>
			<!--
				<form method="post"  class="form-inline my-2 my-lg-0">
					<input class="form-control mr-sm-2 form-control-sm" type="text" name="IDENTIFIANT" placeholder="Identifiant">
					<input class="form-control mr-sm-2 form-control-sm" type="password" name="MOT_DE_PASSE" placeholder="Mot de passe">
					<button class="btn btn-secondary my-2 my-sm-0 btn-sm" type="submit"><i class="fas fa-user-md" name="login_user"></i> Se connecter</button>
				</form>
				-->

			</div>
		</div>
	</nav>
</div>


