<!doctype html>
<html lang="fr">
<head>

	

	<script type="text/javascript" src="..\javascript/tooltipsAdmin.js"></script>
	 <?php session_start();
	 include ('verif_admin.php');
	 include("head.php");
	 include("script_menu.php"); ?>
    <link rel="stylesheet" href="..\css/choosetrad.css">
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />


	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
	
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
   
    <script type="text/javascript" language="javascript" >
    		<?php
					if($_SESSION['rang']=="super-admin")
			{
				?>
			$(document).ready(function() {
				var dataTable = $('#admin_membres_1').DataTable( {
					"processing": true,
					"serverSide": true,
					"columnDefs": [ {
					"targets": 6,
					"orderable": false
					} ],
					"language": { 

					    "sProcessing": "Traitement en cours ...",
					    "sLengthMenu": "Afficher _MENU_ lignes",
					    "sZeroRecords": "Aucun résultat trouvé",
					    "sEmptyTable": "Aucune donnée disponible",
					    "sInfo": "Lignes _START_ à _END_ sur _TOTAL_",
					    "sInfoEmpty": "Aucune ligne affichée",
					    "sInfoFiltered": "(Filtrer un maximum de_MAX_)",
					    "sInfoPostFix": "",
					    "sSearch": "Chercher:",
					    "sUrl": "",
					    "sInfoThousands": ",",
					    "sLoadingRecords": "Chargement...",
					    "oPaginate": {
					      "sFirst": "Premier", "sLast": "Dernier", "sNext": "Suivant", "sPrevious": "Précédent"
					    },
					    "oAria": {
					      "sSortAscending": ": Trier par ordre croissant", "sSortDescending": ": Trier par ordre décroissant"
					    }
					} ,

					"ajax":{
						url :"admin_membres_data_su.php", // json datasource
						type: "post",  // method  , by default get
						dataFilter: function(reps) {
				                console.log(reps);
				                return reps;
		           			 },
		           		error:function(err){
			                  console.log(err);
			            },
						error: function(){  // error handling
							$(".admin_membres_1-error").html("");
							$("#admin_membres_1").append('<tbody class="admin_membres_1-error"><tr><th colspan="3">Pas de données trouvées sur le serveur</th></tr></tbody>');
							$("#admin_membres_1_processing").css("display","none");
							
						}
					}
				} );

			} );

		<?php } ?>


			$(document).ready(function() {
				var dataTable = $('#admin_membres_2').DataTable( {
					"processing": true,
					"serverSide": true,
					"columnDefs": [ {
					"targets": 6,
					"orderable": false
					} ],
					"language": { 

					    "sProcessing": "Traitement en cours ...",
					    "sLengthMenu": "Afficher _MENU_ lignes",
					    "sZeroRecords": "Aucun résultat trouvé",
					    "sEmptyTable": "Aucune donnée disponible",
					    "sInfo": "Lignes _START_ à _END_ sur _TOTAL_",
					    "sInfoEmpty": "Aucune ligne affichée",
					    "sInfoFiltered": "(Filtrer un maximum de_MAX_)",
					    "sInfoPostFix": "",
					    "sSearch": "Chercher:",
					    "sUrl": "",
					    "sInfoThousands": ",",
					    "sLoadingRecords": "Chargement...",
					    "oPaginate": {
					      "sFirst": "Premier", "sLast": "Dernier", "sNext": "Suivant", "sPrevious": "Précédent"
					    },
					    "oAria": {
					      "sSortAscending": ": Trier par ordre croissant", "sSortDescending": ": Trier par ordre décroissant"
					    }
					} ,

					"ajax":{
						url :"admin_membres_data_a.php", // json datasource
						type: "post",  // method  , by default get
						dataFilter: function(reps) {
				                console.log(reps);
				                return reps;
		           			 },
		           		error:function(err){
			                  console.log(err);
			            },
						error: function(){  // error handling
							$(".admin_membres_2-error").html("");
							$("#admin_membres_2").append('<tbody class="admin_membres_2-error"><tr><th colspan="3">Pas de données trouvées sur le serveur</th></tr></tbody>');
							$("#admin_membres_2_processing").css("display","none");
							
						}
					}
				} );

			} );


				

		
		</script>



</head>
<body>

	
	<?php include("menu_admin.php"); ?>
	

	<?php
			if($_SESSION['rang']=="super-admin")
		{
	?>
	
		<section id="tabs" class="project-tab">
	                        <nav>
	                            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
	                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"><i class="fa fa-user-circle"></i> Administrateurs</a>
	                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false"><i class="fa fa-users"></i> Membres</a>
	                            </div>
	                        </nav>
	                      <div class="tab-content" id="nav-tabContent">
	                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
															</br>

																<div style="overflow-x:auto;">
																		<table id="admin_membres_1"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
																				<thead>
																					<tr>
																						<th>Administrateurs</th>
																						<th>Nom</th>
																						<th>Prénom</th>
																						<th>Adresse mail</th>
																						<th>Rang</th>
																						<th>Dernière connexion</th>
																						<th>Actions</th>
																					</tr>
																				</thead>
																		</table>
																</div>


															





	                            </div>
	                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">

	                            							<?php } ?>
	                            							</br>
															

	                            								<div style="overflow-x:auto;">
																		<table id="admin_membres_2"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
																				<thead>
																					<tr>
																						<th>Administrateurs</th>
																						<th>Nom</th>
																						<th>Prénom</th>
																						<th>Adresse mail</th>
																						<th>Rang</th>
																						<th>Dernière connexion</th>
																						<th>Actions</th>
																					</tr>
																				</thead>
																		</table>
																</div>

						<?php
								if($_SESSION['rang']=="super-admin")
							{
						?>

	                            </div>

	                        </div>
	   	</section>
    				<?php } ?>
		


</body>
</html>
