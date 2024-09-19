<?php include "header.php" ?>
<?php
    session_start();

    if(!isset($_SESSION['usuario'])){
        echo '
        <script>
            alert("porfavor inicia sesion para hacer una reserva")
            window.location = "reservas.php";
        </script>';
        session_destroy();
        die();

    }
    
?>


<section class="cuerpo">
    <img src="img\SITIO-EN-CONSTRUCCION.jpg" alt="wbsite en construccion">

    <button><a href="cerrar_sesion.php">cerrar sesion</a></button>
</section>
<?php include "footer.php" ?>