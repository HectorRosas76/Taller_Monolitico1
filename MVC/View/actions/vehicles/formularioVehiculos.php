<?php
require "../../../models/entities/vehicles.php";
require "../../../models/mappers/vehicles_mappers.php";
require "../../../models/database/vehicles_db_interface.php";
require "../../../models/database/vehicles_db.php";
require "../../../models/repositories/vehicles_repository_interface.php";
require "../../../models/repositories/vehicles_repository.php";
require "../../../models/config/models_config.php";
require "../../../controllers/mappers/vehicles_mappers.php";
require "../../../controllers/vehicles/vehicles_controller_interface.php";
require "../../../controllers/vehicles/vehicles_controller.php";
require "../../../controllers/config/controllers_config.php";

use app\controllers\config\ControllersConfig;

$controller = ControllersConfig::get_vehicles_controller();

$id = empty($_GET["id"]) ? null : $_GET["id"];
$titulo = empty($id) ? "Registrar Vehículo" : "Modificar Vehículo";
$action_form = empty($id) ? "register_vehicles.php"
    : "modify_vehicles.php";
$codigo = "";
$marca = "";
$modelo = "";
$anio = "";
$categoria = "";
$estado = "";

if (!empty($id)) {
    $vehicle = $controller->get_vehicle($id);
    $codigo = $vehicle->get_id();
    $marca = $vehicle->get_marca();
    $modelo = $vehicle->get_model();
    $anio = $vehicle->get_anio();
    $categoria = $vehicle->get_categoria();
    $estado = $vehicle->get_estado();
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

                    <a href="../../php/vehiculos.php"> Volver </a>

                </div>
                <div>
                    <label for="marca">Marca: </label>
                    <input type="text" name="marca" id="marca" value="<?php echo $marca; ?>" required>
                </div>
                <div>
                    <label for="modelo">Modelo: </label>
                    <input type="text" name="modelo" id="modelo" value="<?php echo $modelo; ?>" required>
                </div>
                <div>
                    <label for="anio">Año:</label>
                    <input type="number" name="anio" id="anio" value="<?php echo $anio; ?>" required>
                </div>
                <div>
                    <label for="categoria">Categoría:</label>
                    <input type="text" name="categoria" id="categoria" value="<?php echo $categoria; ?>" required>
                </div>
                <div>
                    <label for="estado">Estado:</label>
                    <select name="estado" id="estado" required>
                        <option value="">Seleccionar</option>
                        <option value="disponible" <?php echo $estado === 'disponible' ? 'selected' : ''; ?>>Disponible</option>
                        <option value="alquilado" <?php echo $estado === 'alquilado' ? 'selected' : ''; ?>>Alquilado</option>
                        <option value="mantenimiento" <?php echo $estado === 'mantenimiento' ? 'selected' : ''; ?>>Mantenimiento</option>
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