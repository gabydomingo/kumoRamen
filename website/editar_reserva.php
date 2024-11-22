<?php
// Incluir el archivo de conexión a la base de datos
include 'conexion.php';

// Establecer el tipo de contenido de la respuesta como JSON
header('Content-Type: application/json');

// Habilitar el reporte de errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Verificar si la solicitud es de tipo POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Verificar que el ID de reserva se haya proporcionado
        if (!isset($_POST['id_reserva'])) {
            throw new Exception('ID de reserva no proporcionado'); // Lanzar excepción si no se proporciona
        }

        // Obtener los datos del formulario
        $id_reserva = $_POST['id_reserva'];
        $platos = $_POST['platos'] ?? ''; // Usar valor vacío si no se proporciona
        $cantidad_personas = $_POST['cantidad_personas'] ?? 0; // Usar 0 si no se proporciona
        $telefono = $_POST['telefono'] ?? ''; // Usar valor vacío si no se proporciona
        $fecha = $_POST['fecha'] ?? ''; // Usar valor vacío si no se proporciona
        $hora = $_POST['hora'] ?? ''; // Usar valor vacío si no se proporciona
        $instrucciones = $_POST['instrucciones'] ?? ''; // Usar valor vacío si no se proporciona

        // Preparar la consulta SQL para actualizar la reserva
        $query = "UPDATE reservas SET 
                  platos = ?, 
                  cantidad_personas = ?, 
                  telefono = ?, 
                  fecha = ?, 
                  hora = ?, 
                  instrucciones = ? 
                  WHERE id_reserva = ?";

        $stmt = $conexion->prepare($query); // Preparar la consulta
        
        // Comprobar si la preparación de la consulta fue exitosa
        if (!$stmt) {
            throw new Exception('Error en la preparación de la consulta: ' . $conexion->error); // Lanzar excepción si hay un error
        }

        // Vincular los parámetros a la consulta
        $stmt->bind_param('ssissss', 
            $platos, 
            $cantidad_personas, 
            $telefono, 
            $fecha, 
            $hora, 
            $instrucciones, 
            $id_reserva
        );

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Si la ejecución es exitosa, devolver un mensaje de éxito
            echo json_encode(['success' => true, 'message' => 'Reserva actualizada correctamente']);
        } else {
            // Lanzar una excepción si hay un error al ejecutar la consulta
            throw new Exception('Error al ejecutar la consulta: ' . $stmt->error);
        }

        // Cerrar la declaración
        $stmt->close();

    // Si la solicitud es de tipo GET
    } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // Verificar que el ID de reserva esté presente
        if (!isset($_GET['id_reserva'])) {
            throw new Exception('ID de reserva no proporcionado'); // Lanzar excepción si no se proporciona
        }

        // Obtener el ID de reserva del GET
        $id_reserva = $_GET['id_reserva'];
        
        // Preparar la consulta SQL para obtener la reserva
        $query = "SELECT * FROM reservas WHERE id_reserva = ?";
        $stmt = $conexion->prepare($query); // Preparar la consulta
        
        // Comprobar si la preparación de la consulta fue exitosa
        if (!$stmt) {
            throw new Exception('Error en la preparación de la consulta: ' . $conexion->error); // Lanzar excepción si hay un error
        }

        // Vincular el parámetro a la consulta
        $stmt->bind_param('i', $id_reserva);
        $stmt->execute(); // Ejecutar la consulta
        $result = $stmt->get_result(); // Obtener el resultado
        
        // Comprobar si se encontraron filas
        if ($result->num_rows === 0) {
            throw new Exception('No se encontró la reserva'); // Lanzar excepción si no se encuentra la reserva
        }

        // Obtener la reserva como un array asociativo
        $reserva = $result->fetch_assoc();
        echo json_encode($reserva); // Devolver la reserva en formato JSON

        // Cerrar la declaración
        $stmt->close();
    }
} catch (Exception $e) {
    // En caso de una excepción, devolver un mensaje de error en formato JSON
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage(), // Mensaje de error
        'error_details' => $e // Detalles de la excepción
    ]);
}

// Cerrar la conexión a la base de datos
$conexion->close();

