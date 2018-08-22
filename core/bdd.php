<?php
	class BDD
	{
		protected static $_bdd;
        
        function __construct()
        {
            $db_config = array(
                "SGBD" => "mysql",
                "HOST" => "localhost",
                "DB_NAME" => "sas",
                "USER" => "root",
                "PASSWORD" => '', // $SaSBadminTon@sql1820_
                "CHARSET" => "utf8",
                "PORT" => 3306,
                "OPTIONS" => array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Activation des exceptions PDO
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // Change le fetch mode par défaut sur FETCH_ASSOC ( fetch() retournera un tableau associatif )
                )
            );
            
            try
            {
                self::$_bdd = new \PDO("{$db_config['SGBD']}:dbname={$db_config['DB_NAME']};host={$db_config['HOST']};charset={$db_config['CHARSET']};port={$db_config['PORT']}", "{$db_config['USER']}", "{$db_config['PASSWORD']}", $db_config['OPTIONS']);
            }
            catch(Exception $e)
            {
                trigger_error($e->getMessage(), E_USER_ERROR);
            }
        }
        
        public static function getInstance()
        {
            if(!isset(self::$_bdd))
            {
                $c = __CLASS__;
                self::$_bdd = new $c;
            }
            
            return self::$_bdd;
        }
        
		// Permet d'effectuer la requête SQL
        public static function _request($sql, $values)
        {
            $req = self::getInstance()->prepare($sql);
            $req->execute($values);
			
			if(strpos($sql, "UPDATE") === FALSE && strpos($sql, "INSERT") === FALSE && strpos($sql, "DELETE") === FALSE)
			{	
				return $req->fetchAll();
			}
        }
		
		// Teste si l'utilisateur est un administrateur
		public static function _isAdmin()
		{
			if(isset($_SESSION['session']))
			{
				return $_SESSION['session']['isAdmin'];
			}
		}
		
		// Teste si l'utilisateur est un modérateur/capitaine d'équipe
		public static function _isMod()
		{
			if(isset($_SESSION['session']))
			{
				return $_SESSION['session']['isMod'];
			}
		}
		
		// Teste si l'utilisateur est un resposable de séance
		public static function _isResp()
		{
			if(isset($_SESSION['session']))
			{
				return $_SESSION['session']['isResponsable'];
			}
		}
		
		// Teste si l'utilisateur est un membre du CA
		public static function _isCA()
		{
			if(isset($_SESSION['session']))
			{
				return $_SESSION['session']['isCA'];
			}
		}
		
		// Teste si l'utilisateur est connecté
		public static function _isLogged()
		{
			if(isset($_SESSION['session']) && strlen($_SESSION['session']['token']) == 128)
			{
				return true;
			}
			
			return false;
		}
	}
?>