<?php

namespace Dara\Helpers;

use PDO;
use Dotenv\Dotenv;
use Dara\Origins\Connection;


trait BaseModelHelper
{

    /**
     * Get all the column names in a table
     * 
     * @return array
     */
    protected function getTableFields()
    {   
        $connection = Connection::connect();

        $q = $connection->prepare('describe '.$this->getTableName($this->className));
        $q->execute();
        
        return $q->fetchAll(PDO::FETCH_COLUMN);        
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
     * Check if an id exists
     * 
     * @param $id
     * @return mixed
     */
    protected static function confirmIdExists($id)
    {
        return self::find($id)->resultRows[0];
    }  


    /**
     * Get user assigned column values
     * 
     * @return array
     */
    protected function getAssignedValues()
    {
        $tableFields = $this->getTableFields();
        $newPropertiesArray = get_object_vars($this);

        $columns = $values = $tableData = [];

        foreach ($newPropertiesArray as $index => $value) {
            if (in_array($index, $tableFields)) {
                array_push($columns, $index);
                array_push( $values, $value);
            }
        }

        $tableData['columns'] = $columns;
        $tableData['values'] = $values; 

        return $tableData;
    }


    /**
     * Get table name for the called model
     * 
     * @param $model
     * @return string
     */
    protected function getTableName($model)
    {   
        $nameArray = explode('\\', $model);
        return $nameArray[count($nameArray)-1].'s';
    }


    /**
     * Check if a row already exists
     * 
     * @return int
     */
    protected function checkForRows()
    {
        return count($this->resultRows);
    }

}