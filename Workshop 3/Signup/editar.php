<?php
$connection = mysqli_connect('localhost', 'root', '', 'usuarios');

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener información del usuario
    $sql = "SELECT * FROM user WHERE id = $id";
    $result = mysqli_query($connection, $sql);

    if ($result) {
        $usuario = mysqli_fetch_assoc($result);
    } else {
        echo "Error al obtener la información del usuario: " . mysqli_error($connection);
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Aquí realizamos la actualización en la base de datos con los nuevos datos del formulario

    $id = $_POST['id']; // Asegúrate de tener un campo oculto en tu formulario que contenga el ID del usuario
    $nombre = mysqli_real_escape_string($connection, $_POST['nombre']);
    // Aquí realiza lo mismo para otros campos del formulario

    // Construir la consulta UPDATE
    $update_sql = "UPDATE user SET nombre='$nombre' WHERE id=$id"; // Modifica según tus campos y necesidades

    // Ejecutar la consulta
    $update_result = mysqli_query($connection, $update_sql);

    if (!$update_result) {
        echo "Error al actualizar el usuario: " . mysqli_error($connection);
        exit;
    }

    // Redirigir a la página principal después de actualizar
    header("Location: index.php");
    exit;
}

mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
</head>
<body>
    <h2>Editar Usuario</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>"> <!-- Campo oculto con el ID del usuario -->
        
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $usuario['nombre']; ?>" required>
        
        <!-- Otros campos del formulario -->

        <input type="submit" value="Guardar cambios">
    </form>
</body>
</html>
