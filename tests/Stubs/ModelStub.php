<?php 

namespace Dara\Test\Stubs;

use Dara\Origins\BaseModel;

class ModelStub extends BaseModel
{
    public function loadEnv()
    {
        $_ENV['P_DRIVER'] = '';
        $_ENV['P_HOST']   = 'localhost';
        $_ENV['P_DBNAME'] = 'potato';
        $_ENV['P_USER']   = 'root';
        $_ENV['P_PASS']   = '';
    }

}