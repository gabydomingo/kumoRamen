<?php include "header.php" ?>
<?php include "conexion.php" ?>

<?php
session_start();
if (isset($_SESSION['usuario'])){
    if($_SESSION['tipo_usuario'] == 1){
        header("Location: admin_resenias.php");

    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        
        $mail = $_SESSION['usuario'];
        $query_cliente = "SELECT id_cliente FROM clientes WHERE mail = ?";
        $stmt_cliente = $conexion->prepare($query_cliente);
        $stmt_cliente->bind_param("s", $mail);
        $stmt_cliente->execute();
        $result_cliente = $stmt_cliente->get_result();
        
        if ($result_cliente->num_rows == 0) {
            throw new Exception("Cliente no encontrado");
        }
        
        $cliente = $result_cliente->fetch_assoc();
        $id_cliente = $cliente['id_cliente'];

        
        $calificacion = isset($_POST['calificacion']) ? intval($_POST['calificacion']) : 0;
        $comentario = trim($_POST['comentario']);

        if ($calificacion < 1 || $calificacion > 5) {
            throw new Exception("Calificación inválida");
        }

        
        if (empty($comentario)) {
            throw new Exception("El comentario no puede estar vacío");
        }

        $imagen = null;
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
            $tipos_permitidos = ['image/jpeg', 'image/png', 'image/gif'];
            $tipo_archivo = mime_content_type($_FILES['imagen']['tmp_name']);
            
            if (!in_array($tipo_archivo, $tipos_permitidos)) {
                throw new Exception("Tipo de archivo no permitido. Solo se aceptan imágenes JPG, PNG y GIF.");
            }

            
            if ($_FILES['imagen']['size'] > 5 * 1024 * 1024) {
                throw new Exception("El tamaño de la imagen no debe superar 5MB");
            }

           
            $imagen = file_get_contents($_FILES['imagen']['tmp_name']);
        }

        $query = "INSERT INTO resenias (calificacion, comentario, imagen, id_cliente) 
                  VALUES (?, ?, ?, ?)";
        
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("issi", $calificacion, $comentario, $imagen, $id_cliente);
        
        if ($stmt->execute()) {
            echo '<script>
                alert("Reseña guardada exitosamente");
                window.location = "resenias.php";
            </script>';
            exit();
        } else {
            throw new Exception("Error al guardar la reseña: " . $stmt->error);
        }

    } catch (Exception $e) {
        echo '<script>
            alert("' . $e->getMessage() . '");
            window.location = "resenias.php";
        </script>';
        exit();
    }
}
?>

<?php
$query_resenias = "SELECT r.*, c.nombre, c.apellido 
                   FROM resenias r 
                   JOIN clientes c ON r.id_cliente = c.id_cliente 
                   ORDER BY r.fecha DESC"; 

$result_resenias = $conexion->query($query_resenias);
?>


<div class="container mt-5">
    <h2 class="mb-4">Deja tu Reseña</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
        <div class="form-group mb-3">
            <label for="calificacion">Calificación:</label>
            <select name="calificacion" id="calificacion" class="form-control" required>
                <option value="">Selecciona una calificación</option>
                <option value="1">1 Estrella</option>
                <option value="2">2 Estrellas</option>
                <option value="3">3 Estrellas</option>
                <option value="4">4 Estrellas</option>
                <option value="5">5 Estrellas</option>
            </select>
        </div>
        
        <div class="form-group mb-3">
            <label for="comentario">Comentario:</label>
            <textarea name="comentario" id="comentario" class="form-control" rows="4" 
                      placeholder="Escribe tu reseña" required></textarea>
        </div>
        
        <div class="form-group mb-3">
            <label for="imagen">Imagen (opcional):</label>
            <input type="file" name="imagen" id="imagen" class="form-control" 
                   accept="image/jpeg,image/png,image/gif">
            <small class="form-text text-muted">
                Tamaño máximo: 5MB. Formatos permitidos: JPG, PNG, GIF
            </small>
        </div>
        
        <button type="submit" class="btn btn-primary">Enviar Reseña</button>
    </form>
</div>

<?php
$query_resenias = "SELECT r.*, c.nombre, c.apellido 
FROM resenias r 
JOIN clientes c ON r.id_cliente = c.id_cliente 
ORDER BY r.fecha DESC";

$result_resenias = $conexion->query($query_resenias);
?>

<div class="container mt-5">
    <h2>Reseñas Anteriores</h2>
    <div class="row">
        <?php while ($resenia = $result_resenias->fetch_assoc()): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <?php echo htmlspecialchars($resenia['nombre'] . ' ' . $resenia['apellido']); ?>
                        </h5>
                        <div class="text-warning">
                            <?php 
                            for ($i = 1; $i <= 5; $i++) {
                                echo $i <= $resenia['calificacion'] ? '★' : '☆';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="card-text"><?php echo htmlspecialchars($resenia['comentario']); ?></p>
                        
                        <?php if (!empty($resenia['imagen'])): ?>
                            <img src="mostrar_imagen.php?id=<?php echo $resenia['id_resenia']; ?>" 
                                 class="img-fluid rounded" alt="Imagen de reseña">
                        <?php endif; ?>
                    </div>
                    <div class="card-footer text-muted">
                        <?php echo date('d/m/Y H:i', strtotime($resenia['fecha_resenia'])); ?>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>


?>



<?php include "footer.php" ?>