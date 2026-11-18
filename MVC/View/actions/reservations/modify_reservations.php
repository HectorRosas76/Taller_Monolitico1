<?php
require "../../../models/entities/reservations.php";
require "../../../models/mappers/reservations_mappers.php";
require "../../../models/database/reservations_db_interface.php";
require "../../../models/database/reservations_db.php";
require "../../../models/repositories/reservations_repository_interface.php";
require "../../../models/repositories/reservations_repository.php";
require "../../../models/config/models_config.php";
require "../../../controllers/mappers/reservations_mappers.php";
require "../../../controllers/reservations/reservations_controller_interface.php";
require "../../../controllers/reservations/reservations_controller.php";
require "../../../controllers/config/controllers_config.php";


use app\controllers\config\ControllersConfig;

$controller = ControllersConfig::get_reservations_controller();
$success = $controller->reservation_update($_POST);
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
    <title>Resultado de la acción</title>
</head>

<body>
    <h1>Resultado de la operación</h1>
    <br>
    <?php
    if ($success) {
        echo '<h2><p>Datos guardados!!!!</p></h2>';
    } else {
        echo '<h2><p>Error al guardar los datos!!!!</p></h2>';
    }
    ?>
    <br>
    <a href="../../php/reservas.php">Volver</a>
</body>

</html>