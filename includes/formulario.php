<!-- includes/formulario.php -->
<?php
// Obtener los tipos de trámites y recibos para las opciones del formulario
$query_tramites = "SELECT id, nombre, valor, descripcion FROM tipos_tramites WHERE estado = 1";
$result_tramites = mysqli_query($con, $query_tramites);
if (!$result_tramites) {
    die("Error al obtener los trámites: " . mysqli_error($con));
}
?>


<!--<h2 class="text-center mb-4">Trámites Dirección Distrital de liquidaciones Barranquilla</h2>-->
<form method="POST" action="/ddl_interfaz_pagos/includes/procesar_pago.php" class="shadow p-4 rounded bg-light" id="formulario">
    <!-- Selección del trámite -->
    <div class="mb-3">
        <label for="tramite" class="form-label">Seleccione el tipo de trámite:</label>
        <select class="form-select" name="tramite" id="tramite" required>
            <option value="">--Seleccione--</option>
            <?php while ($row = mysqli_fetch_assoc($result_tramites)): ?>
                <option value="<?php echo $row['id']; ?>" 
                        data-valor="<?php echo $row['valor']; ?>"
                        data-descripcion="<?php echo htmlspecialchars($row['descripcion']); ?>">
                    <?php echo $row['nombre'] . " - $" . number_format($row['valor'], 2); ?>
                </option>
            <?php endwhile; ?>
        </select>

    </div>
    <!-- Datos del Pago -->
    <input type="hidden" name="monto" id="monto" value="0.00">
    <input type="hidden" name="descripcion_tramite" id="descripcion_tramite_input">
    <div class="row">
        <div class="col-md-6 mb-3">
            <!-- Campo para mostrar el valor del recibo -->
            <label for="valor_recibo" class="form-label">Valor del Recibo:</label>
            <div class="valor-recibo" id="valor_recibo">$0.00</div>
        </div>
        <div class="col-md-6 mb-3">
            <!-- Campo para mostrar la descripción del trámite -->
            <label for="descripcion_tramite" class="form-label">Descripción del trámite:</label>
            <div class="descripcion_tramite" id="descripcion_tramite">Seleccione un trámite</div>
        </div>
    </div>

    <!-- Datos del usuario -->
    <h3 class="mb-3">Datos del Solicitante</h3>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="tipo_usuario" class="form-label">Tipo de Usuario:</label>
            <select class="form-select" name="tipo_usuario" id="tipo_usuario" required>
                <option value="">--Seleccione--</option>
                <option value="natural">Persona Natural</option>
                <option value="juridica">Persona Jurídica</option>
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label for="identificacion" class="form-label">Número de Identificación:</label>
            <input type="text" class="form-control" id="identificacion" name="identificacion" maxlength="20" placeholder="Número de identificación del solicitante" required>
        </div>

    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre completo del solicitante"required>
        </div>
        <div class="col-md-6 mb-3">
            <label for="correo" class="form-label">Correo Electrónico:</label>
            <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo electrónico del solicitante" required>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="telefono" class="form-label">Teléfono:</label>
            <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Télefono del solicitante" required>
        </div>
        <div class="col-md-6 mb-3">
            <label for="direccion" class="form-label">Dirección:</label>
            <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Dirección del solicitante" required>
        </div>
    </div>

    <!-- Datos del Pago -->
    <h3 class="mb-3">Método de pago</h3>
    <div class="mb-3">
        <label for="metodo_pago" class="form-label">Método de Pago:</label>
        <select class="form-select" name="metodo_pago" id="metodo_pago" required>
            <option value="">--Seleccione--</option>
            <option value="1">PSE</option>
            <option value="2">Tarjeta de Crédito/Débito</option>
        </select>
    </div>

    <div id="datos_tarjeta" style="display: none;">
       
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="numero_tarjeta" class="form-label">Número de Tarjeta:</label>
                <input type="text" class="form-control" id="numero_tarjeta" name="numero_tarjeta" maxlength="20" placeholder="Número de Tarjeta">
            </div>
        
            <div class="col-md-4 mb-3">
                <label for="fecha_vencimiento" class="form-label">Fecha de Vencimiento (MM/AA):</label>
                <input type="text" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento" maxlength="5" placeholder="MM/AA">
            </div>
            <div class="col-md-4 mb-3">
                <label for="cvv" class="form-label">CVV:</label>
                <input type="text" class="form-control" id="cvv" name="cvv" maxlength="3" placeholder="CVV">
            </div>
        </div>
        <h6 class="col-md-12 mb-3">Los datos de su tarjeta NO son almacenados en nuestra base de datos, serán usados solo para agilizar el pago a través de nuestro portal bancario</h6>
    </div>

    <!-- Botón para enviar el formulario -->
    <div class="text-center">
        <button type="submit" class="btn btn-primary">Registrar Solicitud</button>
    </div>
</form>
