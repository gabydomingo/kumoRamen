<?php include "header.php" ?> <!-- Incluye el archivo de encabezado -->
<?php
    session_start(); // Inicia la sesión

    // Verifica si el usuario ha iniciado sesión
    if(!isset($_SESSION['usuario'])){
        echo '
        <script>
            alert("porfavor inicia sesion para hacer una reserva") // Muestra un mensaje de alerta
            window.location = "reservas.php"; // Redirige a la página de reservas
        </script>';
        session_destroy(); // Destruye la sesión
        die(); // Termina el script
    }
?>

<!-- <section class="cuerpo"> -->
   
<div class="form" id="pedido"> <!-- Contenedor del formulario de pedido -->
    <img src="img\logo\kumo-men.png" alt="Logo Kumo" class="logo"> <!-- Logo de la empresa -->
    <h1>Escoge que y como comer!!</h1> <!-- Título del formulario -->

    <form action="carga.php" method="POST"> <!-- Formulario que envía datos a carga.php -->
        <fieldset> <!-- Agrupa elementos relacionados -->
            <legend>Platos</legend> <!-- Título del grupo de platos -->
            <label>
                Shoyu - $7500 
                <input type="number" name="shoyu" min="0" value="0" style="width: 50px;"> <!-- Campo para cantidad de Shoyu -->
            </label>
            <label>
                Miso - $7500 
                <input type="number" name="miso" min="0" value="0" style="width: 50px;"> <!-- Campo para cantidad de Miso -->
            </label>
            <label>
                Paitan - $8400 
                <input type="number" name="paitan" min="0" value="0" style="width: 50px;"> <!-- Campo para cantidad de Paitan -->
            </label>
            <label>
                Shoyu+ - $9000 
                <input type="number" name="shoyu2" min="0" value="0" style="width: 50px;"> <!-- Campo para cantidad de Shoyu+ -->
            </label>
            <label>
                Shio - $7500 
                <input type="number" name="shio" min="0" value="0" style="width: 50px;"> <!-- Campo para cantidad de Shio -->
            </label>
            <label>
                Miso Picante - $8000 
                <input type="number" name="miso-picante" min="0" value="0" style="width: 50px;"> <!-- Campo para cantidad de Miso Picante -->
            </label>
            <label>
                Miso Vegano - $8200 
                <input type="number" name="vegano" min="0" value="0" style="width: 50px;"> <!-- Campo para cantidad de Miso Vegano -->
            </label>
            <label>
                TanTan - $10200 
                <input type="number" name="tantan" min="0" value="0" style="width: 50px;"> <!-- Campo para cantidad de TanTan -->
            </label>
        </fieldset>

        <!-- Campos para información de la reserva -->
        <input type="number" name="personas" placeholder="Cantidad de personas" required> <!-- Cantidad de personas -->
        <input type="tel" name="telefono" placeholder="Número de teléfono" required> <!-- Número de teléfono -->
        <input type="date" name="fecha" required> <!-- Fecha de la reserva -->
        <input type="time" name="hora" required> <!-- Hora de la reserva -->
        <textarea name="instrucciones" placeholder="Instrucciones especiales para el chef"></textarea> <!-- Instrucciones especiales -->
        <br>
        <button type="submit">Generar Reservar</button> <!-- Botón para enviar el formulario -->
        <br>
        <button class="btn btn-danger float-end" onclick="window.location.href='cerrar_sesion.php'">Cerrar Sesión</button> <!-- Botón para cerrar sesión -->
    </form>

<!-- </section> -->

<!-- <section class="cuerpo"> -->
<!-- Sección comentada que contiene un formulario alternativo para pedidos -->
<!-- <h1>Formulario de Pedido</h1>
    <form action="procesar_pedido.php" method="POST">
        <label for="cantidad_personas">Cantidad de Personas:</label>
        <input type="number" id="cantidad_personas" name="cantidad_personas" required min="1"><br><br>

        <label for="telefono">Número de Teléfono:</label>
        <input type="tel" id="telefono" name="telefono" required><br><br>

        <label for="fecha">Fecha:</label>
        <input type="date" id="fecha" name="fecha" required><br><br>

        <label for="horario">Horario:</label>
        <input type="time" id="horario" name="horario" required><br><br>

        <h2>Selecciona los Platos</h2>
        <?php
        // Array de platos
        $platos = [
            "Plato 1",
            "Plato 2",
            "Plato 3",
            "Plato 4",
            "Plato 5",
            "Plato 6",
            "Plato 7",
            "Plato 8",
            "Plato 9",
            "Plato 10"
        ];

        // Generar campos para cada plato
        foreach ($platos as $index => $plato) {
            echo "<label for='plato_$index'>$plato:</label>";
            echo "<input type='number' id='plato_$index' name='plato[$index]' min='0' value='0'><br><br>"; // Campo para cada plato
        }
        ?>

        
    </form>
</section>

<?php include "footer.php" ?> 