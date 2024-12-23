<?php
// Iniciar el buffer de salida para evitar errores de salida previa
ob_start();

// Incluir el autoload de Composer (asegúrate de que la ruta sea correcta)
require_once('../vendor/autoload.php'); // Si usas Composer

// Iniciar la sesión para acceder a los datos guardados
session_start();

// Verificar si los datos de la transacción están disponibles en la sesión
if (isset($_SESSION['transaccion'])) {
    $transaccion = $_SESSION['transaccion'];
} else {
    echo "<div class='alert alert-danger'>No se encontraron datos de la transacción.</div>";
    exit();
}

// Crear un nuevo PDF
$pdf = new TCPDF();

// Configurar el PDF
$pdf->SetCreator('TCPDF');
$pdf->SetAuthor('Tu Nombre o Empresa');
$pdf->SetTitle('Comprobante de Transacción');
$pdf->SetMargins(10, 10, 10);
$pdf->AddPage();

// Agregar contenido al PDF
$html = "
<h1>Comprobante de Transacción</h1>
<p><strong>Número de recibo:</strong> " . htmlspecialchars($transaccion['numero_recibo']) . "</p>
<p><strong>Tipo de Usuario:</strong> " . htmlspecialchars($transaccion['tipo_usuario']) . "</p>
<p><strong>Identificación:</strong> " . htmlspecialchars($transaccion['identificacion']) . "</p>
<p><strong>Nombre:</strong> " . htmlspecialchars($transaccion['nombre']) . "</p>
<p><strong>Email:</strong> " . htmlspecialchars($transaccion['email']) . "</p>
<p><strong>Teléfono:</strong> " . htmlspecialchars($transaccion['telefono']) . "</p>
<p><strong>Dirección:</strong> " . htmlspecialchars($transaccion['direccion']) . "</p>
<p><strong>Descripción del Trámite:</strong> " . htmlspecialchars($transaccion['descripcion']) . "</p>
<p><strong>Monto Pagado:</strong> $" . number_format($transaccion['monto'], 2) . "</p>
<p><strong>Método de Pago:</strong> " . ($transaccion['metodo_pago'] === 1 ? "Transferencia Bancaria" : "Tarjeta de Crédito/Débito") . "</p>
<p><strong>Fecha de Solicitud:</strong> " . $transaccion['fecha_actual'] . "</p>
<p><strong>Número de transacción:</strong> Acá va el número de transacción que retorna el banco</p>
<p><strong>Fecha y hora de transacción:</strong> Acá va la fecha y hora de transacción que retorna el banco</p>
";

// Escribir el contenido HTML en el PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Descargar el PDF
$pdf->Output('comprobante_transaccion.pdf', 'D');

// Finalizar el buffer de salida
ob_end_flush();
exit;
?>
