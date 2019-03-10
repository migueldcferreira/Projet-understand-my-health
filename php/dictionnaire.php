<!DOCTYPE html>
<html lang="fr">
<html>
	<head>
    <?php include("script_menu.php"); ?>
  	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
   
    <script type="text/javascript" language="javascript" >
			$(document).ready(function() {
				var dataTable = $('#dictionnaire').DataTable( {
					"processing": true,
					"serverSide": true,
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
						url :"dictionnaire_data.php", // json datasource
						type: "post",  // method  , by default get
						dataFilter: function(reps) {
				                console.log(reps);
				                return reps;
		           			 },
		           		error:function(err){
			                  console.log(err);
			            },
						error: function(){  // error handling
							$(".dictionnaire-error").html("");
							$("#dictionnaire").append('<tbody class="dictionnaire-error"><tr><th colspan="3">Pas de données trouvées sur le serveur</th></tr></tbody>');
							$("#dictionnaire_processing").css("display","none");
							
						}
					}
				} );
			} );
		
		</script>
			<?php session_start();
	 		 include("head.php"); ?>

	</head>
	<body>
		<?php include("menu.php"); ?>

		</br>
		<div class="container">
			<table id="dictionnaire"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
					<thead>
						<tr>
							<th>mot</th>
							<th>definition</th>
						</tr>
					</thead>
			</table>
		</div>

		
	</body>

</html>
