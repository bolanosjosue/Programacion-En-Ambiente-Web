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
                <?php foreach ($categorias as $category) : ?>
                    <a href="?category=<?php echo $category['id']; ?>" class="hover:underline"><?php echo $category['name']; ?></a>
                <?php endforeach; ?>
            </div>
            <button id="toggleEtiquetasBtn" class="ml-4 px-4 py-2 text-white bg-blue-500 rounded-full hover:bg-blue-700 focus:outline-none">
                Etiquetas
            </button>
            <form method="get" action="<?= base_url('search') ?>" class="ml-4 flex items-center">
                <label for="search" class="text-white mr-2">Buscar Noticias:</label>
                <input type="text" name="q" id="search" placeholder="Palabra clave..." class="rounded-md p-2 border border-gray-300 focus:outline-none focus:border-blue-500 text-black">
                <button type="submit" class="ml-2 px-4 py-2 text-white bg-blue-500 rounded-full hover:bg-blue-700 focus:outline-none">
                    Buscar
                </button>
            </form>
            <div class="ml-auto relative">
                <!-- Icono de perfil -->
                <button type="button" class="flex items-center focus:outline-none" id="userMenuBtn">
                    <img src="" alt="Icono de perfil" class="w-8 h-8 rounded-full">
                </button>
                <!-- Menú desplegable -->

                <div class="hidden absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10 transition-all duration-300 ease-in-out transform" id="userMenu">

                    <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                        <p class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                            <?php
                            $session = session();
                            $session->start();
                            if (isset($_SESSION['user_name'])) {
                                echo $_SESSION['user_name'];
                            }
                            ?>
                        </p>

                        <p class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                            <?php
                            $bool = isset($user['publica']) ? $user['publica'] : 0;
                            if ($bool == 1) {
                                // Muestra el botón para copiar al portapapeles usando JavaScript
                                echo '<button class="text-blue-500 hover:underline focus:outline-none" onclick="copyToClipboard(\'http://localhost/code/public/portada_publica/' . $_SESSION['user_name'] . '/' . $_SESSION['user_last_name'] . '/' . $_SESSION['user_id'] . '\')">Copiar enlace perfil</button>';
                            } else {
                                echo '<p class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-all duration-300 ease-in-out" role="menuitem">Perfil Privado</p>';
                            }
                            ?>
                        </p>
                        <a href="<?=base_url('your_unique_news')?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-all duration-300 ease-in-out" role="menuitem">Your Unique News</a>
                        <a href="<?=base_url('news_sources')?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-all duration-300 ease-in-out" role="menuitem">News Sources</a>
                        <form id="LoginAutenticar" action="<?= base_url('logoutUser') ?>" method="post">
                            <input type="hidden" name="action" value="validadS">
                            <button type="submit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-all duration-300 ease-in-out" role="menuitem">Cerrar Sesión</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Etiquetas -->
    <div id="etiquetasContainer" class="hidden mt-4">
        <form method="get" action="<?= base_url('your_unique_news') ?>">
            <label class="block text-sm font-medium text-gray-700">Selecciona etiquetas:</label>
            <div class="grid grid-cols-3 gap-4">
                <?php foreach ($etiquetas as $etiqueta) : ?>
                    <div class="flex items-center etiqueta-item p-2 bg-blue-500 text-white rounded-full">
                        <input type="checkbox" name="etiquetas[]" value="<?php echo $etiqueta['name_etiqueta']; ?>" class="form-checkbox mr-2">
                        <span><?php echo $etiqueta['name_etiqueta']; ?></span>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Botón "Aplicar Cambios" -->
            <button type="submit" name="aplicarCambiosBtn" class="mt-4 px-6 py-3 text-white bg-green-500 rounded-full hover:bg-green-700 focus:outline-none">Aplicar Cambios</button>
        </form>
    </div>
    <div class="fixed bottom-4 left-4 z-50">
        <ul class="bg-gray-100 rounded-lg">
            <li>
                <form method="post" action="<?= site_url('cambiaEstado/' . $user['id'] . '/' . $user['publica']); ?>">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded border-none">
                        <?= $user['publica'] == 0 ? 'Publicar Perfil' : 'Ocultar Perfil'; ?>
                    </button>
                </form>
            </li>
        </ul>
    </div>

    <div class="container mx-auto my-12 bg-gray-100 p-8 rounded-md shadow-lg">
        <?php

        if (empty($YourNews)) {
            echo '<div class="text-center my-12">';
            echo '<p class="text-gray-800 text-2xl font-bold mb-4">¡Ups! Parece que aún no has agregado noticias en esta categoría o no te han aceptado la fuente de noticias.</p>';
            echo '<p class="text-gray-600 mb-4">¡Haz clic en el botón para agregar una noticia y comparte información interesante. Si ya agregaste espera a que te acepten las noticias!</p>';
            echo '<a href="../Views/news_sources.php" class="inline-block px-6 py-3 text-lg font-semibold text-white bg-blue-500 rounded-full transition-colors duration-300 hover:bg-blue-700 focus:outline-none focus:ring focus:border-blue-300">Agregar Noticia</a>';
            echo '</div>';
        } else {
            echo '<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">';
            $delay = 100; // Ajusta el valor del retraso para cada tarjeta
            foreach ($YourNews as $noticia) : ?>
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

    <script>
        const userMenuBtn = document.getElementById('userMenuBtn');
        const userMenu = document.getElementById('userMenu');
        const etiquetasContainer = document.getElementById('etiquetasContainer');
        const toggleEtiquetasBtn = document.getElementById('toggleEtiquetasBtn');

        userMenuBtn.addEventListener('click', () => {
            userMenu.classList.toggle('hidden');
        });

        // Ocultar el menú cuando se hace clic fuera de él
        document.addEventListener('click', (event) => {
            if (!userMenu.contains(event.target) && !userMenuBtn.contains(event.target)) {
                userMenu.classList.add('hidden');
            }
        });

        toggleEtiquetasBtn.addEventListener('click', () => {
            etiquetasContainer.classList.toggle('hidden');
        });

        function copyToClipboard(text) {
            const input = document.createElement('input');
            input.value = text;
            document.body.appendChild(input);
            input.select();
            document.execCommand('copy');
            document.body.removeChild(input);

            alert('Enlace copiado al portapapeles.');
        }
    </script>

</body>

</html>