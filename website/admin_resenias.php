<?php include "header.php" ?> <!-- Incluye el archivo de encabezado -->
<?php include "conexion.php" ?> <!-- Incluye el archivo de conexión a la base de datos -->

<?php
    session_start(); // Inicia la sesión

    // Verifica si el usuario ha iniciado sesión
    if(!isset($_SESSION['usuario'])){
        echo '
        <script>
            alert("porfavor inicia sesion para hacer una reserva") // Alerta si no ha iniciado sesión
            window.location = "reservas.php"; // Redirige a la página de reservas
        </script>';
        session_destroy(); // Destruye la sesión
        die(); // Termina la ejecución del script
    }  
?>

<?php
// Verifica si se ha solicitado eliminar una reseña
if (isset($_GET['delete'])) {
    $id_resenia = intval($_GET['delete']); // Obtiene el ID de la reseña a eliminar
    $delete_query = "DELETE FROM resenias WHERE id_resenia = ?"; // Consulta para eliminar la reseña
    $stmt = $conexion->prepare($delete_query); // Prepara la consulta
    $stmt->bind_param("i", $id_resenia); // Asocia el parámetro
    if ($stmt->execute()) { // Ejecuta la consulta
        echo "<script>Swal.fire('¡Éxito!', 'Reseña eliminada exitosamente.', 'success');</script>"; // Muestra mensaje de éxito
    } else {
        echo "<script>Swal.fire('¡Error!', 'Error al eliminar la reseña: " . $stmt->error . "', 'error');</script>"; // Muestra mensaje de error
    }
    $stmt->close(); // Cierra la declaración
}

// Consulta para obtener todas las reseñas de la base de datos
$query = "SELECT r.*, c.nombre, c.apellido FROM resenias r JOIN clientes c ON r.id_cliente = c.id_cliente ORDER BY r.id_resenia DESC";
$result = mysqli_query($conexion, $query); // Ejecuta la consulta
?>

<h2>Reseñas de Usuarios</h2> <!-- Título de la sección -->

<div style="background-color: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
    <table id="reseniasTable" class="display" style="width:100%"> <!-- Tabla para mostrar las reseñas -->
        <thead>
            <tr>
                <th>ID</th>
                <th>Calificación</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Comentario</th>
                <th>Imágenes</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Verifica si hay reseñas disponibles
            if (mysqli_num_rows($result) > 0) {
                // Itera sobre las reseñas y las muestra en la tabla
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['id_resenia']) . "</td>
                            <td>" . htmlspecialchars($row['calificacion']) . "</td>
                            <td>" . htmlspecialchars($row['nombre']) . "</td>
                            <td>" . htmlspecialchars($row['apellido']) . "</td>
                            <td>" . htmlspecialchars($row['comentario']) . "</td>
                            <td>";
                    $imagenes = explode(',', $row['imagen']); // Separa las imágenes
                    foreach ($imagenes as $imagen) {
                        echo "<img src='" . htmlspecialchars($imagen) . "' class='card-img' alt='Imagen de reseña' style='width: 100px; height: auto;'>"; // Muestra cada imagen
                    }
                    echo "</td>
                            <td>
                                <a href='#' class='delete-button' data-id='" . htmlspecialchars($row['id_resenia']) . "'>Eliminar</a> <!-- Botón para eliminar la reseña -->
                            </td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No hay reseñas disponibles.</td></tr>"; // Mensaje si no hay reseñas
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Incluir las bibliotecas de DataTables y SweetAlert -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css"> <!-- Estilos para DataTables -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2 .min.css"> <!-- Estilos para SweetAlert -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Biblioteca jQuery -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script> <!-- Biblioteca DataTables -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Biblioteca SweetAlert -->

<script>
    $(document).ready(function() {
        $('#reseniasTable').DataTable(); // Inicializa DataTables para la tabla de reseñas

        // Maneja el evento de clic en el botón de eliminar
        $('.delete-button').on('click', function(e) {
            e.preventDefault(); // Previene el comportamiento por defecto del enlace
            var id = $(this).data('id'); // Obtiene el ID de la reseña a eliminar

            // Muestra una alerta de confirmación
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminarlo!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'admin_resenias.php?delete=' + id; // Redirige para eliminar la reseña
                }
            });
        });
    });
</script>

<?php include "footer.php" ?> <!-- Incluye el archivo de pie de página -->