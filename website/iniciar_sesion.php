<?php

    session_start(); // Inicia la sesión para el usuario

    include 'conexion.php'; // Incluye el archivo de conexión a la base de datos

    // Recoge los datos del formulario de inicio de sesión
    $mail = $_POST['mail']; // Correo electrónico ingresado
    $contrasenia = $_POST['contrasenia']; // Contraseña ingresada

    // Consulta SQL para validar el inicio de sesión
    $validar_login = mysqli_query($conexion, "SELECT * FROM clientes WHERE mail ='$mail' and contrasenia = '$contrasenia'");

    // Verifica si hay resultados en la consulta
    if(mysqli_num_rows($validar_login) > 0){
        $fila = mysqli_fetch_assoc($validar_login); // Obtiene la fila de resultados como un array asociativo
        $_SESSION['usuario'] = $mail; // Almacena el correo en la sesión
        $_SESSION['tipo_usuario'] = $fila['tipo_usuario']; // Almacena el tipo de usuario en la sesión
        $_SESSION['id_cliente'] = $fila['id_cliente']; // Almacena el ID del cliente en la sesión
        var_dump($_SESSION); // Muestra el contenido de la sesión (para depuración)
        
        // Redirige según el tipo de usuario
        if($_SESSION['tipo_usuario'] == 1){
            header("location: admin.php"); // Redirige a la página de administración
        } else {
            header("location: sacar_reserva.php"); // Redirige a la página para sacar reserva
        }

    } else {
        // Si no se encuentra el usuario, muestra un mensaje de error
        echo '
        <script>
        alert("Usuario no encontrado, por favor verifique los datos ingresados") // Mensaje de alerta
        window.location = "reservas.php"; // Redirige a la página de reservas
        </script>';
    }
?>