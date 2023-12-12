<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center overflow-hidden relative overflow-y-auto">
    <img src="https://www.elpais.com.co/resizer/sG2lNZSeQ9ZLU5aZLx2jMPz6AyQ=/1280x720/smart/filters:format(jpg):quality(80)/cloudfront-us-east-1.images.arcpublishing.com/semana/52QTXMTILFFPHA7PFVGU2BERRY.jpg" alt="Fondo" class="absolute inset-0 w-full h-full object-cover">

    <!-- Fondo de pantalla completa -->

    <div class="bg-white p-8 rounded-md shadow-md max-w-xl w-full relative">

        <!-- Logo en la esquina superior izquierda -->
        <div class="mb-4 text-center absolute left-4 top-4">
            <img src="https://cdn-icons-png.flaticon.com/512/21/21601.png" alt="Logo" class="w-16 h-16 mx-auto mb-2 rounded-full">
            <!-- Reemplaza "URL_DE_TU_LOGOTIPO" con la URL de tu logotipo -->
        </div>

        <h2 class="text-2xl font-semibold mb-4 text-center text-gray-800">Registro de Usuario</h2>

        <form method="post" action="<?= base_url('insertar') ?>" enctype="multipart/form-data">
            <input type="hidden" name="register" value="1">

            <div class="mb-4 flex flex-col md:flex-row">
                <div class="w-full md:w-1/2 md:pr-2 mb-2 md:mb-0">
                    <label for="cedula" class="block text-sm font-medium text-gray-600 mb-1">Cedula:</label>
                    <input type="id" class="form-input w-full rounded-md border border-gray-300 py-2 px-3 focus:outline-none focus:border-blue-500" id="cedula" name="cedula" required>
                </div>
                <div class="w-full md:w-1/2 md:pl-2">
                    <label for="nombre" class="block text-sm font-medium text-gray-600 mb-1">Nombre:</label>
                    <input type="text" class="form-input w-full rounded-md border border-gray-300 py-2 px-3 focus:outline-none focus:border-blue-500" id="nombre" name="nombre" required>
                </div>
            </div>

            <!-- Apellido y Email -->
            <div class="mb-4 flex flex-col md:flex-row">
                <div class="w-full md:w-1/2 md:pr-2 mb-2 md:mb-0">
                    <label for="apellido" class="block text-sm font-medium text-gray-600 mb-1">Apellido:</label>
                    <input type="text" class="form-input w-full rounded-md border border-gray-300 py-2 px-3 focus:outline-none focus:border-blue-500" id="apellido" name="apellido" required>
                </div>
                <div class="w-full md:w-1/2 md:pl-2">
                    <label for="email" class="block text-sm font-medium text-gray-600 mb-1">Email:</label>
                    <input type="email" class="form-input w-full rounded-md border border-gray-300 py-2 px-3 focus:outline-none focus:border-blue-500" id="email" name="email" required>
                </div>
            </div>

            <!-- Contraseña y Dirección -->
            <div class="mb-4 flex flex-col md:flex-row">
                <div class="w-full md:w-1/2 md:pr-2 mb-2 md:mb-0">
                    <label for="contrasena" class="block text-sm font-medium text-gray-600 mb-1">Contraseña:</label>
                    <input type="password" class="form-input w-full rounded-md border border-gray-300 py-2 px-3 focus:outline-none focus:border-blue-500" id="contrasena" name="contrasena" required>
                </div>
                <div class="w-full md:w-1/2 md:pl-2">
                    <label for="address" class="block text-sm font-medium text-gray-600 mb-1">Dirección:</label>
                    <input type="text" class="form-input w-full rounded-md border border-gray-300 py-2 px-3 focus:outline-none focus:border-blue-500" id="address" name="address" required>
                </div>
            </div>

            <!-- Dirección 2 y País -->
            <div class="mb-4 flex flex-col md:flex-row">
                <div class="w-full md:w-1/2 md:pr-2 mb-2 md:mb-0">
                    <label for="address2" class="block text-sm font-medium text-gray-600 mb-1">Dirección 2:</label>
                    <input type="text" class="form-input w-full rounded-md border border-gray-300 py-2 px-3 focus:outline-none focus:border-blue-500" id="address2" name="address2">
                </div>
                <div class="w-full md:w-1/2 md:pl-2">
                    <label for="country" class="block text-sm font-medium text-gray-600 mb-1">País:</label>
                    <select class="form-select w-full rounded-md border border-gray-300 py-2 px-3 focus:outline-none focus:border-blue-500" id="country" name="country" required>
                        <!-- Las opciones se agregarán dinámicamente aquí -->
                    </select>
                </div>
            </div>

            <!-- Ciudad y Código Postal -->
            <div class="mb-4 flex flex-col md:flex-row">
                <div class="w-full md:w-1/2 md:pr-2 mb-2 md:mb-0">
                    <label for="city" class="block text-sm font-medium text-gray-600 mb-1">Ciudad:</label>
                    <input type="text" class="form-input w-full rounded-md border border-gray-300 py-2 px-3 focus:outline-none focus:border-blue-500" id="city" name="city" required>
                </div>
                <div class="w-full md:w-1/2 md:pl-2">
                    <label for="zip" class="block text-sm font-medium text-gray-600 mb-1">Código Postal:</label>
                    <input type="text" class="form-input w-full rounded-md border border-gray-300 py-2 px-3 focus:outline-none focus:border-blue-500" id="zip" name="zip" required>
                </div>
            </div>

            <!-- Número de Teléfono y Rol -->
            <div class="mb-4 flex flex-col md:flex-row">
                <div class="w-full md:w-1/2 md:pr-2 mb-2 md:mb-0">
                    <label for="phone" class="block text-sm font-medium text-gray-600 mb-1">Número de Teléfono:</label>
                    <input type="tel" class="form-input w-full rounded-md border border-gray-300 py-2 px-3 focus:outline-none focus:border-blue-500" id="phone" name="phone" required>
                </div>
            </div>


            <button type="submit" class="bg-gradient-to-r from-blue-500 to-purple-500 text-white px-4 py-2 rounded-md hover:opacity-90 focus:outline-none">Registrarse</button>
        </form>
        <p class="text-sm text-gray-600 p-1 mt-2">¿Ya tienes cuenta? <a href="<?= base_url('login') ?>" class="text-blue-500">Iniciar Sesión</a></p>


    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Obtener la lista de países de la API RestCountries
            fetch("https://restcountries.com/v3.1/all")
                .then(response => response.json())
                .then(data => {
                    // Ordenar los países alfabéticamente
                    const sortedCountries = data.sort((a, b) => a.name.common.localeCompare(b.name.common));

                    // Obtener el elemento select del formulario
                    const countrySelect = document.getElementById("country");

                    // Iterar sobre los datos de los países ordenados y agregar opciones al select
                    sortedCountries.forEach(country => {
                        const option = document.createElement("option");
                        option.value = country.name.common; // Puedes ajustar el valor según tus necesidades
                        option.text = country.name.common;
                        countrySelect.appendChild(option);
                    });
                })
                .catch(error => console.error("Error al obtener la lista de países:", error));
        });
    </script>
</body>

</html>