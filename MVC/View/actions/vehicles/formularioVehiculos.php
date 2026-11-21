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

$controller = ControllersConfig::get_vehicles_controller();

$id = empty($_GET["id"]) ? null : (int) $_GET["id"];
$titulo = empty($id) ? "Registrar Vehículo" : "Modificar Vehículo";
$action_form = empty($id) ? "register_vehicles.php" : "modify_vehicles.php";
$marca = "";
$modelo = "";
$anio = "";
$categoria = "";
$estado = "disponible";

$not_found = false;
if (!empty($id)) {
    try {
        $vehicle = $controller->get_vehicle($id);
    } catch (Throwable $e) {
        $not_found = true;
    }
    if (!$not_found) {
        $marca = $vehicle->get_marca();
        $modelo = $vehicle->get_model();
        $anio = $vehicle->get_anio();
        $categoria = $vehicle->get_categoria();
        $estado = $vehicle->get_estado();
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
            <h1>Vehículo no encontrado</h1>
            <p class="result-message">El vehículo que intentas modificar no existe.</p>
            <div class="result-actions">
                <a class="btn btn-primary" href="../../php/vehiculos.php">Volver</a>
            </div>
        </section>
        <?php else: ?>
        <section class="form-card">
            <h1><?= htmlspecialchars($titulo) ?></h1>
            <p class="form-sub">Completa los datos del vehículo.</p>
            <form method="post" action="<?= $action_form ?>" class="crud-form">
                <input type="hidden" name="id" value="<?= (int) $id ?>">
                <div class="field-row">
                    <div class="field">
                        <label for="marca">Marca</label>
                        <input type="text" name="marca" id="marca" value="<?= htmlspecialchars($marca) ?>" required>
                    </div>
                    <div class="field">
                        <label for="modelo">Modelo</label>
                        <input type="text" name="modelo" id="modelo" value="<?= htmlspecialchars($modelo) ?>" required>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field">
                        <label for="anio">Año</label>
                        <input type="number" name="anio" id="anio" min="1950" max="2100" value="<?= htmlspecialchars($anio) ?>" required>
                    </div>
                    <div class="field">
                        <label for="categoria">Categoría</label>
                        <input type="text" name="categoria" id="categoria" value="<?= htmlspecialchars($categoria) ?>" required>
                    </div>
                </div>
                <div class="field">
                    <label for="estado">Estado</label>
                    <select name="estado" id="estado" required>
                        <option value="disponible" <?= $estado === 'disponible' ? 'selected' : '' ?>>Disponible</option>
                        <option value="alquilado" <?= $estado === 'alquilado' ? 'selected' : '' ?>>Alquilado</option>
                        <option value="mantenimiento" <?= $estado === 'mantenimiento' ? 'selected' : '' ?>>Mantenimiento</option>
                    </select>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-submit">Guardar</button>
                    <a class="btn btn-ghost" href="../../php/vehiculos.php">Cancelar</a>
                </div>
            </form>
        </section>
        <?php endif; ?>
    </main>
</body>

</html>
