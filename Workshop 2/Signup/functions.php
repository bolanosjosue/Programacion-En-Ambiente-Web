<?php

/**
 *  Gets the provinces from the database
 */
function getProvinces() {
  //select * from provinces
  return [1 => 'Alajuela', 2 => 'San Jose', 3 => 'Cartago', 80 => 'Heredia', 90 => 'Limon', 100 => 'Puntarenas', 200 => 'Guanacaste'];
}

function getConnection() {

  $user = "root";
  $pass = "";
  $host = "localhost";
  $db = "practica";
  $connection = mysqli_connect($host, $user, $pass, $db);

    if(!$connection) 
    {
        echo "No se ha podido conectar con el servidor" . mysql_error();
        
    }
  else
    {
        echo "Hemos conectado al servidor <br>" ;
        return $connection;
    }


}

/**
 * Saves an specific user into the database
 */
function saveUser($user){

  $firstName = $user['firstName'];
$lastName = $user['lastName'];
$email = $user['email']; // Eliminé los corchetes y la clave 'email'
$provincia = $user['province_id'];
$contra = $user['password']; // Eliminé los corchetes y la clave 'password'

$sql = "INSERT INTO users (nombre, apellido, email, provincia, contraseña) VALUES ('$firstName', '$lastName', '$email', '$provincia', '$contra')";

  $conn = getConnection() ;
  mysqli_query($conn, $sql);
  return true;
}