<?php
// Iniciar la sesión para acceder a los datos guardados
session_start();

// Verificar si los datos de la transacción están disponibles en la sesión
if (isset($_SESSION['transaccion'])) {
    $transaccion = $_SESSION['transaccion'];
} else {
    echo "<div class='alert alert-danger'>No se encontraron datos de la transacción.</div>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado de la Transacción</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            max-width: 900px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #28a745;
        }

        .alert {
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table th, .info-table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .info-table th {
            background-color: #f4f4f4;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #888;
        }

        /* Estilo para el contador */
        #contador {
            font-size: 20px;
            font-weight: bold;
            color: #d9534f;
        }        

        /* Estilo para el botón de descarga */
        .btn-descargar {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 20px;
        }

        .btn-descargar:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Mensaje de éxito -->
    <div class="alert alert-success">
        <h1>¡Transacción Exitosa!</h1>
        <h5>Pago y solicitud registrados correctamente.</h5>
    </div>
    <p style="text-align: center;">Serás redirigido en <span id="contador">60</span> segundos...</p>
    <!-- Información de la Solicitud -->
    <table class="info-table">
        <tr>
            <th>Número de recibo</th>
            <td><?php echo htmlspecialchars($transaccion['numero_recibo']); ?></td>
        </tr>
        <tr>
            <th>Tipo de Usuario</th>
            <td><?php echo htmlspecialchars($transaccion['tipo_usuario']); ?></td>
        </tr>
        <tr>
            <th>Identificación</th>
            <td><?php echo htmlspecialchars($transaccion['identificacion']); ?></td>
        </tr>
        <tr>
            <th>Nombre</th>
            <td><?php echo htmlspecialchars($transaccion['nombre']); ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?php echo htmlspecialchars($transaccion['email']); ?></td>
        </tr>
        <tr>
            <th>Teléfono</th>
            <td><?php echo htmlspecialchars($transaccion['telefono']); ?></td>
        </tr>
        <tr>
            <th>Dirección</th>
            <td><?php echo htmlspecialchars($transaccion['direccion']); ?></td>
        </tr>
        <tr>
            <th>Descripción del Trámite</th>
            <td><?php echo htmlspecialchars($transaccion['descripcion']); ?></td>
        </tr>
        <tr>
            <th>Monto Pagado</th>
            <td><?php echo '$' . number_format($transaccion['monto'], 2); ?></td>
        </tr>
        <tr>
            <th>Método de Pago</th>
            <td><?php echo ($transaccion['metodo_pago'] === 1) ? "PSE" : "Tarjeta de Crédito/Débito"; ?></td>
        </tr>
        <tr>
            <th>Fecha de Solicitud</th>
            <td><?php echo $transaccion['fecha_actual']; ?></td>
        </tr>
        <tr>
            <th>Número de transacción</th>
            <td>Acá va el número de transacción que retorna el banco</td>
        </tr>
        <tr>
            <th>Fecha y hora de transacción</th>
            <td>Acá va la fecha y hora de transacción que retorna el banco</td>
        </tr>
    </table>

    <!-- Botón de descarga -->
    <a href="generar_comprobante.php" class="btn-descargar">Descargar Comprobante</a>

    <!-- Redirección después de 60 segundos -->
    <script>
        var contador = 60;
        var contadorElement = document.getElementById("contador");

        function actualizarContador() {
            if (contador > 0) {
                contador--;
                contadorElement.textContent = contador;
            } else {
                window.location.href = "https://dirliquidacionesbq.gov.co";  // Cambia la URL a la página deseada
            }
        }

        setInterval(actualizarContador, 1000); // Actualiza el contador cada segundo
    </script>

</div>

</body>
</html>
