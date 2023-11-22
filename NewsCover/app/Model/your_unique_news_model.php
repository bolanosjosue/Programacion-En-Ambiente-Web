<?php
class YourUniqueNewsModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getNews($categoryId = null, $userId)
    {
        $query = "SELECT n.id, n.title, n.short_description, c.name AS category_name, n.permanlink, n.urlImage, n.date, n.news_source_id, n.user_id
        FROM NEWS n
        INNER JOIN categories c ON n.category_id = c.id 
        WHERE n.user_id = $userId";

        // Agregar condición para filtrar por categoría si se proporciona
        if ($categoryId !== null) {
            $query .= " AND n.category_id = :category_id";
        }

        $stmt = $this->db->prepare($query);

        // Asignar valor al parámetro de categoría si se proporciona
        if ($categoryId !== null) {
            $stmt->bindValue(':category_id', $categoryId);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
