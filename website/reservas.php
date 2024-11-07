<?php include "header.php" ?>

<?php
    session_start();
    if (isset($_SESSION['usuario'])){
        if($_SESSION['tipo_usuario'] == 1){
            header("Location: admin.php");
        } else {
            header("Location: sacar_reserva.php");
        }
    }
?>

<main class="main-container">
<div class="contenedor__todo">
    <div class="caja__trasera">
        <div class="caja__trasera-login">
            <h3>¿Ya tienes una cuenta?</h3>
            <p>Inicia sesión para entrar en la página</p>
            <button id="btn__iniciar-sesion">Iniciar Sesión</button>
        </div>
        <div class="caja__trasera-register">
            <h3>¿Aún no tienes una cuenta?</h3>
            <p>Regístrate para que puedas iniciar sesión</p>
            <button id="btn__registrarse">Regístrarse</button>
        </div>
    </div>

    <!--Formulario de Login y registro-->
    <div class="contenedor__login-register">
        <!--Login-->
        <form action="iniciar_sesion.php" method="POST" class="formulario__login" id="login">
            <h2>Iniciar Sesión</h2>
            <input type="email" placeholder="Correo Electronico" name="mail" id="mail" required>
            <input type="password" placeholder="Contraseña" name="contrasenia"  required>
            <button>Entrar</button>
        </form>

        <!--Register-->
        <form action="nuevo_user.php" method="POST" class="formulario__register">
            <h2>Regístrarse</h2>
            <input type="text" placeholder="Nombre" name="nombre" required>
            <input type="text" placeholder="apellido"  name="apellido" required>
            <input type="number" placeholder="celular"  name="celular" required>
            <input type="email" placeholder="Correo Electronico" name="mail" required>
            <input type="text" placeholder="Usuario"  name="usuario" required>
            <input type="password" placeholder="Contraseña"  name="contrasenia" required>
            <button>Regístrarse</button>
        </form>
    </div>
</div>

</main>


<?php include "footer.php" ?>