<?php
require_once(__DIR__ . '/../Model/your_unique_news_model.php');
require_once(__DIR__ . '/../config/database.php');
class YourUniqueNewsController
{
    private $model;

    public function __construct($db)
    {
        $this->model = new YourUniqueNewsModel($db);
    }

    public function showNews()
    {
        // Obtener el parámetro de categoría de la URL
        $categoryId = isset($_GET['category']) ? htmlspecialchars($_GET['category']) : null;
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

        // Validar y sanear el valor de la categoría antes de pasarlo al modelo
        if ($categoryId === 'all' || empty($categoryId)) {
            // Obtener todas las noticias sin filtrar por categoría
            $noticias = $this->model->getNews(null, $userId);
        } else {
            $categoryId = filter_var($categoryId, FILTER_VALIDATE_INT);

            // Verificar si el valor de la categoría es válido
            if ($categoryId !== false && $categoryId > 0) {
                // Obtener noticias desde el modelo con el parámetro de categoría
                $noticias = $this->model->getNews($categoryId, $userId);
            } else {
                // Manejar el caso en que la categoría no sea válida
                $noticias = array(); // o mostrar un mensaje de error
            }
        }

        return $noticias;
    }
}

$database = new Database();
$db = $database->conectar();
$NewsController = new YourUniqueNewsController($db);

$NewsController->showNews();
