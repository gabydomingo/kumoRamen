<?php 
// Incluir el archivo de conexión a la base de datos
include 'conexion.php';

// Iniciar la sesión
session_start();

// Verificar si el usuario ha iniciado sesión
if(!isset($_SESSION['usuario'])){
    // Si no ha iniciado sesión, mostrar un mensaje y redirigir
    echo '
    <script>
        alert("Por favor inicia sesión para hacer una reserva");
        window.location = "reservas.php"; // Redirigir a la página de reservas
    </script>';
    session_destroy(); // Destruir la sesión
    die(); // Terminar la ejecución del script
}

try {
    // Conectar a la base de datos usando PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Configurar el modo de error

    // Obtener el correo electrónico del usuario desde la sesión
    $mail = $_SESSION['usuario'];
    // Consultar el ID del cliente basado en el correo electrónico
    $foranea = mysqli_query($conexion, "SELECT id_cliente FROM clientes WHERE mail = '$mail'");
    $row = mysqli_fetch_assoc($foranea); 
    $id_cliente = $row['id_cliente']; // Obtener el ID del cliente
    
    // Inicializar un array para los platos
    $platos = [];
    // Recorrer los datos del formulario
    foreach ($_POST as $key => $value) {
        // Filtrar los datos para obtener solo los platos
        if (strpos($key, '-') === false && $key !== 'personas' && $key !== 'telefono' && $key !== 'fecha' && $key !== 'hora' && $key !== 'instrucciones') {
            $cantidad = intval($value); // Convertir el valor a entero
            if ($cantidad > 0) { // Comprobar si la cantidad es mayor que 0
                $platos[] = $key . ': ' . $cantidad; // Agregar el plato y su cantidad al array
            }
        }
    }
    // Convertir el array de platos a una cadena
    $platos_str = implode(', ', $platos); 

    // Obtener otros datos del formulario
    $cantidad_personas = $_POST['personas'];
    $telefono = $_POST['telefono'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $instrucciones = $_POST['instrucciones'];

    // Preparar la consulta SQL para insertar la reserva
    $stmt = $pdo->prepare("INSERT INTO reservas (platos, cantidad_personas, telefono, fecha, hora, instrucciones, id_cliente) VALUES (?, ?, ?, ?, ?, ?, ?)");
    // Ejecutar la consulta con los datos proporcionados
    $stmt->execute([$platos_str, $cantidad_personas, $telefono, $fecha, $hora, $instrucciones, $id_cliente]);                                                                                                              

    // Mostrar un mensaje de éxito usando SweetAlert
    echo "<script>
    Swal.fire({
        position: 'top',
        icon: 'success', // Corregir 'succes' a 'success'
        title: 'Reserva cargada con éxito', // Corregir la sintaxis de la cadena
        showConfirmButton: false,
        timer: 1500
    }); </script>";
    
    // Redirigir a la página de reservas después de 1 segundo
    header('Refresh: 1; url=reservas.php');
} catch (PDOException $e) {
    // En caso de un error, mostrar el mensaje de error
    echo "Error: " . $e->getMessage();
}

// Cerrar la conexión PDO
$pdo = null;

// Incluir el pie de página
include 'footer.php';
?>