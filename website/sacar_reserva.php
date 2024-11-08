<?php include "header.php" ?>
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
    
?>


<!-- <section class="cuerpo"> -->
   
    <div class="form" id="pedido">
    <img src="img\logo\kumo-men.png" alt="Logo Kumo" class="logo">
    <h1>Escoge que y como comer!!</h1>

    <form action="carga.php" method="POST">
        <fieldset>
            <legend>Platos</legend>
            <label>
                Shoyu - $7500 
                <input type="number" name="shoyu" min="0" value="0" style="width: 50px;">
            </label>
            <label>
                Miso - $7500 
                <input type="number" name="miso" min="0" value="0" style="width: 50px;">
            </label>
            <label>
                Paitan - $8400 
                <input type="number" name="paitan" min="0" value="0" style="width: 50px;">
            </label>
            <label>
                Shoyu+ - $9000 
                <input type="number" name="shoyu2" min="0" value="0" style="width: 50px;">
            </label>
            <label>
                Shio - $7500 
                <input type="number" name="shio" min="0" value="0" style="width: 50px;">
            </label>
            <label>
                Miso Picante - $8000 
                <input type="number" name="miso-picante" min="0" value="0" style="width: 50px;">
            </label>
            <label>
                Miso Vegano - $8200 
                <input type="number" name="vegano" min="0" value="0" style="width: 50px;">
            </label>
            <label>
                TanTan - $10200 
                <input type="number" name="tantan" min="0" value="0" style="width: 50px;">
            </label>
        </fieldset>

        <input type="number" name="personas" placeholder="Cantidad de personas" required>
        <input type="tel" name="telefono" placeholder="Número de teléfono" required>
        <input type="date" name="fecha" required>
        <input type="time" name="hora" required>
        <textarea name="instrucciones" placeholder="Instrucciones especiales para el chef"></textarea>
        <br>
        <button type="submit">Generar Reservar</button>
        <br>
        <button class="btn btn-danger float-end" onclick="window.location.href='cerrar_sesion.php'">Cerrar Sesión</button>
    </form>

<!-- </section> -->

<!-- <section class="cuerpo">
<h1>Formulario de Pedido</h1>
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
            echo "<input type='number' id='plato_$index' name='plato[$index]' min='0' value='0'><br><br>";
        }
        ?>

        <input type="submit" value="Enviar Pedido">
    </form>




</section> -->



<?php include "footer.php" ?>