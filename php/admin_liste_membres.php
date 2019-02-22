<!doctype html>
<html lang="fr">
<head>


	 <?php session_start();
	 include ('verif_admin.php');
	 include("head.php"); ?>
    <link rel="stylesheet" href="..\css/choosetrad.css">

</head>
<body>


	<?php include("menu_admin.php"); ?>
	<?php


	require('Bdd.php');

	try
	{
		$bdd = Bdd::connect("BDD_TRADOCTEUR");
		$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Permet de récuperer une exception lorsque il y a une erreur au niveau de la base de donnée.
																	   //On pourra donc traiter l'erreur plus simplement avec un try et catch.


		$sql_adm = "SELECT  ID_UTILISATEUR,NOM, PRENOM, ADRESSE_MAIL,RANG,DATE_DERNIERE_CONNEXION FROM TABLE_UTILISATEUR WHERE ACTIF = 1 AND RANG LIKE '%admin' " ; //requête pour trouver les définitions non validées (propositions)
		$res_adm = $bdd->query($sql_adm);
		$sql_mem = "SELECT  ID_UTILISATEUR,NOM, PRENOM, ADRESSE_MAIL,RANG,DATE_DERNIERE_CONNEXION FROM TABLE_UTILISATEUR WHERE ACTIF = 1 AND RANG LIKE '%membre%' " ; //requête pour trouver les définitions non validées (propositions)
		$res_mem = $bdd->query($sql_mem);


	}
	catch (Exception $e)
	{
			die('Erreur : ' . $e->getMessage());
	}?>


	<section id="tabs" class="project-tab">
		<div class="container">
			<div class="row">
			<?php
					if($_SESSION['rang']=="super-admin")
			{
				?>
				<div class="col-md-12 table-responsive-sm">
					<table class="table">
						<thead>
							<tr>
								<th scope="col">Administrateurs</th>
								<th scope="col">Nom</th>
								<th scope="col">Prénom</th>
								<th scope="col">Adresse mail</th>
								<th scope="col">Rang</th>
								<th scope="col">Dernière connexion</th>
								<th scope="col"></th>
							</tr>
						</thead>
						<tbody>
																			<?php $i=1;
																			 while ($row = $res_adm->fetch()) { ?>
																				<tr>
																						<td ><?php printf ("%d", $i); ?>  </td>
																						<td> <?php printf ("%s", $row[1]); ?> </td>
																						<td> <?php printf ("%s", $row[2]); ?> </td>
																						<td> <?php printf ("%s", $row[3]); ?> </td>
																						<td> <?php printf ("%s", $row[4]); ?> </td>
																						<td> <?php printf ("%s", $row[5]); ?> </td>
																						<td><button class="btn btn-danger btn-sm tooltipsAdmin disabled" title="Supprimer cet administrateur"><i class="fas fa-minus-circle"></i></button></td>
																				</tr>
																			<?php $i++;} ?>
																		</tbody>

					</table>
				</div>
			</div>
			<?php
				}

			?>
			<div class="row">
              			<div class="col-md-12 table-responsive-sm">
                			<table class="table">
                				<thead>
							<tr>
								<th scope="col">Membres</th>
								<th scope="col">Nom</th>
								<th scope="col">Prénom</th>
								<th scope="col">Adresse mail</th>
								<th scope="col">Rang</th>
								<th scope="col">Dernière connexion</th>
								<th scope="col"></th>
							</tr>
						</thead>
						<tbody>
																			<?php $i=1;
																			 while ($row = $res_mem->fetch()) { ?>
																				<tr>
																						<td><?php printf ("%d", $i); ?>  </td>
																						<td> <?php printf ("%s", $row[1]); ?> </td>
																						<td> <?php printf ("%s", $row[2]); ?> </td>
																						<td> <?php printf ("%s", $row[3]); ?> </td>
																						<td> <?php printf ("%s", $row[4]); ?> </td>
																						<td> <?php printf ("%s", $row[5]); ?> </td>
																							<td>
																								<a href="promotion.php?id=<?php echo $row[0] ?>">
																								<button class="btn btn-success btn-sm tooltipsAdmin" title="Promouvoir comme membre spécialiste"><i class="fas fa-user-plus"></i>
																								</button></a>
																								<a href="retro.php?id=<?php echo $row[0] ?>">
																								<button class="btn btn-warning btn-sm tooltipsAdmin disabled" title="Rétrograder à membre"><i class="fas fa-user-minus"></i>
																								</button></a>
																								<a href="supprimer_us.php?id=<?php echo $row[0] ?>">
																								<button class="btn btn-danger btn-sm tooltipsAdmin" title="Supprimer ce membre"><i class="fas fa-minus-circle"></i></button></a>
																							</td>

																				</tr>
																			<?php $i++;} ?>
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
