	<?php
    include("menu_admin.php");
    require('Bdd.php');
    
    $file = "../../export.csv";
    $myfile = fopen($file, "w") or die("Unable to open file!");   
    
    if(isset($_POST["formeCompacte"]))
    {
      $sql = "SELECT MOT, DEFINITION, METHODE FROM TABLE_DEFINITION;";
    }
    else
    {
      $sql = "SELECT * FROM TABLE_DEFINITION;";
    }
    
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
    
    $res = $bdd->query($sql); //On récupère (s'il en existe) les lignes de notre table "produits" qui répondent à notre requête $sql.
                    //Ces lignes sont stockées dans la variables $res qui est un tableau du jeu de résultat de notre requête.
    while(!empty($row = $res->fetch())) //La méthode fetch() permet de récupérer la ligne suivante du résultat de notre requete qui sont stockés dans la variable $res.
    {
      if(isset($_POST["formeCompacte"]))
      {
        $txt = $row['MOT']."|".$row['DEFINITION']."|".$row['METHODE']."\r\n";
      }
      else
      {
        $txt = $row['ID_DEFINITION']."|".$row['MOT']."|".$row['DEFINITION']."|".$row['METHODE']."\r\n";
      }
      
      fwrite($myfile, $txt);
    }
    
    fclose($myfile);
    
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
  ?>
