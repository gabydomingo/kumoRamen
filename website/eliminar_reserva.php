<?php
include 'conexion.php';

header('Content-Type: application/json');

// Habilitar reporte de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_POST['id_reserva'])) {
            throw new Exception('ID de reserva no proporcionado');
        }

        $id_reserva = $_POST['id_reserva'];

        $query = "DELETE FROM reservas WHERE id_reserva = ?";
        $stmt = $conexion->prepare($query);
        
        if (!$stmt) {
            throw new Exception('Error en la preparación de la consulta: ' . $conexion->error);
        }

        $stmt->bind_param('i', $id_reserva);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Reserva eliminada correctamente']);
        } else {
            throw new Exception('Error al eliminar la reserva: ' . $stmt->error);
        }

        $stmt->close();
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage(),
        'error_details' => $e
    ]);
}

$conexion->close();