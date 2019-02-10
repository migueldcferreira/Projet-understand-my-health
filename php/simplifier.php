<?php
  require('Bdd.php');
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

  //$balise =
  //0: on cherche des mots difficiles dans les balises (<>),
  //1: on supprime les balises et leur contenue,
  //2: on laisse les balises mais on ne cherche pas de mots difficiles dedans
  function simplifierTexteBrut($text, $balise)
  {
    $mot = "";
    $nbBaliseOuvrante = 0;
    foreach($text as $lettre)
    {
      if($nbBaliseOuvrante==0 and preg_match("#[a-zA-Z]#",$lettre) or (strlen($mot)>0 and $lettre=="-"))
      {
        $mot = $mot . "$lettre";
      }
      else
      {
        if(strlen($mot) > 0)
        {
          $sql = "SELECT DEFINITION FROM TABLE_DEFINITION WHERE MOT LIKE '$mot';";
      		$res = $bdd->query($sql); //On récupère (s'il en existe) les lignes de notre table "produits" qui répondent à notre requête $sql.
      								  //Ces lignes sont stockées dans la variables $res qui est un tableau du jeu de résultat de notre requête.
      		if(!empty($row = $res->fetch())) //La méthode fetch() permet de récupérer la ligne suivante du résultat de notre requete qui sont stockés dans la variable $res.
      		{
      			//while (!empty($row))
      			//{
      				echo '<span class="vocabulaire">
      							<span class="expression">'.$mot.'</span>
      							<span class="definition hidden">'.$row['DEFINITION'].'</span>
      						</span>';
      			//$row = $res->fetch();
      			//}
      		}
      		else
      		{
      			echo "$mot";
      		}
        }
        $mot = "";
        /*if($balise>0 and $lettre == "<")
        {
          $nbBaliseOuvrante += 1;
        }
        elseif($balise>0 and $nbBaliseOuvrante > 0 and $lettre == ">")
        {
          $nbBaliseOuvrante -= 1;
        }
        else
        {
          if(!($balise == 1) or $nbBaliseOuvrante==0)
            echo "$lettre";
        }*/
      }
    }
    echo "$mot";
  }
?>
