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
        // Comprobar si se ha proporcionado el ID de reserva
        if (!isset($_POST['id_reserva'])) {
            throw new Exception('ID de reserva no proporcionado'); // Lanzar excepción si no se proporciona
        }

        // Obtener el ID de reserva del POST
        $id_reserva = $_POST['id_reserva'];

        // Preparar la consulta SQL para eliminar la reserva
        $query = "DELETE FROM reservas WHERE id_reserva = ?";
        $stmt = $conexion->prepare($query); // Preparar la consulta
        
        // Comprobar si la preparación de la consulta fue exitosa
        if (!$stmt) {
            throw new Exception('Error en la preparación de la consulta: ' . $conexion->error); // Lanzar excepción si hay un error
        }

        // Vincular el parámetro a la consulta (tipo entero)
        $stmt->bind_param('i', $id_reserva);
        
        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Si la ejecución es exitosa, devolver un mensaje de éxito
            echo json_encode(['success' => true, 'message' => 'Reserva eliminada correctamente']);
        } else {
            // Lanzar una excepción si hay un error al ejecutar la consulta
            throw new Exception('Error al eliminar la reserva: ' . $stmt->error);
        }

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