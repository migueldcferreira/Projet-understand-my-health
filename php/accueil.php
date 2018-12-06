<!doctype html>
<html lang="fr">
  <head>
    <?php include("head.php"); ?>
  </head>
  <body>

    <!--Container principal-->
    <div class="container-fluid">
      <?php include("menu.php"); ?>

      <div class="container">
        <div class="row">
          <!--Copier-Coller-->
          <form class="form col-md-6" action="test.php" method="post">
            <label for="myText" class="form-control-label"><i class="fas fa-paste"></i> Copiez-collez un texte médical</label>
            <textarea class="form-control form-control-block" id="myText" name="testtext"></textarea>
            <button type="submit" class="btn btn-primary">Traduire</button>
            <button type="reset" class="btn btn-secondary">Effacer</button>
          </form>
          <form class="form col-md-6">
            <label for="myInputFile" class="form-control-label"><i class="fas fa-file-pdf"></i> Importez un fichier</label>
            <input type="file" class="form-control-file" id="myInputFile" aria-describedby="fileHelp">
            <small id="fileHelp" class="form-text text-muted">Vous pouvez importer un fichier texte (.txt) ou un fichier PDF (.pdf). Dans le cas d'un PDF, veillez à ce qu'il ne soit pas protégé en auquel cas il sera impossible de traiter le document.</small>
            <button type="submit" class="btn btn-primary">Valider</button>
          </form>
          <form class="form col-md-6">
            <label for="myURL" class="form-control-label"><i class="fas fa-code"></i> Renseignez directement le lien d'une page avec du contenu médical</label>
            <div class="form-inline">
              <input type="text" class="form-control form-control-lg" id="myURL"></input>
              <button type="submit" class="btn btn-primary">Valider</button>
            </div>
          </form>
        </div>
      </div>
      
    </div>
    <?php include("script_menu.php"); ?>
  </body>
</html>
