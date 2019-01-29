<!doctype html>
<html lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	
	 <?php include("head.php"); ?>
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
		$sql = "SELECT ID_DEFINITION, MOT, DEFINITION, DATE_AJOUT FROM TABLE_DEFINITION";
		$res = $bdd->query($sql);
		
		
	}
	catch (Exception $e)
	{
			die('Erreur : ' . $e->getMessage());
	}?>


<section id="tabs" class="project-tab">
            
                        <nav>
                            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"><i class="fa fa-users"></i> Propositions de définitions</a>
                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false"><i class="fa fa-database"></i> Base de définitions</a>
                            
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
					
                            	





                            </div>
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
														<?php while ($row = $res->fetch()) { ?>
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

<script type="text/javascript" src="..\javascript/tooltipsAdmin.js"></script>

</body>
</html> 