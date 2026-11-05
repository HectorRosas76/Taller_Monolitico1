<?php
require "../../../models/entities/clients.php";
require "../../../models/mappers/clients_mappers.php";
require "../../../models/database/clients_db_interface.php";
require "../../../models/database/clients_db.php";
require "../../../models/repositories/clients_repository_interface.php";
require "../../../models/repositories/clients_repository.php";
require "../../../models/config/models_config.php";
require "../../../controllers/mappers/clients_mappers.php";
require "../../../controllers/clients/clients_controller_interface.php";
require "../../../controllers/clients/clients_controller.php";
require "../../../controllers/config/controllers_config.php";

use app\controllers\config\ControllersConfig;

$controller = ControllersConfig::get_clients_controller();

$id = empty($_GET["id"]) ? null : $_GET["id"];
$titulo = empty($id) ? "Registrar Cliente" : "Modificar Cliente";
$action_form = empty($id) ? "register_clients.php"
    : "modify_clients.php";
$codigo = "";
$nombre = "";
$correo = "";
$telefono = "";
$numero_licencia = "";

if (!empty($id)) {
    $client = $controller->get_client($id);
    $codigo = $client->get_id();
    $nombre = $client->get_name();
    $correo = $client->get_email();
    $telefono = $client->get_phone();
    $numero_licencia = $client->get_license_number();
}

$estado = $_POST['estado'] ?? '';


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../public/images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../../../public/css/base.css">
    <link rel="stylesheet" href="../../../public/css/menu.css">
    <link rel="stylesheet" href="../../../public/css/cre_hist.css">
    <title><?php echo $titulo; ?></title>
</head>

<body>
    <section class="form-panel">
        <h2><?php echo $titulo; ?></h2>
        <form method="post" action="<?php echo $action_form; ?>" class="crud-form">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div>
                <div>

                    <a href="../../php/clientes.php"> Volver </a>

                </div>
                <div>
                    <label for="nombre">Nombre: </label>
                    <input type="text" name="nombre" id="nombre" value="<?php echo $nombre; ?>" required>
                </div>
                <div>
                    <label for="telefono">Telefono: </label>
                    <input type="text" name="telefono" id="telefono" value="<?php echo $telefono; ?>" required>
                </div>
                <div>
                    <label for="correo">Email:</label>
                    <input type="email" name="correo" id="correo" value="<?php echo $correo; ?>" required>
                </div>
                <div>
                    <label for="numero_licencia">Numero de licencia:</label>
                    <input type="text" name="numero_licencia" id="numero_licencia" value="<?php echo $numero_licencia; ?>" required>
                </div>
                <div>
                    <button type="submit">Guardar</button>
                </div>
            </div>
        </form>
    </section>
</body>

</html>