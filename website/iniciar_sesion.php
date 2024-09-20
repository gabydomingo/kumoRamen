<?php

    session_start(); 

    include 'conexion.php';

    $mail = $_POST['mail'];
    $contrasenia = $_POST['contrasenia'];

    $validar_login = mysqli_query($conexion, "SELECT * FROM clientes WHERE mail ='$mail' and contrasenia = '$contrasenia'");

    if(mysqli_num_rows($validar_login) > 0){
        $_SESSION['usuario'] = $mail;
        header("location: sacar_reserva.php");
    }else{
        echo '
        <script>
        alert("Usuario no encontrado, por favor verifique los datos ingresados")
        window.location = "reservas.php";
        </script>';
    }
?>