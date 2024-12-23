<?php
// Conexión a la base de datos
require_once("../config/db.php");
require_once("../config/conexion.php");

// Verificar si el formulario fue enviado correctamente
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Capturar datos del formulario
    $tipo_usuario = mysqli_real_escape_string($con, $_POST['tipo_usuario']);
    $identificacion = mysqli_real_escape_string($con, $_POST['identificacion']);
    $nombre = mysqli_real_escape_string($con, $_POST['nombre']);
    $email = mysqli_real_escape_string($con, $_POST['correo']);
    $telefono = mysqli_real_escape_string($con, $_POST['telefono']);
    $direccion = mysqli_real_escape_string($con, $_POST['direccion']);
    $descripcion=mysqli_real_escape_string($con, $_POST['descripcion_tramite']);

    $tramite_id = intval($_POST['tramite']);
    $monto = floatval($_POST['monto']);
    $metodo_pago = intval($_POST['metodo_pago']);
    $fecha_actual = date('Y-m-d H:i:s');

    // Validar campos específicos para tarjeta de crédito/débito
    $numero_tarjeta = null;
    $fecha_vencimiento = null;
    $cvv = null;

    if ($metodo_pago === 2) { // 2 = Tarjeta de crédito/débito
        $numero_tarjeta = mysqli_real_escape_string($con, $_POST['numero_tarjeta']);
        $fecha_vencimiento = mysqli_real_escape_string($con, $_POST['fecha_vencimiento']);
        $cvv = mysqli_real_escape_string($con, $_POST['cvv']);
    }

    // Iniciar transacción
    mysqli_begin_transaction($con);

    try {
        // 1. Insertar en la tabla `usuarios`
        $query_usuario = "INSERT INTO usuarios (tipo_usuario, identificacion, nombre, email, telefono, direccion) 
                          VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_usuario = mysqli_prepare($con, $query_usuario);
        mysqli_stmt_bind_param($stmt_usuario, "ssssss", $tipo_usuario, $identificacion, $nombre, $email, $telefono, $direccion);
        mysqli_stmt_execute($stmt_usuario);

        // Obtener el ID del usuario insertado
        $usuario_id = mysqli_insert_id($con);

        // 2. Insertar en la tabla `recibos`
        $query_recibo = "INSERT INTO recibos (tipo_tramite_id, usuario_id, id_metodo_pago, descripcion, monto, estado, fecha_emision) 
                         VALUES (?, ?, ?, ?, ?, 'pendiente', ?)";
        $stmt_recibo = mysqli_prepare($con, $query_recibo);
        mysqli_stmt_bind_param($stmt_recibo, "iiisds", $tramite_id, $usuario_id, $metodo_pago, $descripcion, $monto, $fecha_actual);
        mysqli_stmt_execute($stmt_recibo);

         // Obtener el ID del RECIBO
         $recibo_id = mysqli_insert_id($con);

        // Guardar los datos de la transacción en la sesión
        session_start();
        $_SESSION['transaccion'] = [
            'tipo_usuario' => $tipo_usuario,
            'identificacion' => $identificacion,
            'nombre' => $nombre,
            'email' => $email,
            'telefono' => $telefono,
            'direccion' => $direccion,
            'descripcion' => $descripcion,
            'tramite_id' => $tramite_id,
            'monto' => $monto,
            'metodo_pago' => $metodo_pago,
            'fecha_actual' => $fecha_actual,
            'numero_recibo' =>  $recibo_id,
        ];

        // Confirmar la transacción
        mysqli_commit($con);

        // Mensaje de éxito en la interfaz
        echo "
        <div id='cargando' style='text-align: center;'>
            <img src='../img/carga.gif' alt='Cargando...'>
            <p>Procesando tu solicitud. ACÁ SE HARIA LA INTERFAZ CON EL BANCO!.</p>
        </div>

        <div id='mensaje-exito' style='display:none; text-align: center;'>
            <p class='alert alert-success'>Datos de la solicitud han sido registrados exitosamente.</p>
        </div>

        <script>
            // Mostrar imagen de carga
            setTimeout(function() {
                // Ocultar el cargando y mostrar mensaje de éxito
                document.getElementById('cargando').style.display = 'none';
                document.getElementById('mensaje-exito').style.display = 'block';

                // Redirigir después de 5 segundos
                setTimeout(function() {
                    window.location.href = 'pago_exitoso.php'; // Cambiar a la página de destino
                }, 1000); // 10 segundos de espera
            }, 3000); // Esperar 3 segundos antes de mostrar el mensaje de éxito
        </script>
        ";
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        mysqli_rollback($con);

        echo "<div class='alert alert-danger'>Error al procesar la transacción: " . $e->getMessage() . "</div>";
    }

    // Cerrar la conexión
    mysqli_close($con);
} else {
    echo "<div class='alert alert-danger'>Acceso no autorizado.</div>";
}
?>
