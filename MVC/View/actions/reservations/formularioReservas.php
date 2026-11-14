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

$id = empty($_GET["id"]) ? null : $_GET["id"];
$titulo = empty($id) ? "Registrar Reserva" : "Modificar Reserva";
$action_form = empty($id) ? "register_reservations.php"
    : "modify_reservations.php";
$codigo = "";
$cliente_id = "";
$vehiculo_id = "";
$fecha_inicio = "";
$fecha_fin = "";
$estado = "";

if (!empty($id)) {
    $reservation = $controller->get_reservation($id);
    $codigo = $reservation->get_id();
    $cliente_id = $reservation->get_client_id();
    $vehiculo_id = $reservation->get_vehicle_id();
    $fecha_inicio = $reservation->get_start_date();
    $fecha_fin = $reservation->get_end_date();
    $estado = $reservation->get_status();
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

                    <a href="../../php/reservas.php"> Volver </a>

                </div>
                <div>
                    <label for="cliente_id">Cliente ID: </label>
                    <input type="text" name="cliente_id" id="cliente_id" value="<?php echo $cliente_id; ?>" required>
                </div>
                <div>
                    <label for="vehiculo_id">Vehículo ID: </label>
                    <input type="text" name="vehiculo_id" id="vehiculo_id" value="<?php echo $vehiculo_id; ?>" required>
                </div>
                <div>
                    <label for="fecha_inicio">Fecha de Inicio:</label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio" value="<?php echo $fecha_inicio; ?>" required>
                </div>
                <div>
                    <label for="fecha_fin">Fecha de Fin:</label>
                    <input type="date" name="fecha_fin" id="fecha_fin" value="<?php echo $fecha_fin; ?>" required>
                </div>
                <div>
                    <label for="estado">Estado:</label>
                    <select name="estado" id="estado" required>
                        <option value="">Seleccionar</option>
                        <option value="activa" <?php echo $estado === 'activa' ? 'selected' : ''; ?>>Activa</option>
                        <option value="completada" <?php echo $estado === 'completada' ? 'selected' : ''; ?>>Completada</option>
                        <option value="cancelada" <?php echo $estado === 'cancelada' ? 'selected' : ''; ?>>Cancelada</option>
                    </select>
                </div>
                <div>
                    <button type="submit">Guardar</button>
                </div>
            </div>
        </form>
    </section>
</body>

</html>