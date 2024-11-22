<?php include "header.php" ?> <!-- Incluir el encabezado de la página -->
<?php include "conexion.php" ?> <!-- Incluir el archivo de conexión a la base de datos -->
<?php
session_start(); // Iniciar la sesión

// Verificar si el usuario ha iniciado sesión
if(!isset($_SESSION['usuario'])){
    // Si no ha iniciado sesión, mostrar un mensaje y redirigir
    echo '
    <script>
        alert("Por favor inicia sesión para hacer una reserva");
        window.location = "reservas.php"; // Redirigir a la página de reservas
    </script>';
    session_destroy(); // Destruir la sesión
    die(); // Terminar la ejecución del script
}

// Verificar si hay errores de conexión a la base de datos
if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error()); // Mostrar error de conexión
}

// Consulta para obtener las reservas junto con los detalles del cliente
$sql = "SELECT reservas.*, clientes.nombre, clientes.apellido, clientes.mail, clientes.celular 
        FROM reservas 
        INNER JOIN clientes ON reservas.id_cliente = clientes.id_cliente";
$result = mysqli_query($conexion, $sql); // Ejecutar la consulta

?>

<!-- Importar jQuery y DataTables -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

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
            // Comprobar si hay reservas disponibles
            if (mysqli_num_rows($result) > 0) {
                // Recorrer cada fila de resultados
                while($row = mysqli_fetch_assoc($result)) {
                    // Mostrar los datos en la tabla
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
                // Mensaje si no hay reservas disponibles
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
                    <form id ="editReservaForm">
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
</div>
<script>
    $(document).ready(function() {
        var table = $('#reservasTable').DataTable({
            responsive: true,
            pageLength: 10,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
            },
            columnDefs: [
                { 
                    targets: -1, 
                    orderable: false, 
                    searchable: false 
                }
            ],
            drawCallback: function() {
                $('.dataTables_paginate .paginate_button').addClass('btn btn-sm btn-outline-primary mx-1');
            }
        });

        // Evento para editar reserva
        $('#reservasTable').on('click', '.btn-edit', function() {
            var idReserva = $(this).data('id');
            
            $.ajax({
                url: 'editar_reserva.php',
                method: 'GET',
                data: { id_reserva: idReserva },
                dataType: 'json',
                success: function(data) {
                    console.log('Datos recibidos:', data);  // Depuración x1 
                    
                    if (data.success === false) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message
                        });
                        return;
                    }

                    $('#edit-id-reserva').val(data.id_reserva);
                    $('#edit-platos').val(data.platos);
                    $('#edit-personas').val(data.cantidad_personas);
                    $('#edit-telefono').val(data.telefono);
                    $('#edit-fecha').val(data.fecha);
                    $('#edit-hora').val(data.hora);
                    $('#edit-instrucciones').val(data.instrucciones);
                    
                    $('#editReservaModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('Error en la solicitud:', status, error);
                    console.log('Respuesta del servidor:', xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de conexión',
                        text: 'No se pudo cargar la reserva: ' + error
                    });
                }
            });
        });

        // Evento para guardar cambios
        $('#guardarCambios').click(function() {
            $.ajax({
                url: 'editar_reserva.php',
                method: 'POST',
                data: $('#editReservaForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    console.log('Respuesta del servidor:', response);  // Depuración x1000
                    
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Reserva Actualizada',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error en la solicitud:', status, error);
                    console.log('Respuesta del servidor:', xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de conexión',
                        text: 'No se pudo guardar los cambios: ' + error
                    });
                }
            });
        });

        // Evento para eliminar reserva
        $('#reservasTable').on('click', '.btn-delete', function() {
            var idReserva = $(this).data('id');
            var $row = $(this).closest('tr');
            
            Swal.fire({
                title: '¿Estás seguro?',
                text: "No podrás revertir esta acción",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'eliminar_reserva.php',
                        method: 'POST',
                        data: { id_reserva: idReserva },
                        dataType: 'json',
                        success: function(response) {
                            console.log('Respuesta del servidor:', response);
                            
                            if (response.success) {
                                // Eliminar la fila de la tabla
                                table.row($row).remove().draw();
                                
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Reserva eliminada',
                                    text: response.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error en la solicitud:', status, error);
                            console.log('Respuesta del servidor:', xhr.responseText);
                            
                            Swal.fire({
                                icon: 'error',
                                title: 'Error de conexión',
                                text: 'No se pudo eliminar la reserva: ' + error
                            });
                        }
                    });
                }
            });
        });
    });
</script>

<?php include "footer.php" ?> <!-- Incluir el pie de página -->