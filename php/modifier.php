<?php
 session_start();
	include ('verif_admin.php');
?>
<!DOCTYPE html>
<html>
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
  }
  catch (Exception $e)
  {
      die('Erreur : ' . $e->getMessage());
  }
 
  if (isset($_POST['modifier']))
  {
    $id = $_POST['id'];
    $mot = $_POST['mot'];
    $definition = $_POST['definition'];
    
    //on determine l'id de l'utilisateur qui modifie la definition
    $query = "SELECT ID_UTILISATEUR FROM TABLE_UTILISATEUR WHERE ADRESSE_MAIL = '".$_SESSION['username']."';"; 
    $res = $bdd->query($query); 
    $row = $res->fetch(); 
    $idU = $row['ID_UTILISATEUR']; 
    
		$tailleDef = strlen($definition);
		
		
		
		//on met a jour les classements des definitions reliées a l'ancien mot defini (le nouveau mot pouvant etre le meme ou non que l'ancien)
		
		//on recupere le classement et le mot associe a l'ID_DEFINITION
		$sql = "SELECT MOT, CLASSEMENT FROM TABLE_DEFINITION WHERE ID_DEFINITION = ".$id.";";
		$res = $bdd->query($sql);
		$row = $res->fetch();
		$ancienMot = $row['MOT'];
		$classement = $row['CLASSEMENT'];
		
		//on met a jour les classements des autres definitions de cet ancienMot		
		$sql = "UPDATE TABLE_DEFINITION SET CLASSEMENT = CLASSEMENT-1 WHERE MOT='".$ancienMot."' AND CLASSEMENT >".$classement.";";
		$stmt= $bdd->query($sql);
		$stmt->execute($sql);
		
		//on met a jour les classements des definitions reliées au nouveau mot
		
		//on determine le classement de la definition selon sa nouvelle taille
		$sql = "SELECT COALESCE(MAX(CLASSEMENT),0) AS CLA FROM TABLE_DEFINITION WHERE MOT='".$mot."' AND TAILLE_DEFINITION<=".$tailleDef.";";
		$res = $bdd->query($sql);
		$row = $res->fetch();
		$classement = $row['CLA']+1;
		
		//on met a jour les classements des definitions de ce meme nouveau mot de taille superieur a cette definition
		$sql = "UPDATE TABLE_DEFINITION SET CLASSEMENT = CLASSEMENT+1 WHERE MOT='".$mot."' AND CLASSEMENT >=".$classement.";";
		$stmt= $bdd->prepare($sql); 
		$stmt->execute(); 
		
		
		
    $sql = "UPDATE TABLE_DEFINITION SET MOT='".$mot."', DEFINITION='".str_replace("'","''",$definition)."', DATE_MODIF=NOW(), ID_UTILISATEUR_MODIF=".$idU.", TAILLE_DEFINITION=".$tailleDef.", CLASSEMENT=".$classement." WHERE ID_DEFINITION=".$id.";";
    $stmt= $bdd->prepare($sql); 
		$stmt->execute(); 
		
    header('location: accueil.php');
  }
 
  if(isset($_GET['id']) AND !empty($_GET['id'])) 
  {
   $id = htmlspecialchars($_GET['id']);
   $sql = 'SELECT ID_DEFINITION, MOT, DEFINITION, DATE_MODIF FROM TABLE_DEFINITION WHERE ID_DEFINITION = "'.$id.'"';
   $res = $bdd->query($sql);
   $row = $res->fetch();
  }

 
 
?>

<br/>

<div class="header" style="background-color: purple">
  <h2>Modifier la définition</h2>
</div>

<form method="post" action="modifier.php" class= "formulaire_stylise">
  <div>
    <input type="hidden" value="<?php echo $row['ID_DEFINITION']; ?>" name="id"/>
  </div>
  <div class="form-group">
    <label>mot</label>
    <input type="text" name="mot" value="<?php echo $row['MOT']; ?>">
  </div>
  <div class="form-group">
    <label>Définition</label>
    <textarea class="form-control" id="definition" name ="definition" rows="3"><?php echo $row['DEFINITION']; ?></textarea>
  </div>
  <div>
    <input type="hidden" name="date_ajout" value="<?php echo $row['DATE_MODIF']; ?>">
  </div>
  <div class="input-group">
    <button type="submit" class="btn" name="modifier">Modifier</button>
  </div>
</form>

</body>

<?php include("script_menu.php"); ?>
