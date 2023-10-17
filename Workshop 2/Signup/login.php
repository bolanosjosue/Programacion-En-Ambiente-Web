<?php
  include('signup.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Registro</title>
    <link rel="stylesheet" href="./style_login.css">

  </head>
  <body>
    <div class="inicio">
    <img src="./hero3.png" alt="imagen de inicio de sesión" class="img-inicio-sesion" />


      <form id="registro-form" class="form-inicio-sesion" method="post" action="log_in.php" style="padding-top: 0;padding-bottom: 0; display: inline-grid">

        <h1 class="titulo-formulario">Iniciar Seción</h1>
        <div class="contenido-formulario">
          
          <div class="campo-correo">
            <i class="ri-mail-line login__icon"></i>
            <div class="contenedor-campo">
              <input
                type="email"
                required
                class="campo"
                id="correo"
                placeholder=" "
                name="email"

              />
              <label for="correo" class="etiqueta-campo">Email</label>
            </div>
          </div>

          <div class="campo-correo">
            <i class="ri-lock-2-line login__icon"></i>
            <div class="contenedor-campo">
              <input
                type="password"
                required
                class="campo"
                id="contrasena"
                placeholder=" "
                name="password"

              />
              <label for="contrasena" class="etiqueta-campo">Contraseña</label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary"> Log in </button>

        <p class="registro">
          ¿No tienes cuenta? <a href="index.php">Registrarse</a>
        </p>
      </form>
      
      <div id="mensaje-inicio-sesion"></div>
    </div>
  </body>
</html>
