<?php
session_start();
require_once(__DIR__ . '/../Controller/news_sources_controller.php');
require_once(__DIR__ . '/../Controller/categories_controller.php');
require_once(__DIR__ . '/../config/database.php');
include '../config/icon_imagen.php';

$varsesion = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : null;

// Obtener la URL de la imagen basada en la inicial del nombre de usuario
$imagen_url_perfil = obtenerUrlPerfil($varsesion);

if ($varsesion == null || $varsesion == '') {
    header('Location: ../../../../index.php');
    die;
}

if ($_SESSION['role_id'] == 1) {
    echo '<script>alert("Usted no tiene permiso de entrar aquí.");</script>';
    echo '<script>window.location.href = "../Views/categories.php";</script>';
    die;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Noticias</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans">

    <div class="border-b-2 border-gray-700">
        <div class="flex justify-between items-center bg-gray-800 text-white p-4">
            <div class="flex items-center space-x-4">
                <span class="text-xl font-bold">Administrar Noticias</span>
            </div>
            <div class="relative">
                <button type="button" class="flex items-center focus:outline-none" id="userMenuBtn">
                    <img src="<?php echo $imagen_url_perfil; ?>" alt="Icono de perfil" class="w-8 h-8 rounded-full">
                </button>
                <!-- Menú desplegable -->
                <div class="hidden absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5" id="userMenu">
                    <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                        <p class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                            <?php
                            if (isset($_SESSION['user_name'])) {
                                echo $_SESSION['user_name'];
                            }
                            ?>
                        </p>
                        <a href="../Views/your_unique_news.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Your Unique News</a>
                        <a href="../Views/news_sources.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">News Sources</a>
                        <form id="LoginAutenticar" action="../Controller/user_controller.php" method="post">
                            <input type="hidden" name="action" value="validadS">
                            <button type="submit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-all duration-300 ease-in-out" role="menuitem">Cerrar Sesión</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto my-8">
        <div class="bg-white p-8 rounded-lg shadow-md">

            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <!-- Table Header -->
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="py-4 px-6 text-left text-gray-700">Nombre de la Fuente</th>
                            <th class="py-4 px-6 text-left text-gray-700">Categoría</th>
                            <th class="py-4 px-6 text-left text-gray-700">Acciones</th>
                        </tr>
                    </thead>
                    <!-- Table Body -->
                    <tbody>
                        <?php

                        $noticias = $newsSourcesController->getNewsSources();

                        foreach ($noticias as $noticia) {
                            echo '<tr class="border-b">';
                            echo '<td class="py-4 px-6 text-gray-800">' . $noticia['name'] . '</td>';
                            echo '<td class="py-4 px-6 text-gray-800">' . $noticia['category_id'] . '</td>';
                            echo '<td class="py-4 px-6 flex items-center space-x-2">';
                            echo '<button class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:shadow-outline-blue" 
                                data-id="' . $noticia['id'] . '" 
                                data-name="' . $noticia['name'] . '"
                                data-url="' . $noticia['url'] . '"
                                data-categoria="' . $noticia['category_id'] . '"
                                onclick="openEditModal(this)">Editar</button>';
                            echo '<form method="post" action="" onsubmit="return confirm(\'¿Estás seguro de que deseas eliminar esta noticia?\')">';
                            echo '<input type="hidden" name="action" value="eliminar_noticia">';
                            echo '<input type="hidden" name="idNoticia" value="' . $noticia['id'] . '">';
                            echo '<button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 focus:outline-none focus:shadow-outline-red">Eliminar</button>';
                            echo '</form>';
                            echo '</td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Botón para mostrar ventana emergente -->
            <div class="mt-8">
                <button id="toggleModalBtn" class="bg-green-500 text-white px-6 py-3 rounded-md hover:bg-green-600 focus:outline-none focus:shadow-outline-green">Agregar Noticia</button>
            </div>
        </div>
    </div>

    <!-- Ventana emergente (modal) para agregar noticia -->
    <div id="modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden">
        <div class="bg-white p-8 rounded-lg shadow-md w-full sm:w-2/3 md:w-1/2 lg:w-1/3">
            <form action="../Controller/news_sources_controller.php" method="post">
                <input type="hidden" name="action" value="agregar">

                <label for="fuente" class="text-gray-700 block mb-2">Nombre de la Fuente</label>
                <input type="text" id="fuente" name="fuente" class="w-full px-4 py-2 border rounded-md mb-4">

                <label for="rssUrl" class="text-gray-700 block mb-2">URL de RSS</label>
                <input type="text" id="rssUrl" name="rssUrl" class="w-full px-4 py-2 border rounded-md mb-4">

                <label for="categoriaSelect" class="text-gray-700 block mb-2">Categoría</label>
                <select id="categoriaSelect" name="categoriaSelect" class="w-full px-4 py-2 border rounded-md mb-4">
                    <?php
                    $categorias = $categoryController->getCategories();

                    foreach ($categorias as $category) {
                        $selected = ($category['id'] == $noticia['category_id']) ? 'selected' : '';
                        echo '<option value="' . $category['id'] . '" ' . $selected . '>' . $category['name'] . '</option>';
                    }
                    ?>
                </select>

                <button id="guardarModalBtn" class="bg-green-500 text-white px-6 py-2 rounded-md hover:bg-green-600 focus:outline-none focus:shadow-outline-green">Guardar</button>
            </form>
        </div>
    </div>

    <!-- Ventana emergente (modal) para editar noticia -->
    <div id="modalEditar" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden">
        <div class="bg-white p-8 rounded-lg shadow-md w-full sm:w-2/3 md:w-1/2 lg:w-1/3">
            <form action="../Controller/news_sources_controller.php" method="post">
                <input type="hidden" name="action" value="editar">

                <!-- Agrega el campo idNoticia aquí -->
                <input type="hidden" name="idNoticia" id="idNoticia" value="">

                <label for="fuenteE" class="text-gray-700 block mb-2">Nombre de la Fuente</label>
                <input type="text" id="fuenteE" name="fuente" class="w-full px-4 py-2 border rounded-md mb-4">

                <label for="rssUrlE" class="text-gray-700 block mb-2">URL de RSS</label>
                <input type="text" id="rssUrlE" name="rssUrl" class="w-full px-4 py-2 border rounded-md mb-4">

                <label for="categoriaSelectE" class="text-gray-700 block mb-2">Categoría</label>
                <select id="categoriaSelectE" name="categoriaSelectE" class="w-full px-4 py-2 border rounded-md mb-4">
                    <?php
                    $categorias = $categoryController->getCategories();

                    foreach ($categorias as $category) {
                        $selected = ($category['id'] == $noticia['category_id']) ? 'selected' : '';
                        echo '<option value="' . $category['id'] . '" ' . $selected . '>' . $category['name'] . '</option>';
                    }
                    ?>
                </select>

                <button id="guardarModalBtn" class="bg-green-500 text-white px-6 py-2 rounded-md hover:bg-green-600 focus:outline-none focus:shadow-outline-green">Guardar</button>
            </form>
        </div>
    </div>
    <script src="../../public/Js/script_news_sources.js"></script>

</body>

</html>
