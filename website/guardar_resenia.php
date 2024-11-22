<?php
session_start(); // Inicia la sesión
ini_set('display_errors', 0); // Desactiva la visualización de errores
error_reporting(0); // Desactiva la notificación de errores
include "conexion.php"; // Incluye el archivo de conexión a la base de datos

// Verifica si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    // Si no hay usuario en sesión, devuelve un mensaje de error en formato JSON
    echo json_encode(['success' => false, 'message' => 'Por favor inicia sesión para dejar una reseña.']);
    exit(); // Termina la ejecución del script
}

$id_cliente = $_SESSION['id_cliente']; // Obtiene el ID del cliente de la sesión
$imagenes = []; // Inicializa un array para almacenar las rutas de las imágenes

// Verifica si se han subido archivos
if (!empty($_FILES['file']['name'][0])) {
    $target_dir = "img/img_resenia/"; // Directorio donde se guardarán las imágenes

    // Itera sobre cada archivo subido
    foreach ($_FILES['file']['name'] as $key => $file_name) {
        $target_file = $target_dir . basename($file_name); // Ruta original del archivo

        // Obtiene la extensión y el nombre base del archivo
        $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
        $base_name = pathinfo($file_name, PATHINFO_FILENAME);
        // Crea un nuevo nombre de archivo utilizando la marca de tiempo actual
        $new_file_name = $base_name . '_' . time() . '.' . $file_extension; 
        $target_file = $target_dir . $new_file_name; // Actualiza la ruta del archivo con el nuevo nombre

        // Verifica si el tamaño del archivo es mayor a 5MB
        if ($_FILES['file']['size'][$key] > 5000000) { 
            // Si el archivo es demasiado grande, devuelve un mensaje de error
            echo json_encode(['success' => false, 'message' => "Lo siento, el archivo es demasiado grande: $file_name"]);
            continue; // Continúa con el siguiente archivo
        }

        // Intenta mover el archivo subido al directorio de destino
        if (move_uploaded_file($_FILES['file']['tmp_name'][$key], $target_file)) {
            $imagenes[] = $target_file; // Agrega la ruta del archivo a la lista de imágenes
        } else {
            // Si hay un error al subir la imagen, devuelve un mensaje de error
            echo json_encode(['success' => false, 'message' => "Error al subir la imagen: $file_name"]);
            exit(); // Termina la ejecución del script
        }
    }
}

// Convierte el array de imágenes en una cadena separada por comas
$imagenes_str = implode(',', $imagenes);

// Obtiene la calificación y el comentario del formulario
$calificacion = $_POST['calificacion'];
$comentario = $_POST['comentario'];

// Prepara la consulta SQL para insertar la reseña en la base de datos
$stmt = $conexion->prepare("INSERT INTO resenias (id_cliente, calificacion, comentario, imagen) VALUES (?, ?, ?, ?);");
$stmt->bind_param("iiss", $id_cliente, $calificacion, $comentario, $imagenes_str); // Vincula los parámetros

// Ejecuta la consulta
if ($stmt->execute()) {
    // Si la inserción fue exitosa, devuelve un mensaje de éxito
    echo json_encode(['success' => true, 'message' => 'Reseña guardada exitosamente.']);
} else {
    // Si hubo un error al guardar la reseña, devuelve un mensaje de error
    echo json_encode(['success' => false, 'message' => 'Error al guardar la reseña: ' . $stmt->error]);
}

// Cierra la declaración y la conexión a la base de datos
$stmt->close();
$conexion->close();
?>