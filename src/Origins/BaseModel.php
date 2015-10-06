<?php

namespace Dara\Origins;

use PDO;
use Dotenv;

abstract class BaseModel
{


    public function __construct()
    {
        $this->loadEnv();
        $this->connection = new Connection($_ENV['P_DRIVER'], $_ENV['P_HOST'], $_ENV['P_DBNAME'], $_ENV['P_USER'], $_ENV['P_PASS']);
        $this->className = get_called_class();
    }


    /**
     * Load environment variables
     * 
     * @return null
     */
    public function loadEnv()
    {
        $dotenv = new Dotenv\Dotenv(__DIR__.'/../..');
        $dotenv->load();
    }


    /**
     * Create an instance of the called model
     * 
     * @return mixed
     */
    protected static function createModelInstance()
    {
        $model = get_called_class();
        return new $model();
    }


    /**
     * Return  all the rows from a table
     * 
     * @return array
     */
    public static function getAll()
    {
        return self::doSearch()->resultRows;
    }


    /**
     * Choose to either search database for one row or all rows depending on whether the $id argument is passed
     * 
     * @param int $id
     * @return mixed
     */
    protected static function doSearch($id = null)
    {
        $model = self::createModelInstance();
        $tableName = $model->getTableName($model->className);

        return $id ? self::selectOne($model, $tableName, $id) : self::selectAll($model, $tableName);
    }


    /**
     * Search database for all rows
     * 
     * @param $model
     * @param $tableName
     * @return mixed
     */
    protected static function selectAll($model, $tableName)
    {
        $getAll = $model->connection->prepare('select * from '.$tableName);
        $getAll->execute();

        while ($allRows = $getAll->fetch(PDO::FETCH_ASSOC)) {
            array_push($model->resultRows, $allRows);
        }

        return $model;
    }


    /**
     * Search database for one row
     * 
     * @param $model
     * @param $tableName
     * @param $id
     * @return mixed
     */
    protected static function selectOne($model, $tableName, $id)
    {
        $getAll = $model->connection->prepare('select * from '.$tableName.' where id='.$id);
        $getAll->execute();

        $row = $getAll->fetch(PDO::FETCH_ASSOC);
        array_push($model->resultRows, $row);
        
        return $model;
    }


    /**
     * Return the database rows 
     * 
     * @param $id
     * @return mixed
     */
    public static function find($id = null)
    {
        return self::doSearch($id);
    }

}