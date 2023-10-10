<?php
$connection = mysqli_connect('localhost', 'root', '', 'usuarios');

// Verifica la conexión
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM user"; // Corrige la consulta SQL

$result = mysqli_query($connection, $sql); // Usa mysqli_query en lugar de mysql_query
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body> 
    <h2>Lista de Usuarios</h2>
    <table>
        <tr>
            <th>Cedula</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Email</th>
            <th>Provincia</th>
            <th>Contraseña</th>
            <th>Acciones</th> 
        </tr>

        <?php
        while ($mostrar = mysqli_fetch_assoc($result)) {
        ?>
            <tr>
                <td><?php echo $mostrar['cedula'] ?></td>
                <td><?php echo $mostrar['nombre'] ?></td>
                <td><?php echo $mostrar['apellido'] ?></td>
                <td><?php echo $mostrar['email'] ?></td>
                <td><?php echo $mostrar['provincia'] ?></td>
                <td><?php echo $mostrar['contraseña'] ?></td>
                <td>
                    <a href="editar.php?id=<?php echo $mostrar['id']; ?>">Editar</a> |
                    <a href="eliminar.php?id=<?php echo $mostrar['id']; ?>" onclick="return confirm('¿Estás seguro de que quieres eliminar este usuario?')">Eliminar</a>
                </td>
            </tr>
        <?php
        }
        mysqli_close($connection); // Cierra la conexión después de usarla
        ?>
    </table>
</body>
</html>
