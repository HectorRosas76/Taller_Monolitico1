<?php
// Vehículos
require "../../../models/entities/vehicles.php";
require "../../../models/mappers/vehicles_mappers.php";
require "../../../models/database/vehicles_db_interface.php";
require "../../../models/database/vehicles_db.php";
require "../../../models/repositories/vehicles_repository_interface.php";
require "../../../models/repositories/vehicles_repository.php";
require "../../../controllers/mappers/vehicles_mappers.php";
require "../../../controllers/vehicles/vehicles_controller_interface.php";
require "../../../controllers/vehicles/vehicles_controller.php";

// Configuración 
require "../../../models/config/models_config.php";
require "../../../controllers/config/controllers_config.php";

use app\controllers\config\ControllersConfig;

$ok = false;
$detail = '';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $ok = ControllersConfig::get_vehicles_controller()->vehicle_update($_POST);
    } catch (Throwable $e) {
        $detail = ($e instanceof InvalidArgumentException)
            ? $e->getMessage()
            : 'Revisa los datos e inténtalo de nuevo.';
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado de la acción</title>
    <link rel="shortcut icon" href="../../../public/images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../../../public/css/base.css">
    <link rel="stylesheet" href="../../../public/css/menu.css">
    <link rel="stylesheet" href="../../../public/css/cre_hist.css">
</head>

<body>
    <nav class="menu">
        <div class="menu-item logo">
            <a href="../../php/index.php">
                <img src="../../../public/images/logo.png" alt="Logo">
            </a>
        </div>
        <div class="menu-item">
            <a href="../../php/vehiculos.php">
                Vehículos
            </a>
        </div>
        <div class="menu-item">
            <a href="../../php/clientes.php">
                Clientes
            </a>
        </div>
        <div class="menu-item">
            <a href="../../php/reservas.php">
                Reservas
            </a>
        </div>
        <div class="menu-item">
            <a href="../../php/disponibilidad.php">
                Disponibilidad
            </a>
        </div>
        <div class="menu-item">
            <a href="../../php/historial.php">
                Historial
            </a>
        </div>
    </nav>

    <main class="result-page">
        <section class="result-card <?= $ok ? 'result-ok' : 'result-error' ?>">
            <div class="result-icon"><?= $ok ? '&#10003;' : '&#10007;' ?></div>
            <h1><?= $ok ? '¡Vehículo actualizado!' : 'No se pudo actualizar' ?></h1>
            <p class="result-message"><?= $ok ? 'Los cambios se guardaron correctamente.' : 'Ocurrió un problema al actualizar el vehículo.' ?></p>
            <?php if (!$ok && $detail !== ''): ?>
                <p class="result-detail"><?= htmlspecialchars($detail) ?></p>
            <?php endif; ?>
            <div class="result-actions">
                <a class="btn btn-primary" href="../../php/vehiculos.php">Volver a vehículos</a>
                <?php if (!$ok): ?>
                    <a class="btn btn-ghost" href="javascript:history.back()">Corregir datos</a>
                <?php endif; ?>
            </div>
        </section>
    </main>
</body>

</html>
