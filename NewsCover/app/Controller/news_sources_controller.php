<?php
require_once(__DIR__ . '/../Model/news_sources_model.php');

require_once(__DIR__ . '/../config/database.php');



class NewsSourcesController
{
    private $model;
    private $db;

    public function __construct($db)
    {
        $this->model = new NewsSourcesModel($db);
        $this->db = $db;
    }

    public function addNewsSource()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombreFuente = $_POST['fuente'];
            $rssUrl = $_POST['rssUrl'];
            $categoriaId = $_POST['categoriaSelect']; // ID de la categoría seleccionada

            // Obtener el ID del usuario de la sesión
            session_start();
            $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

            // ...

            if ($userId) {
                if ($this->model->insertNewsSource($nombreFuente, $rssUrl, $categoriaId, $userId)) {
                     echo '<script>alert("Fuente de noticias  agregadas exitosamente.");</script>';
                        echo '<script>window.location.href = "../Views/news_sources.php";</script>';
                        exit();
                   
                } else {
                    // Error al agregar la fuente de noticias
                    echo '<script>alert("Error al agregar la fuente de noticias.");</script>';
                }
            } else {
                // Manejar el caso en el que no se haya iniciado sesión
                echo '<script>alert("Error: El usuario no ha iniciado sesión.");</script>';
            }

            // ...

        }
    }
    


    public function getNewsSources()
    {
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

        return $this->model->getNewsSources($userId);
    }

    public function getNewsSourcesAll()
    {
        return $this->model->getNewsSourcesAll();
    }

    public function getNameCategory($id)
    {
        return $this->model->getCategoriesName($id);
    }

    public function eliminarNoticia($id)
    {
        return $this->model->eliminarNoticia($id);
    }

    public function editNewsSource()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $idNoticia = $_POST['idNoticia']; // Asegúrate de que este campo esté presente en tu formulario
            $nombreFuente = $_POST['fuente'];
            $rssUrl = $_POST['rssUrl'];
            $categoriaId = $_POST['categoriaSelectE']; // Asegúrate de usar el nombre correcto del campo

            if ($this->model->updateNewsSource($idNoticia, $nombreFuente, $rssUrl, $categoriaId)) {
                // La fuente de noticias se ha editado con éxito
                echo '<script>window.location.href = "../Views/news_sources.php";</script>';
                exit();
            } else {
                // Error al editar la fuente de noticias
                echo '<script>alert("Error al editar la fuente de noticias.");</script>';
            }
        }
    }
}

$NewsSourcesController = new NewsSourcesController($db);


$database = new Database();
$db = $database->conectar();
$newsSourcesController = new NewsSourcesController($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        // Manejar la acción específica (eliminar en este caso)
        if ($_POST['action'] == 'agregar') {
            $newsSourcesController->addNewsSource();
        } elseif ($_POST['action'] == 'eliminar_noticia') {
            // Manejar la eliminación de la noticia
            $idNoticia = $_POST['idNoticia'];

            if ($NewsSourcesController->eliminarNoticia($idNoticia)) {
                // Redirigir después de la eliminación
                header("Location: ../Views/news_sources.php");
                exit();
            } else {
                // Error al eliminar la noticia
                echo '<script>alert("Error al eliminar la noticia.");</script>';
            }
        } elseif ($_POST['action'] == 'editar') {
            $NewsSourcesController->editNewsSource();
        }
    }
}
