<?php

namespace Dara\Helpers;

use PDO;
use Dotenv\Dotenv;


trait BaseModelHelper
{

    /**
     * Load environment variables if they are not available
     * 
     * @return null
     */
    public function loadEnv()
    {   
        if (!$this->checkEnv()) {
            $dotenv = new Dotenv($this->envDirectory);
            $dotenv->load();
        }
    }


    /**
     * Check if required env variables are available
     * 
     * @return bool
     */
    private function checkEnv()
    {
        return isset($_ENV['P_DBNAME']) ? true : false;
    }


    /**
     * Get all the column names in a table
     * 
     * @return array
     */
    protected function getTableFields()
    {
        $q = $this->connection->prepare('describe '.$this->getTableName($this->className));
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
        $newPropertiesArray = array_slice(get_object_vars($this), 3);

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
        return strtolower(explode('\\', $model)[2]).'s';
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