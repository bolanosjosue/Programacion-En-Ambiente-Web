<?php
class NewsSourcesModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function insertNewsSource($nombreFuente, $rssUrl, $categoriaId, $userId)
    {
        $query = "INSERT INTO news_sources (url, name, category_id, user_id) VALUES (?, ?, ?, ?)";

        $stmt = $this->db->prepare($query);
        $stmt->execute([$rssUrl, $nombreFuente, $categoriaId, $userId]);

        return $stmt->rowCount() > 0;
    }

    public function insertNews($id, $title, $url, $short_description, $pubDate, $urlImage, $category_id, $user_id)
    {
        // Verificar si ya existe un registro con los mismos valores
        $checkQuery = "SELECT COUNT(*) FROM news WHERE title = ? AND permanlink = ? AND news_source_id = ? AND user_id = ?";
        $checkStmt = $this->db->prepare($checkQuery);
        $checkStmt->execute([$title, $url, $id, $user_id]);
        $count = $checkStmt->fetchColumn();

        // Si ya existe un registro, no realizar la inserción
        if ($count > 0) {
            return false;
        }

        // Si no existe, proceder con la inserción
        $insertQuery = "INSERT INTO news (title, short_description, permanlink, urlImage, date, news_source_id, user_id, category_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $insertStmt = $this->db->prepare($insertQuery);
        $insertStmt->execute([$title, $short_description, $url, $urlImage, $pubDate, $id, $user_id, $category_id]);

        return $insertStmt->rowCount() > 0;
    }

    public function optenerIndice()
    {
        $query = "SELECT id FROM news_sources ORDER BY id DESC LIMIT 1;";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        // Obtener el ID del último registro
        $lastId = $stmt->fetchColumn();

        return $lastId;
    }

    public function getNewsSources($userId)
    {
        $query = "SELECT n.id, n.url, n.name, c.name AS category_id, n.user_id 
        FROM news_sources n 
        INNER JOIN categories c ON n.category_id = c.id 
        WHERE n.user_id = $userId
        LIMIT 0, 25";

        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getNewsSourcesAll()
    {
        $query = "SELECT n.id, n.url, n.name, c.name AS category_id_name,n.category_id, n.user_id 
        FROM news_sources n 
        INNER JOIN categories c ON n.category_id = c.id 
        LIMIT 0, 25";

        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function eliminarNoticia($id)
    {
        $queryOtraTabla = "DELETE FROM news WHERE news_source_id  = ?";
        $stmtOtraTabla = $this->db->prepare($queryOtraTabla);
        $stmtOtraTabla->execute([$id]);

        // Luego, procedemos a eliminar el registro de la tabla news_sources
        $queryNewsSources = "DELETE FROM news_sources WHERE id = ?";
        $stmtNewsSources = $this->db->prepare($queryNewsSources);
        $stmtNewsSources->execute([$id]);

        // Verificamos si se eliminaron registros en ambas consultas
        return ($stmtOtraTabla->rowCount() > 0) && ($stmtNewsSources->rowCount() > 0);
    }

    public function getCategoriesName($id)
    {
        $query = "SELECT name FROM categories WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);

        // Utiliza fetchColumn para obtener directamente el valor de la columna 'name'
        return $stmt->fetchColumn();
    }

    public function updateNewsSource($idNoticia, $nombreFuente, $rssUrl, $categoriaId)
    {
        $query = "UPDATE news_sources SET name = ?, url = ?, category_id = ? WHERE id = ?";

        $stmt = $this->db->prepare($query);
        $stmt->execute([$nombreFuente, $rssUrl, $categoriaId, $idNoticia]);

        return $stmt->rowCount() > 0;
    }

    // Puedes agregar más funciones según sea necesario

}
