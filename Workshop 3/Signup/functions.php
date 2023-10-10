<?php


function getConnection() {

  $user = "root";
  $pass = "";
  $host = "localhost";
  $db = "usuarios";
  $connection = mysqli_connect($host, $user, $pass, $db);

    if(!$connection) 
    {
        echo "No se ha podido conectar con el servidor" . mysql_error();
        
    }
  else
    {
        return $connection;
    }


}

function saveUser($user){
  $cedula = $user['id'];
  $firstName = $user['firstName'];
  $lastName = $user['lastName'];
  $email = $user['email']; 
  $provincia = $user['province'];
  $contra = $user['password'];

  $sql = "INSERT INTO user (cedula,nombre, apellido, email, provincia, contraseña,tipo_user) VALUES ('$cedula','$firstName', '$lastName', '$email', '$provincia', '$contra','user')";

  $conn = getConnection() ;
  mysqli_query($conn, $sql);
  return true;
}

function optenerProvincias(){
  $conn = getConnection() ;
  $query = "SELECT provincia FROM provincias";
  $result = mysqli_query($conn, $query);

  if (!$result) {
    echo("Error al obtener provincias: " . mysqli_error($conn));
  }

  $provincias = mysqli_fetch_all($result, MYSQLI_ASSOC);

  mysqli_close($conn);

  return $provincias;
}

function VerificarUsuario($ChUser){
  
  $email = $ChUser['email']; 
  $contra = $ChUser['password'];

  $sql = "SELECT * FROM user WHERE email = '$email' AND contraseña = '$contra'";

  $conn = getConnection() ;
  $resultado = mysqli_query($conn, $sql);

  if ($resultado && mysqli_num_rows($resultado) > 0) {
    // El usuario existe, ahora verificamos el tipo de usuario
    $usuario = mysqli_fetch_assoc($resultado);
    $tipoUsuario = $usuario['tipo_user'];

    // Comprobamos el tipo de usuario
    if ($tipoUsuario == 'user') {
      $existeUsuario = 'usuario';
    } elseif ($tipoUsuario == 'admin') {
      $existeUsuario = 'administrador';
    } else {
      // Tipo de usuario desconocido
      $existeUsuario = false;
    }
  } else {
    // El usuario no existe
    $existeUsuario = false;
  }

  mysqli_free_result($resultado);
  mysqli_close($conn);

  return $existeUsuario;
}