<!doctype html>
<html lang="fr">
  <head>
    <?php include("head.php"); ?>
    <link rel="stylesheet" href="..\css/choosetrad.css">
  </head>
  <body>


	<?php include("menu.php"); ?>

	
	
	<section id="tabs" class="project-tab">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <nav>
                            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"><i class="fas fa-paste"></i> Copier-coller un texte médical</a>
                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false"><i class="fas fa-file-pdf"></i> Importez un fichier</a>
                                <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false"><i class="fas fa-code"></i> URL</a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
								<form class="form col-md-6" action="traduction.php" method="post">
									<br/>
									<textarea class="form-control form-control-block" id="myText" name="testtext"></textarea>
									<button type="submit" class="btn btn-primary">Traduire</button>
									<button type="reset" class="btn btn-secondary">Effacer</button>
								</form>
                            </div>
                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
								
								
								
								<div class="container">
								  <div class="panel panel-default">
									<div class="panel-heading"><strong>Sélectionnez des fichiers dans votre ordinateur</strong></div>
									<div class="panel-body">

									  <!-- Standar Form -->
									
									  <form action="traductionByUpload.php" method="post" enctype="multipart/form-data" id="js-upload-form">
										<div class="form-inline">
										  <div class="form-group">
											<input type="file" name="fichier" id="js-upload-files" multiple aria-describedby="fileHelp" accept=".txt .pdf">
										  </div>
										  <button type="submit" class="btn btn-sm btn-primary" id="js-upload-submit">Importer</button>
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
                            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
								<form class="form" action="traductionByURL.php" method="post">
									<br/>
									<div class="form-inline">
										<input type="text" class="form-control form-control-lg" id="myURL"></input>
										<button type="submit" class="btn btn-primary">Valider</button>
									</div>
								</form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
	
	<a href ="admin_liste_membres.php">Aller sur la page admin</a>

    
    <?php include("script_menu.php"); ?>

  </body>
</html>
