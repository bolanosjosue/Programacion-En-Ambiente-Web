<?php
session_start();
$varsesion = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : null;
include '../config/icon_imagen.php';


if ($varsesion == null || $varsesion == '') {
    header('Location: ../../../../index.php');
    die;
}

if($_SESSION['role_id']==1){
    echo '<script>alert("Usted no tiene permiso de entrar aquí.");</script>';
    echo '<script>window.location.href = "../Views/categories.php";</script>';
    die;

}

// Agregar el código del controlador y la conexión a la base de datos aquí
require_once(__DIR__ . '/../Controller/your_unique_news_controller.php');
require_once(__DIR__ . '/../Controller/categories_controller.php');
require_once(__DIR__ . '/../config/database.php');

$database = new Database();
$db = $database->conectar();
$NewsController = new YourUniqueNewsController($db);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Unique News Cover</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans">
    <div class="border-b-2 border-gray-700">
        <div class="flex justify-between items-center bg-gray-800 text-white p-4">
            <div class="flex items-center space-x-4">
                <span class="text-xl font-bold">Your Unique News Cover</span>
                <span class="text-gray-400">|</span>

                <a href="?category=all" class="hover:underline">Todas</a>
                <?php
                $categorias = $categoryController->getCategories();
                foreach ($categorias as $category) : ?>
                    <a href="?category=<?php echo $category['id']; ?>" class="hover:underline"><?php echo $category['name']; ?></a>
                <?php endforeach; ?>
            </div>
            <div class="relative">
            <button type="button" class="flex items-center focus:outline-none" id="userMenuBtn">
                    <img src="<?php echo $imagen_url_perfil; ?>" alt="Icono de perfil" class="w-8 h-8 rounded-full">
                </button>
                <!-- Menú desplegable -->
                <div class="hidden absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10 transition-all duration-300 ease-in-out transform" id="userMenu">
                    <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                        <p class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                            <?php
                            if (isset($_SESSION['user_name'])) {
                                echo $_SESSION['user_name'];
                            }
                            ?>
                        </p>
                        <a href="../Views/your_unique_news.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-all duration-300 ease-in-out" role="menuitem">Your Unique News</a>
                        <a href="../Views/news_sources.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-all duration-300 ease-in-out" role="menuitem">News Sources</a>
                        <form id="LoginAutenticar" action="../Controller/user_controller.php" method="post">
                            <input type="hidden" name="action" value="validadS">
                            <button type="submit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-all duration-300 ease-in-out" role="menuitem">Cerrar Sesión</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto my-12 bg-gray-100 p-8 rounded-md shadow-lg">
        <?php
        $noticias = $NewsController->showNews();

        if (empty($noticias)) {
            echo '<div class="text-center my-12">';
            echo '<p class="text-gray-800 text-2xl font-bold mb-4">¡Ups! Parece que aún no has agregado noticias en esta categoría o no te han aceptado la fuente de noticas.</p>';
            echo '<p class="text-gray-600 mb-4">¡Haz clic en el botón para agregar una noticia y comparte información interesante. Si ya agregaste espera a que te acepten las noticias!</p>';
            echo '<a href="../Views/news_sources.php" class="inline-block px-6 py-3 text-lg font-semibold text-white bg-blue-500 rounded-full transition-colors duration-300 hover:bg-blue-700 focus:outline-none focus:ring focus:border-blue-300">Agregar Noticia</a>';
            echo '</div>';
        } else {
            echo '<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">';
            $delay = 100; // Ajusta el valor del retraso para cada tarjeta
            foreach ($noticias as $noticia) : ?>
                <div class="bg-white rounded-lg overflow-hidden shadow-md transition-transform transform hover:scale-105 delay-<?php echo $delay; ?>">
                    <a href="<?php echo $noticia['permanlink']; ?>"><img src="<?php echo $noticia['urlImage']; ?>" alt="Imagen de la noticia" class="w-full h-48 object-cover rounded-t-md animate-fade-in"></a>
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-gray-600 uppercase tracking-wide"><?php echo $noticia['date']; ?></span>
                            <span class="text-blue-500 font-bold"><?php echo $noticia['category_name']; ?></span>
                        </div>
                        <a href="<?php echo $noticia['permanlink']; ?>">
                            <h3 class="text-2xl font-bold leading-tight mb-2 text-gray-800"><?php echo $noticia['title']; ?></h3>
                        </a>
                        <p class="text-gray-700 mb-4"><?php echo $noticia['short_description']; ?></p>
                        <a href="<?php echo $noticia['permanlink']; ?>" class="text-blue-600 hover:underline transition-colors duration-300">Leer más</a>
                    </div>
                </div>
            <?php
                $delay += 100;
            endforeach;
            echo '</div>';
        }
        
        ?>
    </div>
    <script src="../../public/Js/script_your_news.js"></script>

</body>

</html>