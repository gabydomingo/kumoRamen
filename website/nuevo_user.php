<?php

    include 'conexion.php';

    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $celular = $_POST['celular'];
    $mail = $_POST['mail'];
    $usuario = $_POST['usuario'];
    $contrasenia = $_POST['contrasenia'];
    // $contrasenia = hash('sha512', $contrasenia)

    $agregar = "INSERT INTO clientes(nombre, apellido, celular, mail, usuario, contrasenia) VALUES('$nombre','$apellido','$celular','$mail','$usuario','$contrasenia')";
   

    $verificar_mail = mysqli_query($conexion, "SELECT * FROM clientes WHERE mail='$mail'");


    if(mysqli_num_rows($verificar_mail) > 0){
        echo '
        <script>
        alert("Este correo ya esta registrado, ingrese uno distinto.")
        window.location = "reservas.php";
        </script>';
        exit();
    }


    $verificar_usuario = mysqli_query($conexion, "SELECT * FROM clientes WHERE usuario='$usuario'");

    if(mysqli_num_rows($verificar_usuario) > 0){
        echo '
        <script>
        alert("Este usuario ya esta registrado, ingrese uno distinto.")
        window.location = "reservas.php";
        </script>';
        exit();
    }

    $ejecutar = mysqli_query($conexion,$agregar);


    if($ejecutar){
        echo '<script>
        alert("usuario cargado correctamente")
        window.location = "reservas.php";
        </script>';
    }else{ 
        echo '<script>
        alert("parece que algo ah salido mal, vuelvelo a intentar")
        window.location = "reservas.php";
        </script>';
    }

    mysqli_close($conexion);
?>