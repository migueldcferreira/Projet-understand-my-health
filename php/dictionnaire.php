<!doctype html>
<html lang="fr">
  <head>
    <?php session_start();
    include("head.php"); ?>
    <link rel="stylesheet" href="..\css/choosetrad.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
  

  </head>
  <body>

  <?php include("menu.php"); 

    require('Bdd.php');

    try
    {
      $bdd = Bdd::connect("BDD_TRADOCTEUR");
      $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Permet de récuperer une exception lorsque il y a une erreur au niveau de la base de donnée.
                                       //On pourra donc traiter l'erreur plus simplement avec un try et catch.

      $sql_base = "SELECT ID_DEFINITION, MOT, DEFINITION, DATE_AJOUT FROM TABLE_DEFINITION WHERE A_CONFIRMER = 0"; //requête pour trouver les définitions validées
      $res_base = $bdd->query($sql_base);
    }
    catch (Exception $e)
    {
        die('Erreur : ' . $e->getMessage());
    }

  ?>
	
  <table id = "table_data" class="display">
    <thead>
        <tr>
            <th scope="col">Mot</th>
            <th scope="col">Définition</th>
            <th scope="col">Date_ajout</th>
            <th scope="col"></th>
          </tr>
    </thead>
    <tbody>
          <?php while ($row = $res_base->fetch()) { ?>
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


  

  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
  <script type="text/javascript" src="..\javascript/dataTable.js"></script>
 
	<?php include("script_menu.php"); ?>

  </body>
</html>
