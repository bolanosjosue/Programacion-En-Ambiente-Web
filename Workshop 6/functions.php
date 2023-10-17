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
?>