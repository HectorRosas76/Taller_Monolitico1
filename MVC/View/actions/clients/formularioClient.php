<?php
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

// Configuración 
require "../../../models/config/models_config.php";
require "../../../controllers/config/controllers_config.php";

use app\controllers\config\ControllersConfig;

$controller = ControllersConfig::get_clients_controller();

$id = empty($_GET["id"]) ? null : (int) $_GET["id"];
$titulo = empty($id) ? "Registrar Cliente" : "Modificar Cliente";
$action_form = empty($id) ? "register_clients.php" : "modify_clients.php";
$nombre = "";
$correo = "";
$telefono = "";
$numero_licencia = "";

$not_found = false;
if (!empty($id)) {
    try {
        $client = $controller->get_client($id);
    } catch (Throwable $e) {
        $not_found = true;
    }
    if (!$not_found) {
        $nombre = $client->get_name();
        $correo = $client->get_email();
        $telefono = $client->get_phone();
        $numero_licencia = $client->get_license_number();
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
            <h1>Cliente no encontrado</h1>
            <p class="result-message">El cliente que intentas modificar no existe.</p>
            <div class="result-actions">
                <a class="btn btn-primary" href="../../php/clientes.php">Volver</a>
            </div>
        </section>
        <?php else: ?>
        <section class="form-card">
            <h1><?= htmlspecialchars($titulo) ?></h1>
            <p class="form-sub">Datos de contacto y licencia del cliente.</p>
            <form method="post" action="<?= $action_form ?>" class="crud-form">
                <input type="hidden" name="id" value="<?= (int) $id ?>">
                <div class="field">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" value="<?= htmlspecialchars($nombre) ?>" required>
                </div>
                <div class="field-row">
                    <div class="field">
                        <label for="telefono">Teléfono</label>
                        <input type="text" name="telefono" id="telefono" value="<?= htmlspecialchars($telefono) ?>" required>
                    </div>
                    <div class="field">
                        <label for="correo">Email</label>
                        <input type="email" name="correo" id="correo" value="<?= htmlspecialchars($correo) ?>" required>
                    </div>
                </div>
                <div class="field">
                    <label for="numero_licencia">Número de licencia</label>
                    <input type="text" name="numero_licencia" id="numero_licencia" value="<?= htmlspecialchars($numero_licencia) ?>" required>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-submit">Guardar</button>
                    <a class="btn btn-ghost" href="../../php/clientes.php">Cancelar</a>
                </div>
            </form>
        </section>
        <?php endif; ?>
    </main>
</body>

</html>
