<?php
require_once(__DIR__ . '/../Model/categories_model.php');
require_once(__DIR__ . '/../config/database.php');

class CategoryController
{
    private $model;

    public function __construct($db)
    {
        $this->model = new CategoryModel($db);
    }

    public function addCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombreCategoria = $_POST['categoriaModal'];

            if ($this->model->insertCategory($nombreCategoria)) {   
                $this->redirect('../Views/categories.php');
            } else {
                $this->showErrorAlert('Error al agregar la categoría.');
            }
        }
    }

    public function editCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idCategoria = $_POST['idCategoria'];
            $nombreCategoria = $_POST['categoriaModal'];

            if ($this->model->updateCategory($idCategoria, $nombreCategoria)) {
                $this->redirect('../Views/categories.php');
            } else {
                $this->showErrorAlert('Error al editar la categoría.');
            }
        }
    }

    public function getCategories()
    {
        return $this->model->getCategories();
    }

    public function eliminarCategoria($id)
    {
        return $this->model->deleteCategory($id);
    }

    public function redirect($location)
    {
        echo "<script>window.location.href = '$location';</script>";
        exit();
    }

    public function showErrorAlert($message)
    {
        echo "<script>alert('$message');</script>";
    }
}

$database = new Database();
$db = $database->conectar();
$categoryController = new CategoryController($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'agregar') {
        $categoryController->addCategory();
    } elseif ($_POST['action'] === 'eliminar') {
        $idCategoria = $_POST['idCategoria'];

        if ($categoryController->eliminarCategoria($idCategoria)) {
            $categoryController->redirect('../Views/categories.php');
        } else {
            $categoryController->showErrorAlert('Error al eliminar la categoría.');
        }
    } elseif ($_POST['action'] === 'editar') {
        $categoryController->editCategory();
    }
}
?>
