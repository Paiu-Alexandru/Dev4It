<?php
namespace Controller;
use Model\BookModel;
use \PDO;

class BookController extends BookModel
{
    public $data = [];
   
    public function showBooks()
    {
        $this->data = $this->selectAll();
        return  $this->data;
           
    }
    public function paginate($rows, $per_page)
    {
        $total_rows = count($rows);
        $current_page = isset($_GET['page']) && $_GET['page'] && is_numeric( $_GET['page']) ?  $_GET['page'] : 1;
        
        $counts = ceil($total_rows / $per_page);//find out how many pages I have
        $param1 = ($current_page - 1) *  $per_page;//offset (how many rows i skip from db in my case "can be any array")
        $this->data = array_slice($rows, $param1, $per_page);// array offset limit

        for ($i=1; $i <= $counts; $i++) { 
                $numbers[] = $i;
        }
        return $numbers;
    }
    public function fetchResult()
    {
        $resultsValue = $this->data;
        return $resultsValue;
    }
}
?>