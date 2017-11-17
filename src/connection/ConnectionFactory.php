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
}
