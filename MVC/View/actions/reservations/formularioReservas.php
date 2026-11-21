<?php
// Reservas
require "../../../models/entities/reservations.php";
require "../../../models/mappers/reservations_mappers.php";
require "../../../models/database/reservations_db_interface.php";
require "../../../models/database/reservations_db.php";
require "../../../models/repositories/reservations_repository_interface.php";
require "../../../models/repositories/reservations_repository.php";
require "../../../controllers/mappers/reservations_mappers.php";
require "../../../controllers/reservations/reservations_controller_interface.php";
require "../../../controllers/reservations/reservations_controller.php";

// Clientes
require "../../../models/entities/clients.php";
require "../../../models/mappers/clients_mappers.php";
require "../../../models/database/clients_db_interface.php";
require "../../../models/database/clients_db.php";
require "../../../models/repositories/clients_repository_interface.php";
require "../../../models/repositories/clients_repository.php";
require "../../../controllers/mappers/clients_mappers.php";
require "../../../controllers/clients/clients_controller_interface.php";
require "../../../controllers/clients/clients_controller.php";

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

$controller = ControllersConfig::get_reservations_controller();

$id = empty($_GET["id"]) ? null : (int) $_GET["id"];
$titulo = empty($id) ? "Registrar Reserva" : "Modificar Reserva";
$action_form = empty($id) ? "register_reservations.php" : "modify_reservations.php";

// Valores iniciales 
$cliente_id = (int) ($_GET['cliente_id'] ?? 0);
$vehiculo_id = (int) ($_GET['vehiculo_id'] ?? 0);
$fecha_inicio = $_GET['fecha_inicio'] ?? '';
$fecha_fin = $_GET['fecha_fin'] ?? '';
$estado = "activa";

$clients = ControllersConfig::get_clients_controller()->get_clients();
$vehicles = ControllersConfig::get_vehicles_controller()->get_vehicles();

$not_found = false;
if (!empty($id)) {
    try {
        $reservation = $controller->get_reservation($id);
    } catch (Throwable $e) {
        $not_found = true;
    }
    if (!$not_found) {
        $cliente_id = (int) $reservation->get_client_id();
        $vehiculo_id = (int) $reservation->get_vehicle_id();
        $fecha_inicio = $reservation->get_start_date();
        $fecha_fin = $reservation->get_end_date();
        $estado = $reservation->get_status();
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titulo) ?></title>
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
    <main class="form-page">
        <?php if ($not_found): ?>
        <section class="result-card result-error">
            <div class="result-icon">&#10007;</div>
            <h1>Reserva no encontrada</h1>
            <p class="result-message">La reserva que intentas modificar no existe.</p>
            <div class="result-actions">
                <a class="btn btn-primary" href="../../php/reservas.php">Volver</a>
            </div>
        </section>
        <?php else: ?>
        <section class="form-card">
            <h1><?= htmlspecialchars($titulo) ?></h1>
            <p class="form-sub">Elige el cliente, el vehículo y el periodo del alquiler.</p>

            <?php if (count($clients) === 0 || count($vehicles) === 0): ?>
                <div class="alert alert-error">
                    Para crear una reserva necesitas al menos un cliente y un vehículo registrados.
                </div>
            <?php endif; ?>

            <form method="post" action="<?= $action_form ?>" class="crud-form">
                <input type="hidden" name="id" value="<?= (int) $id ?>">
                <div class="field">
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
                <div class="field">
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
                <div class="field-row">
                    <div class="field">
                        <label for="fecha_inicio">Fecha de inicio</label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio" value="<?= htmlspecialchars($fecha_inicio) ?>" required>
                    </div>
                    <div class="field">
                        <label for="fecha_fin">Fecha de fin</label>
                        <input type="date" name="fecha_fin" id="fecha_fin" value="<?= htmlspecialchars($fecha_fin) ?>" required>
                    </div>
                </div>
                <div class="field">
                    <label for="estado">Estado</label>
                    <select name="estado" id="estado" required>
                        <option value="activa" <?= $estado === 'activa' ? 'selected' : '' ?>>Activa</option>
                        <option value="completada" <?= $estado === 'completada' ? 'selected' : '' ?>>Completada</option>
                        <option value="cancelada" <?= $estado === 'cancelada' ? 'selected' : '' ?>>Cancelada</option>
                    </select>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-submit">Guardar</button>
                    <a class="btn btn-ghost" href="../../php/reservas.php">Cancelar</a>
                </div>
            </form>
        </section>
        <?php endif; ?>
    </main>

    <script>
        // La fecha de fin nunca puede ser anterior a la de inicio.
        const inicio = document.getElementById('fecha_inicio');
        const fin = document.getElementById('fecha_fin');
        function ajustarFin() {
            fin.min = inicio.value;
            if (fin.value && fin.value < inicio.value) fin.value = inicio.value;
        }
        inicio.addEventListener('change', ajustarFin);
        ajustarFin();
    </script>
</body>

</html>
