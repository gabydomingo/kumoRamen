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

<h1>
    holis admin
</h1>




<?php include "footer.php" ?>