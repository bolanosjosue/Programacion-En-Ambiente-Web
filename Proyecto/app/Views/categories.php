<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Categorías</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans">

    <div class="border-b-2 border-gray-700">
        <div class="flex justify-between items-center bg-gray-800 text-white p-4">
            <div class="flex items-center space-x-4">
                <span class="text-xl font-bold">Administrar Categorías</span>
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
                            $session->start();
                            if (isset($_SESSION['user_name'])) {
                                echo $_SESSION['user_name'];
                            }
                            ?>
                        </p>
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
                            <th class="py-4 px-6 text-left text-gray-700">Nombre de la Categoría</th>
                            <th class="py-4 px-6 text-left text-gray-700">Acciones</th>
                        </tr>
                    </thead>
                    <!-- Table Body -->
                    <tbody>
                        <?php foreach ($categories as $categoria) : ?>
                            <tr class="border-b hover:bg-gray-100">
                                <td class="py-4 px-6 text-gray-800"><?= $categoria['name'] ?></td>
                                <td class="py-4 px-6 flex flex-col lg:flex-row items-center space-y-2 lg:space-y-0 lg:space-x-2">
                                    <button class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:shadow-outline-blue" data-id="<?= $categoria['id'] ?>" data-name="<?= $categoria['name'] ?>" onclick="openEditModal(this)">Editar
                                    </button> <!-- Formulario para eliminar la categoría -->
                                    <form method="post" action="<?= base_url('delete/' . $categoria['id']) ?>" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta categoría?')">
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
                <button id="toggleModalBtn" class="bg-green-500 text-white px-6 py-3 rounded-md hover:bg-green-600 focus:outline-none focus:shadow-outline-green">Agregar Categoría</button>
            </div>
        </div>
    </div>

    <div id="modalAgregar" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden">
        <div class="bg-white p-8 rounded-lg shadow-md w-full lg:w-1/2">
            <form id="categoryFormAgregar" action="<?= base_url('agregarCategorie') ?>" method="post">
                <label for="categoriaModalAgregar" class="text-gray-700 block mb-2">Nombre de la Categoría</label>
                <input type="hidden" name="action" value="agregar">

                <div class="flex items-center">
                    <input type="text" id="categoriaModalAgregar" name="categoriaModal" class="w-full px-4 py-2 border rounded-md mr-2">
                    <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded-md hover:bg-green-600 focus:outline-none focus:shadow-outline-green">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalEditar" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden">
        <div class="bg-white p-8 rounded-lg shadow-md w-full lg:w-1/2">
            <form id="categoryFormEditar" action="<?= base_url('editCategory/') ?>" method="post">
                <input type="hidden" name="categoriaIdEditar" id="categoriaIdEditar" value="">

                <label for="categoriaModalEditar" class="text-gray-700 block mb-2">Nombre de la Categoría</label>
                <div class="flex items-center">
                    <input type="text" id="categoriaModalEditar" name="categoriaModalEditar" class="w-full px-4 py-2 border rounded-md mr-2">
                    <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:shadow-outline-blue">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>


    <script>
        const toggleModalBtn = document.getElementById('toggleModalBtn');
        const modalAgregar = document.getElementById('modalAgregar');
        const modalEditar = document.getElementById('modalEditar');
        const userMenuBtn = document.getElementById('userMenuBtn');
        const userMenu = document.getElementById('userMenu');
        const categoryFormAgregar = document.getElementById('categoryFormAgregar');
        const categoryFormEditar = document.getElementById('categoryFormEditar');

        toggleModalBtn.addEventListener('click', () => {
            // Limpiar el campo de nombre en el modal de agregar
            document.getElementById('categoriaModalAgregar').value = '';
            modalAgregar.classList.remove('hidden');
        });

        function openEditModal(button) {
            const idCategoria = button.getAttribute('data-id');
            const nombreCategoria = button.getAttribute('data-name');

            // Prellenar el modal de editar con la información actual
            document.getElementById('categoriaModalEditar').value = nombreCategoria;

            // Establecer el valor del campo de ID para la edición
            document.getElementById('categoriaIdEditar').value = idCategoria;

            // Actualizar la acción del formulario con el ID de la categoría
            document.getElementById('categoryFormEditar').action = `<?= base_url('editCategory/') ?>${idCategoria}`;

            // Mostrar el modal de editar
            modalEditar.classList.remove('hidden');
        }


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
    </script>
</body>

</html>