<?php
// Reservas
require "../../models/entities/reservations.php";
require "../../models/mappers/reservations_mappers.php";
require "../../models/database/reservations_db_interface.php";
require "../../models/database/reservations_db.php";
require "../../models/repositories/reservations_repository_interface.php";
require "../../models/repositories/reservations_repository.php";
require "../../controllers/mappers/reservations_mappers.php";
require "../../controllers/reservations/reservations_controller_interface.php";
require "../../controllers/reservations/reservations_controller.php";

// Clientes
require "../../models/entities/clients.php";
require "../../models/mappers/clients_mappers.php";
require "../../models/database/clients_db_interface.php";
require "../../models/database/clients_db.php";
require "../../models/repositories/clients_repository_interface.php";
require "../../models/repositories/clients_repository.php";
require "../../controllers/mappers/clients_mappers.php";
require "../../controllers/clients/clients_controller_interface.php";
require "../../controllers/clients/clients_controller.php";

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
require "../../models/config/models_config.php";
require "../../controllers/config/controllers_config.php";

use app\controllers\config\ControllersConfig;

$res_controller = ControllersConfig::get_reservations_controller();
$clients = ControllersConfig::get_clients_controller()->get_clients();
$vehicles = ControllersConfig::get_vehicles_controller()->get_vehicles();

$clients_names = [];
foreach ($clients as $c) {
    $clients_names[$c->get_id()] = $c->get_name();
}
$vehicles_names = [];
foreach ($vehicles as $v) {
    $vehicles_names[$v->get_id()] = $v->get_marca() . ' ' . $v->get_model();
}

$cliente_id = (int) ($_GET['cliente_id'] ?? 0);
$vehiculo_id = (int) ($_GET['vehiculo_id'] ?? 0);

$history = [];
$titulo_resultado = '';
$modo = '';
if ($cliente_id > 0) {
    $modo = 'cliente';
    $history = $res_controller->get_history_by_client($cliente_id);
    $titulo_resultado = 'Historial del cliente: ' . ($clients_names[$cliente_id] ?? 'ID ' . $cliente_id);
} elseif ($vehiculo_id > 0) {
    $modo = 'vehiculo';
    $history = $res_controller->get_history_by_vehicle($vehiculo_id);
    $titulo_resultado = 'Historial del vehículo: ' . ($vehicles_names[$vehiculo_id] ?? 'ID ' . $vehiculo_id);
}

function dias_alquiler(string $inicio, string $fin): int
{
    return (int) (new DateTime($inicio))->diff(new DateTime($fin))->days + 1;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial</title>
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
            <h1>Historial de alquileres</h1>
        </section>

        <section class="filter-panel">
            <div class="filter-box">
                <h2>Por cliente</h2>
                <form method="get" action="">
                    <div>
                        <label for="cliente_id">Cliente</label>
                        <select name="cliente_id" id="cliente_id" required>
                            <option value="">Seleccionar</option>
                            <?php foreach ($clients as $c): ?>
                                <option value="<?= $c->get_id() ?>" <?= $cliente_id === $c->get_id() ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($c->get_name()) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Ver historial</button>
                </form>
            </div>

            <div class="filter-box">
                <h2>Por vehículo</h2>
                <form method="get" action="">
                    <div>
                        <label for="vehiculo_id">Vehículo</label>
                        <select name="vehiculo_id" id="vehiculo_id" required>
                            <option value="">Seleccionar</option>
                            <?php foreach ($vehicles as $v): ?>
                                <option value="<?= $v->get_id() ?>" <?= $vehiculo_id === $v->get_id() ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($v->get_marca() . ' ' . $v->get_model() . ' (' . $v->get_anio() . ')') ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Ver historial</button>
                </form>
            </div>
        </section>

        <?php if ($modo === ''): ?>
            <div class="alert alert-info">Elige un cliente o un vehículo para consultar su historial de alquileres.</div>
        <?php else: ?>
            <section class="grid-panel">
                <h2><?= htmlspecialchars($titulo_resultado) ?></h2>

                <div class="grid-wrapper">
                    <div class="grid-row cols-hist grid-head">
                        <div class="grid-cell">Código</div>
                        <div class="grid-cell"><?= $modo === 'cliente' ? 'Vehículo' : 'Cliente' ?></div>
                        <div class="grid-cell">Inicio</div>
                        <div class="grid-cell">Fin</div>
                        <div class="grid-cell">Días</div>
                        <div class="grid-cell">Estado</div>
                    </div>

                    <?php if (count($history) === 0): ?>
                        <div class="grid-empty">Todavía no hay alquileres registrados.</div>
                    <?php endif; ?>

                    <?php foreach ($history as $item):
                        $estado = $item->get_status();
                        $otro = $modo === 'cliente'
                            ? ($vehicles_names[$item->get_vehicle_id()] ?? 'ID ' . $item->get_vehicle_id())
                            : ($clients_names[$item->get_client_id()] ?? 'ID ' . $item->get_client_id());
                    ?>
                        <div class="grid-row cols-hist">
                            <div class="grid-cell" data-label="Código"><?= htmlspecialchars($item->get_id()) ?></div>
                            <div class="grid-cell" data-label="<?= $modo === 'cliente' ? 'Vehículo' : 'Cliente' ?>"><?= htmlspecialchars($otro) ?></div>
                            <div class="grid-cell" data-label="Inicio"><?= htmlspecialchars($item->get_start_date()) ?></div>
                            <div class="grid-cell" data-label="Fin"><?= htmlspecialchars($item->get_end_date()) ?></div>
                            <div class="grid-cell" data-label="Días"><?= dias_alquiler($item->get_start_date(), $item->get_end_date()) ?></div>
                            <div class="grid-cell" data-label="Estado">
                                <span class="badge badge-<?= htmlspecialchars($estado) ?>"><?= htmlspecialchars($estado) ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>
    </div>
</body>

</html>
