<?php
// Incluye el modelo y cualquier archivo necesario
require_once(__DIR__ . '/../Model/user_model.php');
require_once(__DIR__ . '/../Controller/news_sources_controller.php');

require_once(__DIR__ . '/../config/database.php'); // Asegúrate de incluir el archivo que contiene la clase Database

class UserController
{
    private $model;
    private $db;

    public function __construct($db)
    {
        $this->model = new UserModel($db);
        $this->db = $db;
    }

    public function registerUser()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Recupera los datos del formulario
            $cedula = $_POST['cedula'];
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $email = $_POST['email'];
            $contrasena = password_hash($_POST['contrasena'], PASSWORD_BCRYPT); // Hashea la contraseña
            $address = $_POST['address'];
            $address2 = $_POST['address2'];
            $country = $_POST['country'];
            $city = $_POST['city'];
            $zip = $_POST['zip'];
            $phone = $_POST['phone'];

            // Inserta el usuario en la base de datos
            if ($this->model->insertUser($cedula, $nombre, $apellido, $email, $contrasena, $address, $address2, $country, $city, $zip, $phone, 2)) {
                echo '<script>window.location.href = "../../index.php";</script>';
            } else {
                //echo "Error al registrar el usuario";
            }
        }
    }

    public function loginUser()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Recupera los datos del formulario
        $email = $_POST['email'];
        $contrasena = $_POST['contrasena'];

        // Verifica las credenciales del usuario
        $user = $this->model->getUserByEmail($email);

        if ($user && password_verify($contrasena, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['first_name'];
            $_SESSION['role_id'] = $user['role_id']; // Agrega el role_id a la sesión

            // Verifica el rol del usuario
            if ($user['role_id'] == 1) {
                // Rol Administrador, redirige a la página de administrador
                echo '<script>window.location.href = "../Views/categories.php";</script>';
            } elseif ($user['role_id'] == 2) {
                // Rol Usuario, redirige a la página de usuario

                // Verifica si el usuario tiene noticias
                $newsSourcesController = new NewsSourcesController($this->db);
                $newsSources = $newsSourcesController->getNewsSources();

                if (!empty($newsSources)) {
                    // El usuario tiene noticias, redirige a la página de noticias
                    echo '<script>window.location.href = "../Views/your_unique_news.php";</script>';
                } else {
                    // El usuario no tiene noticias, redirige a la página de fuentes de noticias
                    echo '<script>window.location.href = "../Views/news_sources.php";</script>';
                }
            }

            exit();
        } else {
            echo '<script>window.location.href = "../../index.php";</script>';
        }
    }
}



    public function logoutUser()
    {
        session_destroy();
        echo '<script>window.location.href = "../../index.php";</script>';
    }
 
}

$database = new Database();
$db = $database->conectar();
$controller = new UserController($db);
session_start();


// Decide qué función llamar según la acción
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['register'])) {
        $controller->registerUser();
    } elseif (isset($_POST['login'])) {
        $controller->loginUser();
    } elseif ($_POST['action'] == 'validadS') {
        $controller->logoutUser(); // Cambia esto al método adecuado para cerrar sesión
    }
}
