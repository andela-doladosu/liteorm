<?php

namespace Dara\Origins;

use PDO;
use Dotenv\Dotenv;


class Connection extends PDO
{

    protected static $driver;

    protected static $host;

    protected static $dbname;
    
    protected static $user; 
    
    protected static $pass;


    /**
     * Get environment values from .env file
     * 
     * @return null
     */
    public static function getEnv()
    {   
        if (!isset(getenv('P_DRIVER'))) {

            $dotEnv = new Dotenv($_SERVER['DOCUMENT_ROOT']);
            $dotEnv->load();
        }    
      
        self::$driver  = getenv('P_DRIVER');
        self::$host    = getenv('P_HOST');
        self::$dbname  = getenv('P_DBNAME');
        self::$user    = getenv('P_USER');
        self::$pass    = getenv('P_PASS');  
    }

    /**
     * Create PDO connections
     * 
     * @return PDO
     */
    public static function connect()
    {   
        self::getEnv();
        return new PDO(self::$driver.':host='.self::$host.';dbname='.self::$dbname, self::$user, self::$pass);
    }


}