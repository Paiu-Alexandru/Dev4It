<?php
namespace Model;
use \PDO;

class Model
{
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $dbName = "dev4it";
    protected $db;

    public function __construct()
    {
        $dsn = "mysql:host=".$this->host.";dbname=".$this->dbName;
      
            $this->db = new PDO($dsn, $this->user, $this->pass);
            $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            return $this->db;
        
        
    } 
}