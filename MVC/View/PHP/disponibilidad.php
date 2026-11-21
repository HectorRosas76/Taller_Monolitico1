<?php
// Vehículos
require "../../models/entities/vehicles.php";
require "../../models/mappers/vehicles_mappers.php";
require "../../models/database/vehicles_db_interface.php";
require "../../models/database/vehicles_db.php";
require "../../models/repositories/vehicles_repository_interface.php";
require "../../models/repositories/vehicles_repository.php";
require "../../controllers/mappers/vehicles_mappers.php";
require "../../controllers/vehicles/vehicles_controller_interface.php";
require "../../controllers/vehicles/vehicles_controller.php";

// Configuración 
require "../../controllers/config/controllers_config.php";
require "../../models/config/models_config.php";

use app\controllers\config\ControllersConfig;

$hoy = date('Y-m-d');
$desde = trim($_GET['desde'] ?? '') ?: $hoy;
$hasta = trim($_GET['hasta'] ?? '') ?: $desde;   

$error = '';
$available = [];
try {
    $available = ControllersConfig::get_vehicles_controller()->get_available_vehicles($desde, $hasta);
} catch (Throwable $e) {
    $error = $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disponibilidad</title>
    <link rel="shortcut icon" href="../../public/images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../../public/css/base.css">
    <link rel="stylesheet" href="../../public/css/menu.css">
    <link rel="stylesheet" href="../../public/css/cre_hist.css">
</head>

<body>
    <nav class="menu">
        <div class="menu-item logo">
            <a href="index.php">
                <img src="../../public/images/logo.png" alt="Logo">
            </a>
        </div>
        <div class="menu-item">
            <a href="vehiculos.php">
                Vehículos
            </a>
        </div>
        <div class="menu-item">
            <a href="clientes.php">
                Clientes
            </a>
        </div>
        <div class="menu-item">
            <a href="reservas.php">
                Reservas
            </a>
        </div>
        <div class="menu-item">
            <a href="disponibilidad.php">
                Disponibilidad
            </a>
        </div>
        <div class="menu-item">
            <a href="historial.php">
                Historial
            </a>
        </div>
    </nav>

    <div class="page-container">
        <section class="header-section">
            <h1>Disponibilidad</h1>
        </section>

        <section class="filter-panel">
            <div class="filter-box wide">
                <h2>¿Qué vehículos están libres?</h2>
                <form method="get" action="">
                    <div>
                        <label for="desde">Desde</label>
                        <input type="date" name="desde" id="desde" value="<?= htmlspecialchars($desde) ?>" required>
                    </div>
                    <div>
                        <label for="hasta">Hasta</label>
                        <input type="date" name="hasta" id="hasta" value="<?= htmlspecialchars($hasta) ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Consultar</button>
                </form>
                <p class="filter-hint">Se muestran los vehículos que no están en mantenimiento ni tienen una reserva activa que se cruce con esas fechas.</p>
            </div>
        </section>

        <?php if ($error !== ''): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php else: ?>
            <section class="grid-panel">
                <h2>
                    Vehículos disponibles
                    <?= $desde === $hasta ? 'el ' . htmlspecialchars($desde) : 'del ' . htmlspecialchars($desde) . ' al ' . htmlspecialchars($hasta) ?>
                    (<?= count($available) ?>)
                </h2>

                <div class="grid-wrapper">
                    <div class="grid-row cols-avail grid-head">
                        <div class="grid-cell">Código</div>
                        <div class="grid-cell">Marca</div>
                        <div class="grid-cell">Modelo</div>
                        <div class="grid-cell">Año</div>
                        <div class="grid-cell">Categoría</div>
                        <div class="grid-cell">Acción</div>
                    </div>

                    <?php if (count($available) === 0): ?>
                        <div class="grid-empty">No hay vehículos disponibles en ese periodo.</div>
                    <?php endif; ?>

                    <?php foreach ($available as $item): ?>
                        <div class="grid-row cols-avail">
                            <div class="grid-cell" data-label="Código"><?= htmlspecialchars($item->get_id()) ?></div>
                            <div class="grid-cell" data-label="Marca"><?= htmlspecialchars($item->get_marca()) ?></div>
                            <div class="grid-cell" data-label="Modelo"><?= htmlspecialchars($item->get_model()) ?></div>
                            <div class="grid-cell" data-label="Año"><?= htmlspecialchars($item->get_anio()) ?></div>
                            <div class="grid-cell" data-label="Categoría"><?= htmlspecialchars($item->get_categoria()) ?></div>
                            <div class="grid-cell grid-actions" data-label="Acción">
                                <a class="btn btn-sm btn-success"
                                    href="../actions/reservations/formularioReservas.php?vehiculo_id=<?= $item->get_id() ?>&fecha_inicio=<?= urlencode($desde) ?>&fecha_fin=<?= urlencode($hasta) ?>">
                                    Reservar
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>
    </div>
</body>

</html>
