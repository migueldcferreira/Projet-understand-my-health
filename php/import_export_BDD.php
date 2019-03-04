<!doctype html>
<html lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<?php session_start();
	include ('verif_admin.php'); 
	include("head.php"); ?>
  <link rel="stylesheet" href="..\css/choosetrad.css">
</head>

<body>
	<?php include("menu_admin.php"); ?>

  <section id="tabs" class="project-tab">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <nav>
                            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-import-tab" data-toggle="tab" href="#nav-import" role="tab" aria-controls="nav-import" aria-selected="true"><i class="fas fa-file-upload"></i> Importez des définitions</a>
                                <a class="nav-item nav-link" id="nav-export-tab" data-toggle="tab" href="#nav-export" role="tab" aria-controls="nav-export" aria-selected="false"><i class="fas fa-file-csv"></i> Exportez des définitions</a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            
                            <div class="tab-pane fade" id="nav-import" role="tabpanel" aria-labelledby="nav-import-tab">
															<form action="importerBDD.php" method="post" enctype="multipart/form-data" id="js-upload-form">
																<br/>
																<div class="container">
																	<div class="panel panel-default">
																		<div class="panel-heading"><strong>Sélectionnez des fichiers dans votre ordinateur</strong></div>
																		<div class="panel-body">									
																				<div class="form-inline">
																					<div class="form-group">
																						<input type="file" name="fichier" id="js-upload-files" multiple aria-describedby="fileHelp" accept=".txt,.csv">
																					</div>																											
																				</div>
																		</div>
																	</div>
																</div> <!-- /container -->
																<div class="form-check">
																	<br/>
																	<input type="checkbox" class="form-check-input" id="formeCompacte">
																	<label class="form-check-label" for="formeCompacte">Importer définitions sous forme compacte</label>
																	<br/>
																	<button type="submit" class="btn btn-sm btn-primary" id="js-upload-submit">Importer</button>
																</div>		
															</form>
                            </div>
                          
                          
                          <div class="tab-pane fade" id="nav-export" role="tabpanel" aria-labelledby="nav-export-tab">
                            <form class="form" action="exporterBDD.php" method="post">
                              <br/>
															<div class="form-check">
																<input type="checkbox" class="form-check-input" id="formeCompacte">
																<label class="form-check-label" for="formeCompacte">Exporter définitions sous forme compacte</label>
																<br/>
																<button type="submit" class="btn btn-primary">Exporter</button>	
															</div>
                            </form>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>

  <?php include("script_menu.php"); ?>
</body>
</html>
