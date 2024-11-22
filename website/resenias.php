<?php session_start(); // Inicia la sesión
include "header.php" ?> <!-- Incluye el encabezado de la página -->
<?php include "conexion.php" ?> <!-- Incluye el archivo de conexión a la base de datos -->

<?php

if (isset($_SESSION['usuario'])) { // Verifica si hay un usuario en sesión
    if ($_SESSION['tipo_usuario'] == 1) { // Verifica si el tipo de usuario es 1 (administrador)
        header("Location: admin_resenias.php"); // Redirige al administrador a la página de reseñas
    }
}

// $id_cliente = $_SESSION['id_cliente']; // Obtiene el ID del cliente de la sesión
// ?>

<?php include "mostrar_reseia.php" ?> <!-- Incluye el archivo que muestra las reseñas -->

<h2>Dejar una Reseña</h2> <!-- Título de la sección para dejar una reseña -->
<form action="guardar_resenia.php" method="POST" enctype="multipart/form-data" class="dropzone" id="myDropzone">
    <div class="fallback"> <!-- Sección para subir archivos si Dropzone no está disponible -->
        <input name="file[]" type="file" multiple/> <!-- Campo para seleccionar múltiples archivos -->
    </div>
    <div>
        <label for="calificacion">Calificación:</label> <!-- Etiqueta para la calificación -->
        <div class="star-rating"> <!-- Contenedor para las estrellas de calificación -->
            <input type="radio" name="calificacion" value="5" id="star5" required> <!-- Opción de calificación 5 estrellas -->
            <label for="star5" class="star">&#9733;</label> <!-- Estrella correspondiente -->
            <input type="radio" name="calificacion" value="4" id="star4"> <!-- Opción de calificación 4 estrellas -->
            <label for="star4" class="star">&#9733;</label> <!-- Estrella correspondiente -->
            <input type="radio" name="calificacion" value="3" id="star3"> <!-- Opción de calificación 3 estrellas -->
            <label for="star3" class="star">&#9733;</label> <!-- Estrella correspondiente -->
            <input type="radio" name="calificacion" value="2" id="star2"> <!-- Opción de calificación 2 estrellas -->
            <label for="star2" class="star">&#9733;</label> <!-- Estrella correspondiente -->
            <input type="radio" name="calificacion" value="1" id="star1"> <!-- Opción de calificación 1 estrella -->
            <label for="star1" class="star">&#9733;</label> <!-- Estrella correspondiente -->
        </div>
    </div>
    <div>
        <label for="comentario">Comentario:</label> <!-- Etiqueta para el comentario -->
        <textarea name="comentario" required></textarea> <!-- Área de texto para el comentario -->
    </div>
    <button type="submit">Enviar Reseña</button> <!-- Botón para enviar la reseña -->
</form>

<!-- Inclusión de librerías JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Librería para alertas -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"></script> <!-- Librería para subir archivos -->

<script>
// Configuración de Dropzone
Dropzone.options.myDropzone = {
    paramName: "file[]", // Nombre del parámetro para los archivos
    maxFilesize: 5, // Tamaño máximo de archivo en MB
    acceptedFiles: ".jpeg,.jpg,.png,.gif", // Tipos de archivos aceptados
    dictDefaultMessage: "Arrastra y suelta tus archivos aquí para subirlos", // Mensaje por defecto
    autoProcessQueue: false, // No procesar automáticamente la cola de archivos
    init: function() {
        const myDropzone = this; // Guarda la instancia de Dropzone

        // Evento que se dispara al subir un archivo con éxito
        this.on("success", function(file, response) {
            console.log("Respuesta del servidor:", response); // Muestra la respuesta del servidor en la consola
            try {
                const jsonResponse = JSON.parse(response); // Intenta parsear la respuesta JSON
                if (jsonResponse.success) { // Si la respuesta indica éxito
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: jsonResponse.message, // Mensaje de éxito
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        location.reload(); // Rec argar la página para mostrar la nueva reseña
                    });
                } else { // Si la respuesta indica un error
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        text: jsonResponse.message, // Mensaje de error
                        confirmButtonText: 'Aceptar'
                    });
                }
            } catch (e) { // Manejo de errores al parsear la respuesta
                console.error("Error al parsear la respuesta JSON:", e);
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: 'Hubo un problema al procesar la respuesta del servidor.', // Mensaje de error genérico
                    confirmButtonText: 'Aceptar'
                });
            }
        });

        // Evento que se dispara al ocurrir un error al subir un archivo
        this.on("error", function(file, errorMessage) {
            console.log("Error al subir el archivo:", errorMessage); // Muestra el error en la consola
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: 'Error al subir el archivo: ' + errorMessage, // Mensaje de error específico
                confirmButtonText: 'Aceptar'
            });
        });

        // Manejar el envío del formulario
        document.getElementById("myDropzone").onsubmit = function(e) {
            e.preventDefault(); // Previene el comportamiento por defecto del formulario
            myDropzone.processQueue(); // Procesa la cola de archivos en Dropzone
        };
    }
};
</script>
<?php include "footer.php" ?> <!-- Incluye el pie de página -->