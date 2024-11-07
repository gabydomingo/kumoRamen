<?php include "header.php" ?>
<?php include "conexion.php" ?>
<?php
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

if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT reservas.*, clientes.nombre, clientes.apellido, clientes.mail, clientes.celular 
        FROM reservas 
        INNER JOIN clientes ON reservas.id_cliente = clientes.id_cliente";
$result = mysqli_query($conexion, $sql);

?>

<!-- probar de meter en el footer, por el momento solo funciona aca -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<!--  -->


<section class="cuerpo">
    <h2>Lista de Reservas</h2>
    <table id="reservasTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>ID Reserva</th>
                <th>Nombre Cliente</th>
                <th>Apellido Cliente</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Platos</th>
                <th>Cantidad Personas</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Instrucciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row["id_reserva"]) . "</td>
                            <td>" . htmlspecialchars($row["nombre"]) . "</td>
                            <td>" . htmlspecialchars($row["apellido"]) . "</td>
                            <td>" . htmlspecialchars($row["mail"]) . "</td>
                            <td>" . htmlspecialchars($row["celular"]) . "</td>
                            <td>" . htmlspecialchars($row["platos"]) . "</td>
                            <td>" . htmlspecialchars($row["cantidad_personas"]) . "</td>
                            <td>" . htmlspecialchars($row["fecha"]) . "</td>
                            <td>" . htmlspecialchars($row["hora"]) . "</td>
                            <td>" . htmlspecialchars($row["instrucciones"]) . "</td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='10'>No hay reservas disponibles.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</section>

<script>
$(document).ready(function() {
    $('#reservasTable').DataTable({
        // Opciones adicionales de DataTables
        responsive: true,
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
        language: {
            // Personalización del idioma (opcional)
            url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
        }
    });
});
</script>

<section class="cuerpo">
    <button><a href="cerrar_sesion.php">Cerrar Sesión</a></button>
</section>

<?php include "footer.php" ?>