<?php session_start(); // Inicia la sesión
include "header.php"; //Incluye el archivo de encabezado
include "conexion.php";?>

<?php
    // Verifica si el usuario ya ha iniciado sesión
    if (isset($_SESSION['usuario'])){
        if($_SESSION['tipo_usuario'] == 1){
            header("Location: admin.php");
        } else {
            header("Location: sacar_reserva.php");
        }
    }
?>

<main class="main-container"> <!-- Contenedor principal -->
<div class="contenedor__todo"> <!-- Contenedor para todo el contenido -->
    <div class="caja__trasera"> <!-- Caja trasera que contiene las opciones de inicio de sesión y registro -->
        <div class="caja__trasera-login"> <!-- Caja para el inicio de sesión -->
            <h3>¿Ya tienes una cuenta?</h3> <!-- Pregunta para el usuario -->
            <p>Inicia sesión para entrar en la página</p> <!-- Instrucción para el usuario -->
            <button id="btn__iniciar-sesion">Iniciar Sesión</button> <!-- Botón para mostrar el formulario de inicio de sesión -->
        </div>
        <div class="caja__trasera-register"> <!-- Caja para el registro -->
            <h3>¿Aún no tienes una cuenta?</h3> <!-- Pregunta para el usuario -->
            <p>Regístrate para que puedas iniciar sesión</p> <!-- Instrucción para el usuario -->
            <button id="btn__registrarse">Regístrarse</button> <!-- Botón para mostrar el formulario de registro -->
        </div>
    </div>

    <!--Formulario de Login y registro-->
    <div class="contenedor__login-register"> <!-- Contenedor para los formularios de login y registro -->
        <!--Login-->
        <form action="iniciar_sesion.php" method="POST" class="formulario__login" id="login"> <!-- Formulario de inicio de sesión -->
            <h2>Iniciar Sesión</h2> <!-- Título del formulario -->
            <input type="email" placeholder="Correo Electronico" name="mail" id="mail" required> <!-- Campo para el correo electrónico -->
            <input type="password" placeholder="Contraseña" name="contrasenia" required> <!-- Campo para la contraseña -->
            <button>Entrar</button> <!-- Botón para enviar el formulario de inicio de sesión -->
        </form>

        <!--Register-->
        <form action="nuevo_user.php" method="POST" class="formulario__register"> <!-- Formulario de registro -->
            <h2>Regístrarse</h2> <!-- Título del formulario -->
            <input type="text" placeholder="Nombre" name="nombre" required> <!-- Campo para el nombre -->
            <input type="text" placeholder="Apellido" name="apellido" required> <!-- Campo para el apellido -->
            <input type="number" placeholder="Celular" name="celular" required> <!-- Campo para el número de celular -->
            <input type="email" placeholder="Correo Electronico" name="mail" required> <!-- Campo para el correo electrónico -->
            <input type="text" placeholder="Usuario" name="usuario" required> <!-- Campo para el nombre de usuario -->
            <input type="password" placeholder="Contraseña" name="contrasenia" required> <!-- Campo para la contraseña -->
            <button>Regístrarse</button> <!-- Botón para enviar el formulario de registro -->
        </form>
    </div>
</div>

</main>

<?php include "footer.php" ?> <!-- Incluye el archivo de pie de página -->