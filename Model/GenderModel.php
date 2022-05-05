<?php
namespace Model;
use \PDO;

class GenderModel extends Model
{

    public function getAll()
    {
        $sql = $this->db->prepare("SELECT * FROM gender");
        $sql->execute();
        return $sql->fetchAll();
    }

    public function getById($id)
    {
        $sql = $this->db->prepare("SELECT * FROM gender WHERE id=".(int)$id);
        $sql->execute();
        return $sql->fetchAll();
    }
}