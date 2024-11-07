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


<section class="cuerpo">
    <!-- <div class="form-container">
        <img src="img\logo\kumo-men.png" alt="Logo Kumo" class="logo">
        <h1>Escoge que y como comer!!</h1>

        <form action="#" method="POST">
            <fieldset>
                <legend>Platos</legend>
                <label><input type="checkbox" name="plato" value="shoyu"> Shoyu - $7500</label>
                <label><input type="checkbox" name="plato" value="miso"> Miso - $7500</label>
                <label><input type="checkbox" name="plato" value="paitan"> Paitan - $8400</label>
                <label><input type="checkbox" name="plato" value="shoyu2"> Shoyu+ - $9000</label>
                <label><input type="checkbox" name="plato" value="shio"> Shio - $7500</label>
                <label><input type="checkbox" name="plato" value="miso-picante"> Miso Picante - $8000</label>
                <label><input type="checkbox" name="plato" value="vegano"> Miso Vegano - $8200</label>
                <label><input type="checkbox" name="plato" value="tantan"> TanTan - $10200</label>
            </fieldset>

            <p>Selecciona como quieres tu orden: *</p>
            <label><input type="radio" name="orden" value="delivery" required> Delivery</label>
            <label><input type="radio" name="orden" value="salon"> Salón</label>

            <input type="number" name="personas" placeholder="Cantidad de personas *" required>
            <input type="tel" name="telefono" placeholder="Número de teléfono">
            <input type="text" name="direccion" placeholder="Ingresa tu domicilio">
            <input type="date" name="fecha" required>
            <input type="time" name="hora" required>
            <textarea name="instrucciones" placeholder="Instrucciones especiales para el chef"></textarea>

            <p>Payment Method *</p>
            <label><input type="checkbox" name="metodo" value="efectivo" required> Efectivo Delivery/Salón</label>
            <label><input type="checkbox" name="metodo" value="tarjeta"> Crédito/Débito/Transferencia</label>

            <label><input type="checkbox" name="terminos" required> Acepto términos y condiciones.</label>

            <button type="submit">Reservar</button>
        </form>
    </div> -->
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
    </form>
</div>
    <button><a href="cerrar_sesion.php">cerrar sesion</a></button>
</section>

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