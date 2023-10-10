<?php
    require('functions.php');
    $user['email'] = $_POST['email'];
    $user['password'] = $_POST['password'];
    
    if (VerificarUsuario($user) === 'usuario') {
        header("Location: /user.php");
    }
    if (VerificarUsuario($user) === 'administrador') {
        header("Location: /administrador.php");
    }

      

?>