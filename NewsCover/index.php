<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center overflow-hidden relative">

    <!-- Fondo de pantalla completa -->
    <img src="https://www.elpais.com.co/resizer/sG2lNZSeQ9ZLU5aZLx2jMPz6AyQ=/1280x720/smart/filters:format(jpg):quality(80)/cloudfront-us-east-1.images.arcpublishing.com/semana/52QTXMTILFFPHA7PFVGU2BERRY.jpg" alt="Fondo" class="absolute inset-0 w-full h-full object-cover">

    <div class="bg-white p-8 rounded-md shadow-md max-w-md w-full relative">

        <!-- Logo en la esquina superior izquierda -->
        <div class="mb-4 text-center absolute left-4 top-4">
            <img src="https://cdn-icons-png.flaticon.com/512/21/21601.png" alt="Logo" class="w-16 h-16 mx-auto mb-2 rounded-full">
            <!-- Reemplaza "URL_DE_TU_LOGOTIPO" con la URL de tu logotipo -->
        </div>

        <h2 class="text-2xl font-semibold mb-4 text-center text-gray-800">Iniciar Sesión</h2>

        <form action="./app/Controller/user_controller.php" method="post">
            <input type="hidden" name="login" value="1"> <!-- Agrega este campo oculto -->

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-600 mb-1">Email:</label>
                <input type="email" class="form-input w-full rounded-md border border-gray-300 py-2 px-3 focus:outline-none focus:border-blue-500" id="email" name="email" required>
            </div>

            <!-- Contraseña -->
            <div class="mb-4">
                <label for="contrasena" class="block text-sm font-medium text-gray-600 mb-1">Contraseña:</label>
                <input type="password" class="form-input w-full rounded-md border border-gray-300 py-2 px-3 focus:outline-none focus:border-blue-500" id="contrasena" name="contrasena" required>
            </div>
            <p class="text-sm p-1 text-gray-600 mt-2">¿No tienes cuenta? <a href="./app/Views/register.php" class="text-blue-500">Crear Cuenta</a></p>

            <button type="submit" class="bg-gradient-to-r from-blue-500 to-purple-500 text-white px-4 py-2 rounded-md hover:opacity-90 focus:outline-none">Iniciar Sesión</button>
        </form>
    </div>

</body>

</html>
