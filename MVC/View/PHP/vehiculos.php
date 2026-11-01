<?php
require "../../models/entities/vehicles.php";
require "../../models/mappers/vehicles_mappers.php";
require "../../models/database/vehicles_db_interface.php";
require "../../models/database/vehicles_db.php";
require "../../models/repositories/vehicles_repository_interface.php";
require "../../models/repositories/vehicles_repository.php";
require "../../models/config/models_config.php";
require "../../controllers/mappers/vehicles_mappers.php";
require "../../controllers/vehicles/vehicles_controller_interface.php";
require "../../controllers/vehicles/vehicles_controller.php";
require "../../controllers/config/controllers_config.php";

use app\controllers\config\ControllersConfig;

$controller = ControllersConfig::get_vehicles_controller();
$list = $controller->get_vehicles();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehiculos</title>
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
                Vehiculos
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
    </nav>

    <div class="page-container">
        <section class="header-section">
            <h1>Vehículos</h1>
            <a class="btn btn-primary" href="../actions/vehicles/formularioVehiculos.php">
                + Registrar Vehículo
            </a>
        </section>

        <section class="list-controls">
            <h2>Buscar por nombre</h2>
            <form method="get" action="" class="search-form">
                <input type="text" name="search" placeholder="Buscar por marca o modelo..."
                    value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </form>
        </section>

        <section class="grid-panel">
            <h2>Lista de Vehículos</h2>

            <div class="grid-wrapper">
                <!-- Encabezados -->
                <div class="grid-row grid-head">
                    <div class="grid-cell">Código</div>
                    <div class="grid-cell">Marca</div>
                    <div class="grid-cell">Modelo</div>
                    <div class="grid-cell">Año</div>
                    <div class="grid-cell">Categoría</div>
                    <div class="grid-cell">Estado</div>
                    <div class="grid-cell">Acciones</div>
                </div>

                <?php if (count($list) === 0): ?>
                    <div class="grid-empty">No hay vehículos registrados.</div>
                <?php endif; ?>

                <?php foreach ($list as $item):
                    $id = $item->get_id();
                    $estado = $item->get_estado();
                ?>
                    <div class="grid-row">
                        <div class="grid-cell" data-label="Código">
                            <?= htmlspecialchars($item->get_id()) ?>
                        </div>
                        <div class="grid-cell" data-label="Marca">
                            <?= htmlspecialchars($item->get_marca()) ?>
                        </div>
                        <div class="grid-cell" data-label="Modelo">
                            <?= htmlspecialchars($item->get_model()) ?>
                        </div>
                        <div class="grid-cell" data-label="Año">
                            <?= htmlspecialchars($item->get_anio()) ?>
                        </div>
                        <div class="grid-cell" data-label="Categoría">
                            <?= htmlspecialchars($item->get_categoria()) ?>
                        </div>
                        <div class="grid-cell" data-label="Estado">
                            <span class="badge"><?= htmlspecialchars($estado) ?></span>
                        </div>
                        <div class="grid-cell grid-actions" data-label="Acciones">
                            <a class="btn btn-edit" href="../actions/vehicles/formularioVehiculos.php?id=<?= $item->get_id() ?>">Modificar</a>
                            <a class="btn btn-delete" href="#">Borrar</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
</body>

</html>