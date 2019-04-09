<!doctype html>
<html lang="fr">
<head>
	<?php
		session_start();
		include("head.php");
	?>
	
	<link rel="stylesheet" href="../css/dictionnaireIllustre.css" />
	
</head>

<body>
  <?php
    include("menu.php");
    if(isset($_GET['mot']))
    {
      $mot = $_GET['mot'];
    }
    else
    {
      header('location:accueil.php');
    }
  ?>
  
	<br/><br/>
  <h1 class="title"><span> <?php echo $mot; ?> </span></h1>
	<br/><br/>
	
  <div class="panel-group">
    <?php
      require("Bdd.php");
      //connexion a la base de donnees   
      try
      {
        $bdd = Bdd::connect("BDD_TRADOCTEUR");
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //Permet de récuperer une exception lorsque il y a une erreur au niveau de la base de donnée.
        //On pourra donc traiter l'erreur plus simplement avec un try et catch.
      }
      catch (Exception $e)
      {
        die('Erreur : ' . $e->getMessage());
      }
      
			$sdl = "SELECT DEFINITION FROM TABLE_DEFINITION WHERE MOT = '".str_replace("'","''",$mot)."' AND A_CONFIRMER=0 ORDER BY CLASSEMENT;"; 
			$res = $bdd->query($sdl);
      
      $compteur = 1;
      
      while(!empty($row = $res->fetch()))
      {
			  $definition = $row['DEFINITION'];
				echo '<div class="panel panel-primary">
      					<div class="panel-heading">Definition '.$compteur.'</div>
      					<div class="panel-body">'.$definition.'</div>
    					</div>';
        //echo "Définition $compteur : $definition";
        echo "<br/><br/>";
				$compteur += 1;
      }
		
			$sdl = "SELECT ID_IMAGE FROM TABLE_IMAGE NATURAL JOIN TABLE_LIEN_MOT_IMAGE WHERE MOT = '".str_replace("'","''",$mot) ."' AND A_CONFIRMER=0 ORDER BY CLASSEMENT;"; 
			$res = $bdd->query($sdl);
      
      $compteur = 1;
      
      while(!empty($row = $res->fetch()))
      {
			  $idImage = $row['ID_IMAGE'];
				echo '<div class="panel panel-primary">
      					<div class="panel-heading">Image '.$compteur.'</div>
      					<div class="panel-body"><img style="max-width: 100%; height: auto;" src="genererImage.php?id='.$idImage.'" height="" width="" alt="mon image" title="image"/></div>
    					</div>';
        //echo "Image $compteur : <br/>";
				//echo '<img style="max-width: 50%; height: auto;" src="genererImage.php?id='.$idImage.'" height="" width="" alt="mon image" title="image"/>';
        echo "<br/><br/>";
				$compteur += 1;
      }
      
    ?>
  </div>

  <?php include("script_menu.php"); ?>
</body>
</html>
