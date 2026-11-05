<?php
require "../../models/entities/clients.php";
require "../../models/mappers/clients_mappers.php";
require "../../models/database/clients_db_interface.php";
require "../../models/database/clients_db.php";
require "../../models/repositories/clients_repository_interface.php";
require "../../models/repositories/clients_repository.php";
require "../../models/config/models_config.php";
require "../../controllers/mappers/clients_mappers.php";
require "../../controllers/clients/clients_controller_interface.php";
require "../../controllers/clients/clients_controller.php";
require "../../controllers/config/controllers_config.php";

use app\controllers\config\ControllersConfig;

$controller = ControllersConfig::get_clients_controller();
$list = $controller->get_clients();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
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
            <h1>Clientes</h1>
            <a class="btn btn-primary" href="../actions/clients/formularioClient.php">
                + Registrar Cliente
            </a>
        </section>

        <section class="list-controls">
            <h2>Buscar por nombre</h2>
            <form method="get" action="" class="search-form">
                <input type="text" name="search" placeholder="Buscar por nombre..."
                    value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </form>
        </section>

        <section class="grid-panel">
            <h2>Lista de Clientes</h2>

            <div class="grid-wrapper">
                <!-- Encabezados -->
                <div class="grid-row grid-head">
                    <div class="grid-cell">Código</div>
                    <div class="grid-cell">Nombre</div>
                    <div class="grid-cell">Telefono</div>
                    <div class="grid-cell">Email</div>
                    <div class="grid-cell">N° Licencia</div>
                    <div class="grid-cell">Acciones</div>
                </div>

                <?php if (count($list) === 0): ?>
                    <div class="grid-empty">No hay clientes registrados.</div>
                <?php endif; ?>

                <?php foreach ($list as $item):
                    $id = $item->get_id();
                ?>
                    <div class="grid-row">
                        <div class="grid-cell" data-label="Código">
                            <?= htmlspecialchars($item->get_id()) ?>
                        </div>
                        <div class="grid-cell" data-label="Nombre">
                            <?= htmlspecialchars($item->get_name()) ?>
                        </div>
                        <div class="grid-cell" data-label="Teléfono">
                            <?= htmlspecialchars($item->get_phone()) ?>
                        </div>
                        <div class="grid-cell" data-label="Email">
                            <?= htmlspecialchars($item->get_email()) ?>
                        </div>
                        <div class="grid-cell" data-label="N° Licencia">
                            <?= htmlspecialchars($item->get_license_number()) ?>
                        </div>
                        <div class="grid-cell grid-actions" data-label="Acciones">
                            <a class="btn btn-edit" href="../actions/clients/formularioClient.php?id=<?= $item->get_id() ?>">Modificar</a>
                            <a class="btn btn-delete" href="#">Borrar</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
</body>

</html>