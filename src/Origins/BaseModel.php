<?php

namespace Dara\Origins;

use PDO;
use Dotenv;
use Exception;


abstract class BaseModel
{

    use \Dara\Helpers\BaseModelHelper;


    /**
     * The name of the model 
     * 
     * @var string
     */
    protected $className;

    /**
     * The directory that contains your .env file
     * @var string
     */
    protected $envDirectory = __DIR__.'/../..';

    /**
     * An instance of the Connection class
     * 
     * @var PDO
     */
    protected $connection;


    /**
     * Array of table rows
     * 
     * @var array
     */
    protected $resultRows = [];


    public function __construct()
    {
        $this->loadEnv();
        $this->connection = new Connection($_ENV['P_DRIVER'], $_ENV['P_HOST'], $_ENV['P_DBNAME'], $_ENV['P_USER'], $_ENV['P_PASS']);
        $this->className = get_called_class();
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


    /**
     * Edit an existing row or insert a new row depending on whether the row already exists
     * 
     * @return bool|string
     */
    public function save()
    {   
        return $this->checkForRows() ? $this->updateRow() : $this->insertRow();
    }


    /**
     * Insert a new row 
     * 
     * @return string
     */
    protected function insertRow()
    {   
        $assignedValues = $this->getAssignedValues();

        $columns = implode(', ', $assignedValues['columns']);
        $values = '\''.implode('\', \'', $assignedValues['values']).'\'';

        $tableName = $this->getTableName($this->className);
        $insert = $this->connection->prepare('insert into '.$tableName.'('.$columns.') values ('.$values.')');

        if ($insert->execute()) { 
            return 'Row inserted successfully'; 
        } else { 
            throw new Exception("Unable to Insert new row", 1); 
        } 
    }

    /**
     * Edit an existing row
     * 
     * @return bool
     */
    protected function updateRow()
    {   
        $tableName = $this->getTableName($this->className);
        $assignedValues = $this->getAssignedValues();
        $updateDetails = [];

        for ($i = 0; $i < count($assignedValues['columns']); $i++) { 
            array_push($updateDetails, $assignedValues['columns'][$i]  .' =\''. $assignedValues['values'][$i].'\'');
        }

        $allUpdates = implode(', ' , $updateDetails);
        $update = $this->connection->prepare('update '.$tableName.' set '. $allUpdates.' where id='.$this->resultRows[0]['id']);
       
        if ($update->execute()) { 
            return 'Row updated';
        } else { 
            throw new Exception("Unable to update row"); 
        }
    }


    /**
    * Call doDelete function if the specified id exists
    * 
    * @param $id
    * @return string
    */
    public static function destroy($id)
    {
        if (self::confirmIdExists($id)) {
            self::doDelete($id); 
        } else { 
            throw new Exception('Now rows found with ID '.$id.' in the database, it may have been already deleted'); 
        }
    }

    /**
     * Delete an existing row from the database
     * 
     * @param $id
     * @return string
     */
    protected static function doDelete($id)
    {
        $model = $this->createModelInstance();
        $tableName = $model->getTableName($model->className);
        $delete = $model->connection->prepare('delete from '.$tableName.' where id ='.$id);
        $delete->execute();

        return 'true';
    }

}