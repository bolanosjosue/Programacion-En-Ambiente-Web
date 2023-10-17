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
    <title>Registro</title>
<style>
body {
  font-family: "Arial", sans-serif;
  margin: 0;
  padding: 0;
  overflow: hidden;
}

.inicio {
  position: relative;
  display: flex;
  justify-content: center;
}

.img-inicio-sesion {
  width: 100%;
  height: 100vh; /* Altura de la pantalla */
  object-fit: cover; /* Ajustar la imagen al tamaño sin deformarla */
  position: absolute;
  z-index: -1; /* Detrás de otros elementos */
}

.form-inicio-sesion {
  width: 30%;
  border: 2px solid #fff;
  border-radius: 40px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  z-index: 8;
  margin: 30px;
  background-color: rgb(10 10 10 / 1%);
  backdrop-filter: blur(
    8px
  ); /* Ajusta el valor de desenfoque según tus preferencias */
  padding-left: 15px;
  padding-right: 15px;
}

.titulo-formulario {
  text-align: center;
  color: white;
}

.contenido-formulario {
  padding: 20px;
}

.campo-correo {
  display: flex;
  align-items: center;
  margin-bottom: 20px;
}

.campo-correo i {
  margin-right: 10px;
}

.contenedor-campo {
  position: relative;
  width: 100%;
  color: black;
  color: #fff;
}

.contenedor-campo-P {
  position: relative;
  width: 100%;
  color: #fff;
  border-bottom: 2px solid;
  padding: 10px;
}

.campo {
  width: calc(100% - 20px);
  padding: 10px;
  background: none;
  color: white;
  border: none;
  border-bottom: 2px solid;
  outline: none;
  color: #fff;
}

i {
  color: #fff;
}

.etiqueta-campo {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  left: 15px;
  pointer-events: none;
  transition: 0.3s;
}

.campo:focus + .etiqueta-campo,
.campo:valid + .etiqueta-campo {
  top: 5px;
  font-size: 12px;
  color: #fff;
}

.boton-formulario {
  width: 100%;
  padding: 10px;
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 16px;
  margin-top: 20px;
}

.boton-formulario:hover {
  background-color: #0056b3;
}

.registro {
  text-align: center;
  margin-top: 10px;
  color: #fff;
  margin-left: 20px;
  margin-right: 20px;
}

a {
  color: #007bff;
  text-decoration: none;
}

.form-control {
  padding: 10px;
  width: 100%;
  outline: none;
}

.btn {
  display: inline-block;
  font-weight: 400;
  text-align: center;
  white-space: nowrap;
  vertical-align: middle;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  border: 1px solid transparent;
  padding: 0.375rem 0.75rem;
  font-size: 1rem;
  line-height: 1.5;
  border-radius: 0.25rem;
  transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out,
    border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
  margin-left: 20px;
  margin-right: 20px;
}

.btn:not(:disabled):not(.disabled) {
  cursor: pointer;
}

button,
[type="button"],
[type="reset"],
[type="submit"] {
  appearance: button;
}

</style>

  </head>
  <body>
    <div class="inicio">
    <img src="./hero3.png" alt="imagen de inicio de sesión" class="img-inicio-sesion" />


      <form id="registro-form" class="form-inicio-sesion" method="post" action="signup.php" style="padding-top: 0;padding-bottom: 0; display: inline-grid">

        <h1 class="titulo-formulario">Registro</h1>
        <div class="contenido-formulario">
          <div class="campo-correo">
            <i class="ri-user-3-line login__icon"></i>
            <div class="contenedor-campo">
              <input
                type="text"
                required
                class="campo"
                id="cedula"
                placeholder=" "
                name = "id"
              />
              <label for="cedula" class="etiqueta-campo">Cédula</label>
            </div>
          </div>
          <div class="campo-correo">
            <i class="ri-user-3-line login__icon"></i>
            <div class="contenedor-campo">
              <input
                type="text"
                required
                class="campo"
                id="nombre"
                placeholder=" "
                name="firstName"
              />
              <label for="nombre" class="etiqueta-campo">Nombre</label>
            </div>
          </div>
          <div class="campo-correo">
            <i class="ri-user-3-line login__icon"></i>
            <div class="contenedor-campo">
              <input
                type="text"
                required
                class="campo"
                id="apellido"
                placeholder=" "
                name="lastName"

              />
              <label for="apellido" class="etiqueta-campo">Apellido</label>
            </div>
          </div>
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
          <div class="campo-correo">
            <i class="ri-map-pin-line login__icon"></i>
            <div class="contenedor-campo-P">
            <select id="province" class="form-control" name="province" style="background-color: transparent;border: 0;color: #fff;font-size:16px;padding: 0;">
            <?php
                $provinces = optenerProvincias();
                foreach ($provinces as $id => $province) {
                  echo "<option value=\" $id\" style=\"color: black;\" >$province[provincia]</option>";
                }
                ?>
              </select>
              <label for="province" class="etiqueta-campo"></label>
            </div>
          </div>
        </div>
        <button type="submit" class="btn btn-primary"> Sign up </button>

        <p class="registro">
          ¿Ya tienes cuenta? <a href="login.php">Iniciar Sesión</a>
        </p>
      </form>
      
      <div id="mensaje-inicio-sesion"></div>
    </div>
  </body>
</html>
