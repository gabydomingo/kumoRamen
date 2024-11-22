<h2>Reseñas Anteriores</h2>
<div class="card-container" id="reseniasContainer">
    <?php
    // Obtener reseñas de la base de datos junto con el nombre y apellido del cliente
    $query = "SELECT r.*, c.nombre, c.apellido FROM resenias r JOIN clientes c ON r.id_cliente = c.id_cliente ORDER BY r.id_resenia DESC";
    $result = mysqli_query($conexion, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='card'>
                    <h3>Calificación: " . htmlspecialchars($row['calificacion']) . "</h3>
                    <p><strong>Reseñado por:</strong> " . htmlspecialchars($row['nombre']) . " " . htmlspecialchars($row['apellido']) . "</p>
                    <p>" . htmlspecialchars($row['comentario']) . "</p>
                    <p><strong>Imágenes:</strong></p>";
            $imagenes = explode(',', $row['imagen']);
            foreach ($imagenes as $imagen) {
                echo "<img src='" . htmlspecialchars($imagen) . "' class='card-img' alt='Imagen de reseña'>";
            }
            echo "</div>";
        }
    } else {
        echo "<p>No hay reseñas disponibles.</p>";
    }
    ?>
</div>