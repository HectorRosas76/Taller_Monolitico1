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
require "../../controllers/config/controllers_config.php";

use app\controllers\config\ControllersConfig;

$controller = ControllersConfig::get_reservations_controller();
$list = $controller->get_reservations();

// ID => nombre
$clients_names = [];
foreach (ControllersConfig::get_clients_controller()->get_clients() as $c) {
    $clients_names[$c->get_id()] = $c->get_name();
}
$vehicles_names = [];
foreach (ControllersConfig::get_vehicles_controller()->get_vehicles() as $v) {
    $vehicles_names[$v->get_id()] = $v->get_marca() . ' ' . $v->get_model();
}

$search = trim($_GET['search'] ?? '');
if ($search !== '') {
    $list = array_filter($list, function ($item) use ($search, $clients_names, $vehicles_names) {
        $texto = $item->get_id() . ' '
            . ($clients_names[$item->get_client_id()] ?? '') . ' '
            . ($vehicles_names[$item->get_vehicle_id()] ?? '') . ' '
            . $item->get_start_date() . ' ' . $item->get_end_date() . ' ' . $item->get_status();
        return mb_stripos($texto, $search) !== false;
    });
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas</title>
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
            <h1>Reservas</h1>
            <a class="btn btn-primary" href="../actions/reservations/formularioReservas.php">
                + Registrar Reserva
            </a>
        </section>

        <section class="list-controls">
            <h2>Buscar reserva</h2>
            <form method="get" action="" class="search-form">
                <input type="text" name="search" placeholder="Buscar por cliente, vehículo, fecha o estado..."
                    value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </form>
        </section>

        <section class="grid-panel">
            <h2>Lista de Reservas</h2>

            <div class="grid-wrapper">
                <div class="grid-row cols-7 grid-head">
                    <div class="grid-cell">Código</div>
                    <div class="grid-cell">Cliente</div>
                    <div class="grid-cell">Vehículo</div>
                    <div class="grid-cell">Fecha Inicio</div>
                    <div class="grid-cell">Fecha Fin</div>
                    <div class="grid-cell">Estado</div>
                    <div class="grid-cell">Acciones</div>
                </div>

                <?php if (count($list) === 0): ?>
                    <div class="grid-empty">No hay reservas registradas.</div>
                <?php endif; ?>

                <?php foreach ($list as $item):
                    $id = $item->get_id();
                    $estado = $item->get_status();
                ?>
                    <div class="grid-row cols-7">
                        <div class="grid-cell" data-label="Código"><?= htmlspecialchars($id) ?></div>
                        <div class="grid-cell" data-label="Cliente">
                            <?= htmlspecialchars($clients_names[$item->get_client_id()] ?? 'ID ' . $item->get_client_id()) ?>
                        </div>
                        <div class="grid-cell" data-label="Vehículo">
                            <?= htmlspecialchars($vehicles_names[$item->get_vehicle_id()] ?? 'ID ' . $item->get_vehicle_id()) ?>
                        </div>
                        <div class="grid-cell" data-label="Fecha Inicio"><?= htmlspecialchars($item->get_start_date()) ?></div>
                        <div class="grid-cell" data-label="Fecha Fin"><?= htmlspecialchars($item->get_end_date()) ?></div>
                        <div class="grid-cell" data-label="Estado">
                            <span class="badge badge-<?= htmlspecialchars($estado) ?>"><?= htmlspecialchars($estado) ?></span>
                        </div>
                        <div class="grid-cell grid-actions" data-label="Acciones">
                            <a class="btn btn-sm btn-edit" href="../actions/reservations/formularioReservas.php?id=<?= $id ?>">Modificar</a>

                            <?php if ($estado === 'activa'): ?>
                                <form method="post" action="../actions/reservations/return_reservations.php"
                                    onsubmit="return confirm('¿Registrar la devolución de este vehículo?');">
                                    <input type="hidden" name="id" value="<?= (int) $id ?>">
                                    <button type="submit" class="btn btn-sm btn-success">Devolver</button>
                                </form>
                            <?php endif; ?>

                            <form method="post" action="../actions/reservations/delete_reservations.php"
                                onsubmit="return confirm('¿Seguro que deseas borrar esta reserva?');">
                                <input type="hidden" name="id" value="<?= (int) $id ?>">
                                <button type="submit" class="btn btn-sm btn-delete">Borrar</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
</body>

</html>
