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
        <header class="page-header">
            <h1>Gestión de Vehiculos</h1>
            <p>Busca, crea, edita y elimina vehiculos con datos completos y adecuados.</p>
        </header>

        <section class="list-controls">
            <form method="get" action="sprints.php" class="search-form">
                <input type="text" name="search" placeholder="Buscar por nombre..." value="">
                <button type="submit">Buscar</button>
            </form>
            <div class="list-summary">

        </section>

        <section class="form-panel">
            <h2></h2>
            <form method="post" action="sprints.php" class="crud-form">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="id" value="">
                <input type="hidden" name="action" value="create">
                <input type="hidden" name="search" value="">
                <input type="hidden" name="page" value="">

                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" required value="">

                <label for="fecha_inicio">Fecha inicio</label>
                <input type="date" id="fecha_inicio" name="fecha_inicio" required value="">

                <label for="fecha_fin">Fecha fin</label>
                <input type="date" id="fecha_fin" name="fecha_fin" required value="">

                <div class="form-actions">
                    <button type="submit"></button>
                    <a class="secondary-link" href="sprints.php">Cancelar</a>
                </div>
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
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="5">No hay vehiculos registrados.</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="actions">
                                <a class="action-link" href="sprints.php?edit_id=&page=">Editar</a>
                                <form method="post" action="sprints.php" class="inline-form" onsubmit="return confirm('¿Eliminar este sprint?');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="">
                                    <input type="hidden" name="search" value="">
                                    <input type="hidden" name="page" value="">
                                    <button type="submit">Eliminar</button>
                                </form>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>


            <div class="pagination">
                <a href="sprints.php?page=">« Anterior</a>
                <span>Página de</span>
                <a href="sprints.php?page=">Siguiente »</a>
            </div>
        </section>
    </div>
</body>

</html>