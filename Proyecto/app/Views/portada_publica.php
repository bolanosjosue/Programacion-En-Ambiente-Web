<!-- portada_publica.php -->

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

            <div class="ml-auto relative">
                <!-- Botón de Login -->
                <a href="<?=base_url('login')?>" class="inline-block px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-full hover:bg-blue-700 focus:outline-none focus:ring focus:border-blue-300">
                    Iniciar Sesión
                </a>
            </div>
        </div>
    </div>

    <!-- Etiquetas -->
    

    <div class="container mx-auto my-12 bg-gray-100 p-8 rounded-md shadow-lg">
        <?php

        if (empty($YourNews)) {
            echo '<div class="text-center my-12">';
            echo '<p class="text-gray-800 text-2xl font-bold mb-4">¡Ups! Parece que aún no han agregado noticias en esta categoría.</p>';

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
        const etiquetasContainer = document.getElementById('etiquetasContainer');
        const toggleEtiquetasBtn = document.getElementById('toggleEtiquetasBtn');

        toggleEtiquetasBtn.addEventListener('click', () => {
            etiquetasContainer.classList.toggle('hidden');
        });
    </script>

</body>

</html>