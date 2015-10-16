<?php 

namespace Dara\Test\Stubs;

use Mockery as m;
use Dara\Origins\BaseModel;
use Dara\Origins\Connection;

class ModelStub extends BaseModel
{

    public function __construct()
    {
        $this->connection = m::mock('\Dara\Origins\Connection');
        parent::__construct();
    }
    public function loadEnv()
    {
        $_ENV['P_DRIVER'] = 'mysql';
        $_ENV['P_HOST']   = 'localhost';
        $_ENV['P_DBNAME'] = 'potato';
        $_ENV['P_USER']   = 'root';
        $_ENV['P_PASS']   = '';
    }

}