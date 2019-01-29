
<!DOCTYPE html>
<html>
<head>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />

 <?php include("head.php"); ?>
  <link rel="stylesheet" href="..\css/choosetrad.css">

</head>
<body>

<?php
include("menu_admin.php");
include("server_definition.php");



  try
  {
   if(isset($_GET['id']) AND !empty($_GET['id'])) {
   $id = htmlspecialchars($_GET['id']);
    $bdd = Bdd::connect("BDD_TRADOCTEUR");
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Permet de récuperer une exception lorsque il y a une erreur au niveau de la base de donnée.
                                     //On pourra donc traiter l'erreur plus simplement avec un try et catch.
    $sql = 'SELECT ID_DEFINITION, MOT, DEFINITION, DATE_AJOUT FROM TABLE_DEFINITION WHERE ID_DEFINITION = "'.$id.'"';
    $res = $bdd->query($sql);
    $row = $res->fetch();
  }
  }
  catch (Exception $e)
  {
      die('Erreur : ' . $e->getMessage());
  }?>

<br/>

<div class="header" style="background-color: purple">
  <h2>Modifier la définition</h2>
</div>

<form method="post" action="modifier.php" class= "formulaire_stylise">
  <div>
    <input type="hidden" value="<?php echo $row[0]; ?>" name="id"/>
  </div>
  <div class="form-group">
    <label>mot</label>
    <input type="text" name="mot" value="<?php echo $row[1]; ?>">
  </div>
  <div class="form-group">
    <label>Définition</label>
    <textarea class="form-control" name = "definition" id="definition" rows="3"><?php echo $row[2]; ?></textarea>
  </div>
  <div>
    <input type="hidden" name="date_ajout" value="<?php echo $row[3]; ?>">
  </div>
  <div class="input-group">
    <button type="submit" class="btn" name="modifier">Modifier</button>
  </div>
</form>

</body>
