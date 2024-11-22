<?php

    include 'conexion.php'; // Incluye el archivo de conexión a la base de datos

    // Recoge los datos del formulario a través del método POST
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $celular = $_POST['celular'];
    $mail = $_POST['mail'];
    $usuario = $_POST['usuario'];
    $contrasenia = $_POST['contrasenia'];
    // $contrasenia = hash('sha512', $contrasenia); // Descomentar para encriptar la contraseña

    // Consulta SQL para agregar un nuevo cliente a la base de datos
    $agregar = "INSERT INTO clientes(nombre, apellido, celular, mail, usuario, contrasenia) VALUES('$nombre','$apellido','$celular','$mail','$usuario','$contrasenia')";
   
    // Verifica si el correo electrónico ya está registrado
    $verificar_mail = mysqli_query($conexion, "SELECT * FROM clientes WHERE mail='$mail'");

    // Si hay resultados, significa que el correo ya está registrado
    if(mysqli_num_rows($verificar_mail) > 0){
        echo '
        <script>
        alert("Este correo ya está registrado, ingrese uno distinto.") // Muestra un mensaje de alerta
        window.location = "reservas.php"; // Redirige a la página de reservas
        </script>';
        exit(); // Termina la ejecución del script
    }

    // Verifica si el nombre de usuario ya está registrado
    $verificar_usuario = mysqli_query($conexion, "SELECT * FROM clientes WHERE usuario='$usuario'");

    // Si hay resultados, significa que el usuario ya está registrado
    if(mysqli_num_rows($verificar_usuario) > 0){
        echo '
        <script>
        alert("Este usuario ya está registrado, ingrese uno distinto.") // Muestra un mensaje de alerta
        window.location = "reservas.php"; // Redirige a la página de reservas
        </script>';
        exit(); // Termina la ejecución del script
    }

    // Ejecuta la consulta para agregar el nuevo cliente
    $ejecutar = mysqli_query($conexion, $agregar);

    // Verifica si la ejecución fue exitosa
    if($ejecutar){
        echo '<script>
        alert("Usuario cargado correctamente") // Muestra un mensaje de éxito
        window.location = "reservas.php"; // Redirige a la página de reservas
        </script>';
    } else { 
        // Si hubo un error en la ejecución
        echo '<script>
        alert("Parece que algo ha salido mal, vuelve a intentarlo") // Muestra un mensaje de error
        window.location = "reservas.php"; // Redirige a la página de reservas
        </script>';
    }

    mysqli_close($conexion); // Cierra la conexión a la base de datos
?>