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
                    <img src="" alt="Icono de perfil" class="w-8 h-8 rounded-full">
                </button>
                <!-- Menú desplegable -->
                <div class="hidden absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5" id="userMenu">
                    <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                        <p class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                            <?php
                            $session = session();

                            if (isset($_SESSION['user_name'])) {
                                echo $_SESSION['user_name'];
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

                        <?php foreach ($newsSources as $newsSource) : ?>
                            <tr class="border-b">
                                <td class="py-4 px-6 text-gray-800"><?= $newsSource['name'] ?></td>
                                <td class="py-4 px-6 text-gray-800"><?= $newsSource['category_name'] ?></td>
                                <td class="py-4 px-6 flex items-center space-x-2">
                                    <button class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:shadow-outline-blue" data-id="<?= $newsSource['id'] ?>" data-name="<?= $newsSource['name'] ?>" data-url="<?= $newsSource['url'] ?>" data-categoria="<?= $newsSource['category_id'] ?>" onclick="openEditModal(this)">Editar</button>
                                    <form method="post" action="<?= base_url('deleteNewsSources/' . $newsSource['id']) ?>" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta categoría?')">
                                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 focus:outline-none focus:shadow-outline-red">Eliminar</button>
                                    </form>

                                </td>
                            </tr>
                        <?php endforeach; ?>
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
            <form action="agregar" method="post">
                <input type="hidden" name="idNoticia" id="idNoticia" value="">


                <label for="fuente" class="text-gray-700 block mb-2">Nombre de la Fuente</label>
                <input type="text" id="fuente" name="fuente" class="w-full px-4 py-2 border rounded-md mb-4">

                <label for="rssUrl" class="text-gray-700 block mb-2">URL de RSS</label>
                <input type="text" id="rssUrl" name="rssUrl" class="w-full px-4 py-2 border rounded-md mb-4">

                <label for="categoriaSelect" class="text-gray-700 block mb-2">Categoría</label>
                <select id="categoriaSelect" name="categoriaSelect" class="w-full px-4 py-2 border rounded-md mb-4">
                    <?php
                    foreach ($categorias as $category) {
                        $selected = ''; // inicializa la variable $selected aquí
                        // Verifica si $newsSource está definido antes de intentar acceder a su índice 'category_id'
                        if (isset($newsSource) && $category['id'] == $newsSource['category_id']) {
                            $selected = 'selected';
                        }

                        echo '<option value="' . $category['id'] . '" ' . $selected . '>' . $category['name'] . '</option>';
                    }
                    ?>
                </select>

                <button type="submit" id="guardarModalBtn" class="bg-green-500 text-white px-6 py-2 rounded-md hover:bg-green-600 focus:outline-none focus:shadow-outline-green">Guardar</button>
            </form>
        </div>
    </div>

    <div id="modalEditar" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden">
        <div class="bg-white p-8 rounded-lg shadow-md w-full sm:w-2/3 md:w-1/2 lg:w-1/3">
            <form id="formEditar" action="<?= base_url('editNewsSources/') ?>" method="post">
            <input type="hidden" name="idNoticia" id="idNoticiaE" value="">


                <!-- Agrega el campo idNoticia aquí -->

                <label for="fuenteE" class="text-gray-700 block mb-2">Nombre de la Fuente</label>
                <input type="text" id="fuenteE" name="fuenteE" class="w-full px-4 py-2 border rounded-md mb-4">

                <label for="rssUrlE" class="text-gray-700 block mb-2">URL de RSS</label>
                <input type="text" id="rssUrlE" name="rssUrlE" class="w-full px-4 py-2 border rounded-md mb-4">

                <label for="categoriaSelectE" class="text-gray-700 block mb-2">Categoría</label>
                <select id="categoriaSelectE" name="categoriaSelectE" class="w-full px-4 py-2 border rounded-md mb-4">
                    <?php
                    foreach ($categorias as $category) {
                        $selected = ''; // inicializa la variable $selected aquí

                        // Verifica si $newsSource está definido antes de intentar acceder a su índice 'category_id'
                        if (isset($newsSource) && $category['id'] == $newsSource['category_id']) {
                            $selected = 'selected';
                        }
                
                        echo '<option value="' . $category['id'] . '" ' . $selected . '>' . $category['name'] . '</option>';
                    }
                    ?>
                </select>

                <button id="guardarModalBtn" class="bg-green-500 text-white px-6 py-2 rounded-md hover:bg-green-600 focus:outline-none focus:shadow-outline-green">Guardar</button>
            </form>
        </div>
    </div>



    <script>
        // JavaScript para mostrar/ocultar la ventana emergente al hacer clic en el botón "Agregar Noticia"
        const toggleModalBtn = document.getElementById('toggleModalBtn');
        const modal = document.getElementById('modal');
        const modalEditar = document.getElementById('modalEditar');

        const guardarModalBtn = document.getElementById('guardarModalBtn');
        const userMenuBtn = document.getElementById('userMenuBtn');
        const userMenu = document.getElementById('userMenu');

        const formEditar = document.getElementById('formEditar');


        toggleModalBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
        });

        // JavaScript para ocultar la ventana emergente al hacer clic en el botón "Guardar" dentro de la ventana emergente
        guardarModalBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
        });

        // Agregar eventos para mostrar/ocultar el menú de usuario
        userMenuBtn.addEventListener('click', () => {
            userMenu.classList.toggle('hidden');
        });

        // Ocultar el menú cuando se hace clic fuera de él
        document.addEventListener('click', (event) => {
            if (!userMenu.contains(event.target) && !userMenuBtn.contains(event.target)) {
                userMenu.classList.add('hidden');
            }
        });

        function openEditModal(button) {
            const idNoticia = button.getAttribute('data-id');
            const nombreNoticia = button.getAttribute('data-name');
            const urlNoticia = button.getAttribute('data-url');
            const categoriaNoticia = button.getAttribute('data-categoria');

            // Prellenar el modal de editar con la información actual
            document.getElementById('idNoticiaE').value = idNoticia; // Actualiza el valor del campo idNoticia

            document.getElementById('fuenteE').value = nombreNoticia;
            document.getElementById('rssUrlE').value = urlNoticia;
            const categoriaSelect = document.getElementById('categoriaSelectE');
            for (let i = 0; i < categoriaSelect.options.length; i++) {
                if (categoriaSelect.options[i].text === categoriaNoticia) {
                    categoriaSelect.selectedIndex = i;
                    break;
                }
            }

            document.getElementById('formEditar').action = `<?= base_url('editNewsSources/') ?>${idNoticia}`;


            // Mostrar el modal de editar
            modalEditar.classList.remove('hidden');
        }
    </script>
</body>

</html>