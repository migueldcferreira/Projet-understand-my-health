<?php
Class Bdd{
	 private static
      $BddServeur     = 'localhost',
      $BddIdentifiant = 'root',
      $BddMdp         = 'BDDTradocteur',
	  $Lien           = null;


	public function __construct()
    {
		die('fonction Init non autorisée');
    }


	public static function connect($BddNom)
	{
		// Autoriser une seule connexion pour toute la durée de l’accès
		if ( null == self::$Lien )
		{
			try
			{
				self::$Lien = new PDO("mysql:host=".self::$BddServeur.";"."dbname=".$BddNom, self::$BddIdentifiant, self::$BddMdp , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			}
			catch(PDOException $e)
			{
				die($e->getMessage());
			}
		}
		return self::$Lien;
	} 


	public static function disconnect()
	{
		self::$Lien = null;
	}

}
?>
