<?php
// Conexion a la base de datos
require_once("config/db.php");
require_once("config/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<?php include('includes/head.php'); ?>
<body>
    <div class="container mt-5">
        <!--<H4 class="text-center mb-4">Trámites Dirección Distrital de liquidaciones Barranquilla</H4>-->
        <?php include('includes/formulario.php'); ?>
    </div>
    <!-- Enlace a JavaScript de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>
