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
				var dataTable = $('#employee-grid').DataTable( {
					"processing": true,
					"serverSide": true,


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
							$(".employee-grid-error").html("");
							$("#employee-grid").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
							$("#employee-grid_processing").css("display","none");
							
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
			<table id="employee-grid"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
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
