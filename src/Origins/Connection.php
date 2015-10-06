<?php

namespace Dara\Origins;

use PDO;

class Connection extends PDO
{

    protected $driver;

    protected $host;

    protected $dbname;
    
    protected $user; 
    
    protected $pass;

    public function __construct($driver, $host, $dbname, $user, $pass)
    {
        $this->driver  = $driver;
        $this->host    = $host;
        $this->dbname  = $dbname;
        $this->user    = $user;
        $this->pass    = $pass;

        parent::__construct($this->driver.':host='.$this->host.';dbname='.$this->dbname, $this->user, $this->pass);
    }

}