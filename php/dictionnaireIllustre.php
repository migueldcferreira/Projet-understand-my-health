<!doctype html>
<html lang="fr">
<head>
  <?php
    session_start();
    include("head.php");
  ?>
  <link rel="stylesheet" href="../css/traduction.css" />
  <link rel="stylesheet" href="../css/simplifier.css" />
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
  
  <br/>
  <h1 class="title"><span> <?php echo $mot; ?> </span></h1>

  <div>
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
      
      $sdl = "SELECT DEFINTION FROM TABLE_DEFINITION WHERE MOT = '".$mot."' ORDER BY CLASSEMENT;"; 
			$res = $bdd->query($sdl);
      
      $compteur = 1;
      
      while(!empty($row = $res->fetch()))
      {
			  $definition = $row['DEFINITION'];
        echo "Définition $compteur: $definition";
        echo "<br /><br />";
      }
      
    ?>
  </div>

  <?php include("script_menu.php"); ?>
</body>
</html>
