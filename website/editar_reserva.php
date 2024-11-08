<?php
include 'conexion.php';

header('Content-Type: application/json');

// Habilitar reporte de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Verificar que los datos estén llegando
        if (!isset($_POST['id_reserva'])) {
            throw new Exception('ID de reserva no proporcionado');
        }

        $id_reserva = $_POST['id_reserva'];
        $platos = $_POST['platos'] ?? '';
        $cantidad_personas = $_POST['cantidad_personas'] ?? 0;
        $telefono = $_POST['telefono'] ?? '';
        $fecha = $_POST['fecha'] ?? '';
        $hora = $_POST['hora'] ?? '';
        $instrucciones = $_POST['instrucciones'] ?? '';

        // Usar mysqli en lugar de PDO para mayor compatibilidad
        $query = "UPDATE reservas SET 
                  platos = ?, 
                  cantidad_personas = ?, 
                  telefono = ?, 
                  fecha = ?, 
                  hora = ?, 
                  instrucciones = ? 
                  WHERE id_reserva = ?";

        $stmt = $conexion->prepare($query);
        
        if (!$stmt) {
            throw new Exception('Error en la preparación de la consulta: ' . $conexion->error);
        }

        $stmt->bind_param('ssissss', 
            $platos, 
            $cantidad_personas, 
            $telefono, 
            $fecha, 
            $hora, 
            $instrucciones, 
            $id_reserva
        );

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Reserva actualizada correctamente']);
        } else {
            throw new Exception('Error al ejecutar la consulta: ' . $stmt->error);
        }

        $stmt->close();

    } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // Verificar que el ID de reserva esté presente
        if (!isset($_GET['id_reserva'])) {
            throw new Exception('ID de reserva no proporcionado');
        }

        $id_reserva = $_GET['id_reserva'];
        
        $query = "SELECT * FROM reservas WHERE id_reserva = ?";
        $stmt = $conexion->prepare($query);
        
        if (!$stmt) {
            throw new Exception('Error en la preparación de la consulta: ' . $conexion->error);
        }

        $stmt->bind_param('i', $id_reserva);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            throw new Exception('No se encontró la reserva');
        }

        $reserva = $result->fetch_assoc();
        echo json_encode($reserva);

        $stmt->close();
    }
} catch (Exception $e) {
    // Enviar error detallado
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage(),
        'error_details' => $e
    ]);
}

$conexion->close();


// eliminar funciona a la perfeccion, pero cuando quiero guardar un cambio editado, me dice SyntaxError: Unexpected token '<', "<br/> <b>"... is not valid JSON