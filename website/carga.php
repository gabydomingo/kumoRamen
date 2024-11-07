<?php 
include 'conexion.php';

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
    
try{

    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $mail = $_SESSION['usuario'];
    $foranea = mysqli_query($conexion, "SELECT id_cliente FROM clientes WHERE mail = '$mail'");
    $row = mysqli_fetch_assoc($foranea); 
    $id_cliente = $row['id_cliente'];
    
    $platos = [];
    foreach ($_POST as $key => $value) {
        if (strpos($key, '-') === false && $key !== 'personas' && $key !== 'telefono' && $key !== 'fecha' && $key !== 'hora' && $key !== 'instrucciones') {
            $cantidad = intval($value); 
            if ($cantidad > 0) {
                $platos[] = $key . ': ' . $cantidad; 
            }
        }
    }
    $platos_str = implode(', ', $platos); 

    $cantidad_personas = $_POST['personas'];
    $telefono = $_POST['telefono'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $instrucciones = $_POST['instrucciones'];

    
    $stmt = $pdo->prepare("INSERT INTO reservas (platos, cantidad_personas, telefono, fecha, hora, instrucciones, id_cliente) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$platos_str, $cantidad_personas, $telefono, $fecha, $hora, $instrucciones, $id_cliente]);                                                                                                              

    echo "<script>
    Swal.fire({
    position: top,
    icon: succes,
    title: Reserva cargada con exito,
    showConfirmButton: false,
    timer: 1500
    }); </script>";
    header('Refresh: 1; url=reservas.php');
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}


$pdo = null;



include 'footer.php';
?>