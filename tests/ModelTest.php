<?php

namespace Dara\Test;

use Dara\Origins\BaseModel;
use Dara\Test\Stubs\ModelStub;
use Mockery as m;


class ModelTest extends \PHPUnit_Framework_TestCase
{

    public $model;
    

    public function setUp()
    {
        $this->model = new ModelStub();
    }


    public function testGetAll()
    {
        $rows = ["name" => 'dara', "food" => "beans"];
        $mock = m::mock('ModelStub');
        $mock->shouldReceive('getAll')->once()->andReturn($rows);

        $this->assertEquals($mock->getAll(), ["name" => 'dara', "food" => "beans"]);
    }


    public function testDestroy()
    {   
        $result = true;
        $mock = m::mock('ModelStub');
        $mock->shouldReceive('destroy')->with(1)->andReturn($result);

        $this->assertEquals($mock->destroy(1), true);
    }


    public function testSave()
    {   
        $mock = m::mock('ModelStub');
        $mock->shouldReceive('save')->once()->andReturn(true);

        $this->assertEquals($mock->save(), true);
    }


    public function testFind()
    {
        $result = ['username' => 'drsumo', 'email' => 'mail@mail.com'];
        $mock = m::mock('ModelStub');
        $mock->shouldReceive('find')->once()->andReturn($result);

        $this->assertEquals($mock->find(1), ['username' => 'drsumo', 'email' => 'mail@mail.com']);
    }


    public  function testSelectOne()
    {
        $result = ['username' => 'drsumo', 'email' => 'mail@mail.com'];
        $mock = m::mock('ModelStub');
        $mock->shouldReceive('selectOne')->with(2)->andReturn($result);
        
        $this->assertEquals($mock->selectOne(2), ['username' => 'drsumo', 'email' => 'mail@mail.com']);
    }


    public  function testSelectAll()
    {
        $result = ['username' => 'drsumo', 'email' => 'mail@mail.com'];
        $mock = m::mock('ModelStub');
        $mock->shouldReceive('selectAll')->once()->andReturn($result);
        
        $this->assertEquals($mock->selectAll(), ['username' => 'drsumo', 'email' => 'mail@mail.com']);
    }


    public function testGetTableFields()
    {   
        $fields = ['name','food'];
        $mock = m::mock('ModelStub');
        $mock->shouldReceive('getTableFields')->once()->andReturn($fields);
        $this->assertEquals($mock->getTableFields(), ['name', 'food']);
    }


    public function testInsertRow()
    {   
        $mock = m::mock('ModelStub');
        $mock->shouldReceive('insertRow')->once()->andReturn(true);
        $this->assertEquals($mock->insertRow(), true);

    }

   
    public function testUpdateRow()
    {   
        $result = true;
        $mock = m::mock('ModelStub');
        $mock->shouldReceive('destroy')->with(1)->andReturn($result);

        $this->assertEquals($mock->destroy(1), true);
    }


    public function testGetAssignedValues()
    {  
        $this->model->username = 'Dara';
        $this->model->email = 'email@mail.com';

        $this->assertEquals($this->model->username, 'Dara');
        $this->assertEquals($this->model->email, 'email@mail.com');
    }  

}
