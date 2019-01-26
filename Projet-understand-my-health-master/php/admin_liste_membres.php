<!doctype html>
<html lang="fr">
<head>

	 <?php include("head.php"); ?>
    <link rel="stylesheet" href="..\css/choosetrad.css">

</head>
<body>

	
	<?php include("menu_admin.php"); ?>

	<section id="tabs" class="project-tab">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<table class="table">
						<thead>
							<tr>
								<th scope="col">Administrateurs</th>
								<th scope="col">Identifiant</th>
								<th scope="col">Rang</th>
								<th scope="col">Dernière connexion</th>
								<th scope="col"></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th scope="row">1</th>
								<td>Admin 1</td>
								<td>super-admin</td>
								<td style="opacity: 0.75">26/01/2019 11:55</td>
								<td><button class="btn btn-danger btn-sm tooltipsAdmin disabled" title="Supprimer cet administrateur"><i class="fas fa-minus-circle"></i></button></td>
							</tr>
							<tr>
								<th scope="row">2</th>
								<td>Admin2</td>
								<td>admin</td>
								<td style="opacity: 0.75">13/12/2018 23:27</td>
								<td><button class="btn btn-danger btn-sm tooltipsAdmin" title="Supprimer cet administrateur"><i class="fas fa-minus-circle"></i></button></td>
							</tr>
							<tr>
								<th scope="row">3</th>
								<td>Admin3</td>
								<td>admin</td>
								<td style="opacity: 0.75">25/01/2019 9:02</td>
								<td><button class="btn btn-danger btn-sm tooltipsAdmin" title="Supprimer cet administrateur"><i class="fas fa-minus-circle"></i></button></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="row">
                <div class="col-md-12">
                	<table class="table">
						<thead>
							<tr>
								<th scope="col">Membres</th>
								<th scope="col">Identifiant</th>
								<th scope="col">Rang</th>
								<th scope="col">Dernière connexion</th>
								<th scope="col"></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th scope="row">1</th>
								<td>Membre 1</td>
								<td>membre</td>
								<td style="opacity: 0.75">15/12/2018 2:14</td>
								<td>
									<button class="btn btn-success btn-sm tooltipsAdmin" title="Promouvoir comme membre spécialiste"><i class="fas fa-user-plus"></i></button>
									<button class="btn btn-warning btn-sm tooltipsAdmin disabled" title="Rétrograder à membre"><i class="fas fa-user-minus"></i></button>
									<button class="btn btn-danger btn-sm tooltipsAdmin" title="Supprimer ce membre"><i class="fas fa-minus-circle"></i></button>
								</td>
							</tr>
							<tr>
								<th scope="row">2</th>
								<td>Membre 2</td>
								<td>membre spécialiste</td>
								<td style="opacity: 0.75">29/12/2018 20:31</td>
								<td>
									<button class="btn btn-success btn-sm tooltipsAdmin disabled" title="Promouvoir comme membre spécialiste"><i class="fas fa-user-plus"></i></button>
									<button class="btn btn-warning btn-sm tooltipsAdmin" title="Rétrograder à membre"><i class="fas fa-user-minus"></i></button>
									<button class="btn btn-danger btn-sm tooltipsAdmin" title="Supprimer ce membre"><i class="fas fa-minus-circle"></i></button>
								</td>
							</tr>
							<tr>
								<th scope="row">3</th>
								<td>Membre 3</td>
								<td>membre</td>
								<td style="opacity: 0.75">06/01/2019 15:42</td>
								<td>
									<button class="btn btn-success btn-sm tooltipsAdmin" title="Promouvoir comme membre spécialiste"><i class="fas fa-user-plus"></i></button>
									<button class="btn btn-warning btn-sm tooltipsAdmin disabled" title="Rétrograder à membre"><i class="fas fa-user-minus"></i></button>
									<button class="btn btn-danger btn-sm tooltipsAdmin" title="Supprimer ce membre"><i class="fas fa-minus-circle"></i></button>
								</td>
							</tr>
							<tr>
								<th scope="row">4</th>
								<td>Membre 4</td>
								<td>membre</td>
								<td style="opacity: 0.75">16/01/2019 19:08</td>
								<td>
									<button class="btn btn-success btn-sm tooltipsAdmin" title="Promouvoir comme membre spécialiste"><i class="fas fa-user-plus"></i></button>
									<button class="btn btn-warning btn-sm tooltipsAdmin disabled" title="Rétrograder à membre"><i class="fas fa-user-minus"></i></button>
									<button class="btn btn-danger btn-sm tooltipsAdmin" title="Supprimer ce membre"><i class="fas fa-minus-circle"></i></button>
								</td>
							</tr>
						</tbody>
					</table>
                </div>
            </div>
		</div>
	</section>


<?php include("script_menu.php"); ?>

<script type="text/javascript" src="..\javascript/tooltipsAdmin.js"></script>

</body>
</html>