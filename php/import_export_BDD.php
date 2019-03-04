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
                                <a class="nav-item nav-link active" id="nav-import-tab" data-toggle="tab" href="#nav-import" role="tab" aria-controls="nav-import" aria-selected="true"><i class="fas fa-file-pdf"></i>Importez des définitions</a>
                                <a class="nav-item nav-link" id="nav-export-tab" data-toggle="tab" href="#nav-export" role="tab" aria-controls="nav-export" aria-selected="false"><i class="fas fa-code"></i>Exportez des définitions</a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            
                            <div class="tab-pane fade" id="nav-import" role="tabpanel" aria-labelledby="nav-import-tab">	
                              <div class="container">
                                <div class="panel panel-default">
                                  <div class="panel-heading"><strong>Sélectionnez des fichiers dans votre ordinateur</strong></div>
                                  <div class="panel-body">

									  <!-- Standar Form -->
									
                                    <form action="simplifierByUpload.php" method="post" enctype="multipart/form-data" id="js-upload-form">
                                    <div class="form-inline">
                                      <div class="form-group">
                                        <input type="file" name="fichier" id="js-upload-files" multiple aria-describedby="fileHelp" accept=".txt,.pdf">
                                      </div>
                                      <button type="submit" class="btn btn-sm btn-primary" id="js-upload-submit">Simplifier</button>
                                    </div>
                                    </form>

									  <!-- Drop Zone -->
                                    <h4>Ou glisser-déposer ici</h4>
                                    <div class="upload-drop-zone" id="drop-zone">
                                    Glisser-déposer ici
                                  </div>
                                </div>
                              </div>
                            </div> <!-- /container -->					
                          </div>
                          
                          
                          <div class="tab-pane fade" id="nav-export" role="tabpanel" aria-labelledby="nav-export-tab">
                            <form class="form" action="simplifierByURL.php" method="post">
                              <br/>
                              <div class="form-inline">
                                <input type="text" class="form-control form-control-lg" id="myURL" name="testurl"></input>
                                <button type="submit" class="btn btn-primary">Simplifier</button>
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
