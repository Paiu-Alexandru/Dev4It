<?php
namespace Model;

class BookModel extends Model
{ 
    public function selectAll()
    {
        $sql = "SELECT book.name, gender.gender, book.pages_number, book.price 
                FROM book INNER JOIN gender ON book.id_gender = gender.id
                ORDER BY book.id DESC ";
        $stm = $this->db->query($sql);

        return $stm->fetchAll();
    }

    public function getByName($name)
    {
        $sql = "SELECT * FROM book WHERE LOWER(name) = :name";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    

    public function save($data)
    {
        $lower = strtolower($data['name']);
        $new_name = str_replace(" ","",$lower);

        $sql = "Insert INTO book(id_gender, name, unique_name, pages_number, price) VALUES (:id_gender, :name, :unique_name, :pages_number, :price)";
        $stmt = $this->db->prepare( $sql);
        $stmt->bindParam(':id_gender', $data['gender']);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':unique_name', $new_name);
        $stmt->bindParam(':pages_number', $data['page_number']);
        $stmt->bindParam(':price', $data['price']);

        return $stmt->execute();
    }

}


?>