<?php

namespace connection;

class ConnectionFactory{

	protected static $connect = null;
    private $dsn;

	public static function makeConnection(array $conf){
		
        $dsn = 'mysql:host='.$conf["host"].';dbname='.$conf["base"];

        try{

            self::$connect = new \PDO($dsn, $conf['user'], $conf['pass'], array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING, \PDO::ATTR_PERSISTENT => true, \PDO::ATTR_EMULATE_PREPARES => false, \PDO::ATTR_STRINGIFY_FETCHES => false));

			
            return self::$connect;

        } catch (\PDOException $e){

            print "Erreur !: " . $e->getMessage() . "<br/>";
            die();
		}
    }


    public static function getConnection(){

            return self::$connect;
    }

	/*public static function makeConnection($nomFichier){
		
		self::$config=parse_ini_file($nomFichier);
		
		if(!isset($db)){
			
			$host=self::$config['host'];
			$base=self::$config['database'];
			$user=self::$config['username'];
			$pass=self::$config['password'];
			$option=array(	\PDO::ATTR_PERSISTENT=>true,
					\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
					\PDO::ATTR_EMULATE_PREPARES=> false,
					\PDO::ATTR_STRINGIFY_FETCHES => false);
			$dsn = "mysql:host=$host;dbname=$base";
			
			try{
				self::$db=new \PDO($dsn, $user, $pass, $option);
				return self::$db;
			} catch(PDOExeption $e){
				echo "Erreur !: " . $e->getMessage() . "<br/>";
				die();
			}
			
		}else{
			return self::$db;
		}
	}

	public static function getConnection() { 
		$host=self::$config['host'];
		$base=self::$config['database'];
		$user=self::$config['username'];
		$pass=self::$config['password'];
		$option=array(	\PDO::ATTR_PERSISTENT=>true,
					\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
					\PDO::ATTR_EMULATE_PREPARES=> false,
					\PDO::ATTR_STRINGIFY_FETCHES => false);
		if (!self::$db){
			self::$db = new PDO("mysql:host=$host;dbname=$base", $user, $pass, $option);
		}

		return self::$db;
	}*/
}
