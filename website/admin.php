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

<div class="container-fluid admin-table-container">
    <h2 class="admin-table-title">
        <i class="fas fa-calendar-alt me-2"></i>Gestión de Reservas
        <button class="btn btn-danger float-end" onclick="window.location.href='cerrar_sesion.php'">
            <i class="fas fa-sign-out-alt me-1"></i>Cerrar Sesión
        </button>
    </h2>

    <div class="table-responsive">
        <table id="reservasTable" class="table table-striped">
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
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr data-id='" . $row["id_reserva"] . "'>
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
                            <td>
                            <button class='btn btn-edit' data-id='" . $row["id_reserva"] . "'>Editar</button>
                            <button class='btn btn-delete' data-id='" . $row["id_reserva"] . "'>Eliminar</button>
                        </td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='10'>No hay reservas disponibles.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <div class="modal fade" id="editReservaModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Reserva</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editReservaForm">
                        <input type="hidden" id="edit-id-reserva" name="id_reserva">
                        <div class="mb-3">
                            <label>Platos</label>
                            <input type="text" class="form-control" id="edit-platos" name="platos">
                        </div>
                        <div class="mb-3">
                            <label>Cantidad Personas</label>
                            <input type="number" class="form-control" id="edit-personas" name="cantidad_personas">
                        </div>
                        <div class="mb-3">
                            <label>Teléfono</label>
                            <input type="tel" class="form-control" id="edit-telefono" name="telefono">
                        </div>
                        <div class="mb-3">
                            <label>Fecha</label>
                            <input type="date" class="form-control" id="edit-fecha" name="fecha">
                        </div>
                        <div class="mb-3">
                            <label>Hora</label>
                            <input type="time" class="form-control" id="edit-hora" name="hora">
                        </div>
                        <div class="mb-3">
                            <label>Instrucciones</label>
                            <textarea class="form-control" id="edit-instrucciones" name="instrucciones"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="guardarCambios">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>

<?php include "footer.php" ?>