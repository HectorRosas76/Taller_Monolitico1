<?php

$controller = ControllersConfig :: get_vehicles_controller();
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
            <a href="devoluciones.php">
                Devoluciones
            </a>
        </div>
        <div class="menu-item">
            <a href="historial.php">
                Historial
            </a>
        </div>
        <div class="menu-item">
            <a href="disponibilidad.php">
                Disponibilidad
            </a>
        </div>
    </nav>

    <div class="page-container">
        <section>
            <h2>Registrar Vehículo</h2>
            <a href="../actions/create/register_vehicles.php">
                Registrar Vehículo
            </a>
        </section>
        <section class="list-controls">
            <form method="get" action="" class="search-form">
                <input type="text" name="search" placeholder="Buscar por nombre..." value="">
                <button type="submit">Buscar</button>
            </form>
        </section>

        <section class="table-panel">
            <h2>Lista de Vehiculos</h2>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Telefono</th>
                            <th>Correo</th>
                            <th>N° Licencia</th>
                            <th>Fecha inicio</th>
                            <th>Fecha fin</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <!-- <?php if (count() === 0): 
                          echo '  <td colspan="5"> No hay vehiculos registrados. </td>';
                        endif; ?> -->
                        </tr>
                        <?php
                        foreach ($list as $item) {
                            $id = $item->get_id();
                            echo '<div class="tarjeta">';
                            echo '    <p> ';
                            echo '        <b>Codigo: </b><span>' . $item->get_code() . '</span> ';
                            echo '    </p>';
                            echo '    <p> ';
                            echo '        <b>Marca: </b><span>' . $item->get_marca() . '</span> ';
                            echo '    </p>';
                            echo '    <p> ';
                            echo '        <b>Email: </b><span>' . $item->get_model() . '</span> ';
                            echo '    </p>';
                            echo '    <p> ';
                            echo '        <b>Licencia: </b><span>' . $item->get_anio() . '</span> ';
                            echo '    </p>';
                            echo '    <p> ';
                            echo '        <b>Categoria: </b><span>' . $item->get_categoria() . '</span> ';
                            echo '    </p>';
                            echo '    <p> ';
                            echo '        <b>Estado: </b><span>' . $item->get_estado() . '</span> ';
                            echo '    </p>';
                            echo '    <p> ';
                            echo '        <b>Fecha inicio: </b><span>' . $item->get_start_date() . '</span> ';
                            echo '    </p>';
                            echo '    <p> ';
                            echo '        <b>Fecha fin: </b><span>' . $item->get_end_date() . '</span> ';
                            echo '    </p>';
                            echo '    <div>';
                            echo '        <a href="#">Borrar</a>';
                            echo '        <a href="formularioVehiculos.php?id=' . $id . '">Modificar</a>';
                            echo '    </div>';
                            echo '</div>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</body>

</html>