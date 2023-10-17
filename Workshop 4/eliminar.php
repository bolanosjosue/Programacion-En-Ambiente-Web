<?php
$connection = mysqli_connect('localhost', 'root', '', 'usuarios');

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Eliminar el usuario de la base de datos
    $sql = "DELETE FROM user WHERE cedula = $id";
    $result = mysqli_query($connection, $sql);

    if (!$result) {
        echo "Error al eliminar el usuario: " . mysqli_error($connection);
        exit;
    }

    // Redirigir a la página principal después de eliminar
    header("Location: index.php");
    exit;
}

mysqli_close($connection);
?>
