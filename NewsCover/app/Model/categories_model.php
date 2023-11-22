<?php

class CategoryModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function insertCategory($name)
    {
        $query = "INSERT INTO categories (name) VALUES (?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$name]);

        return $stmt->rowCount() > 0;
    }

    public function getCategories()
    {
        $query = "SELECT * FROM categories";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteCategory($id)
    {
        $query = "DELETE FROM categories WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);

        return $stmt->rowCount() > 0;
    }

    public function updateCategory($id, $name)
    {
        $query = "UPDATE categories SET name = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$name, $id]);

        return $stmt->rowCount() > 0;
    }

}
