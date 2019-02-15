<!doctype html>
<html lang="fr">
  <head>
    <?php session_start();
    include("head.php"); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="jquery-3.3.1.min.js"></script>
    <script>
    $(document).ready( function () {
    $('#table_id').DataTable();
    } ); </script>

    
    <link rel="stylesheet" href="..\css/choosetrad.css">

  

  </head>
  <body>

 <?php include("menu.php"); ?>
	
<table id="table_id" class="display">
    <thead>
        <tr>
            <th>Column 1</th>
            <th>Column 2</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Row 1 Data 1 a</td>
            <td>Row 1 Data 2</td>
        </tr>
        <tr>
            <td>Row 2 Data 1</td>
            <td>Row 2 Data 2</td>
        </tr>
    </tbody>
</table>
	  
	  <?php


	require('Bdd.php');

	try
	{
		$bdd = Bdd::connect("BDD_TRADOCTEUR");
		$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Permet de récuperer une exception lorsque il y a une erreur au niveau de la base de donnée.
																	   //On pourra donc traiter l'erreur plus simplement avec un try et catch.
		$sql_base = "SELECT ID_DEFINITION, MOT, DEFINITION, DATE_AJOUT FROM TABLE_DEFINITION WHERE A_CONFIRMER = 0"; //requête pour trouver les définitions validées
		$res_base = $bdd->query($sql_base);

		$sql_prop = "SELECT ID_DEFINITION, MOT, DEFINITION, DATE_AJOUT FROM TABLE_DEFINITION WHERE A_CONFIRMER = 1"; //requête pour trouver les définitions non validées (propositions)
		$res_prop = $bdd->query($sql_prop);

	}
	catch (Exception $e)
	{
			die('Erreur : ' . $e->getMessage());
	}?>


<section id="tabs" class="project-tab">
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">


															<div class="row">
																<div class="col-md-12 table-responsive-sm">
																	<table class="table">
																		<thead>
																			<tr>
																				<th scope="col">Mot</th>
																				<th scope="col">Définition</th>
																				<th scope="col">Date_ajout</th>
																				<th scope="col"></th>
																			</tr>
																		</thead>
																		<tbody>
																			<?php while ($row = $res_base->fetch()) { ?>
																				<tr>
																						<td> <?php printf ("%s", $row[1]); ?> </td>
																						<td> <?php printf ("%s", $row[2]); ?> </td>
																						<td> <?php printf ("%s", $row[3]); ?> </td>

					        															<td>
																						<a href="modifier.php?id=<?php echo $row[0] ?>">   <button class="btn btn-sm tooltipsAdmin enabled" title="Modifier cette définition"><i class="fa fa-edit"></i></button>      </a>
																						<a href="supprimer_def.php?id=<?php echo $row[0] ?>"> <button class="btn btn-danger btn-sm tooltipsAdmin enabled" title="Supprimer cette définition"><i class="fas fa-minus-circle"></i></button> </a>
																						</td>
																				</tr>
																			<?php } ?>
																		</tbody>
																	</table>
																</div>
															</div>






                            </div>

                        </div>
    </section>

 

  

  

 
	<?php include("script_menu.php"); ?>

  </body>
</html>
