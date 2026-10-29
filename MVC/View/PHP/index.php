<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Retravehiculos
  </title>
  <link rel="shortcut icon" href="../../public/images/logo.png" type="image/x-icon">
  <link rel="stylesheet" href="../../public/css/base.css">
  <link rel="stylesheet" href="../../public/css/menu.css">
  <link rel="stylesheet" href="../../public/css/index.css">
</head>

<body>
  <nav class="menu">
    <div class="menu-item logo">
      <a href="index.php">
        <img src="../../public/images/logo.png" alt="Logo">
      </a>
    </div>
    <div class="menu-item">
      <a href="#vehiculos">
        Vehiculos
      </a>
    </div>
    <div class="menu-item">
      <a href="#clientes">
        Clientes
      </a>
    </div>
    <div class="menu-item">
      <a href="#reservas">
        Reservas
      </a>
    </div>
    <div class="menu-item">
      <a href="#devoluciones">
        Devoluciones
      </a>
    </div>
    <div class="menu-item">
      <a href="#historial">
        Historial
      </a>
    </div>
    <div class="menu-item">
      <a href="#disponibilidad">
        Disponibilidad
      </a>
    </div>
  </nav>
  <main class="main-page">
    <div class="hero">
      <h1>Tu flota, reservas y devoluciones en un solo lugar</h1>
      <p>
        Consulta qué vehículos están libres, registra una reserva en minutos
        y evita cruces de fechas.
      </p>
    </div>

    <div class="menu-cards">
      <a id="vehiculos" class="menu-card" href="vehiculos.php">
        <h2>Administrar Vehículos</h2>
        <p>Registra la flota con marca, modelo, categoría y estado.</p>
      </a>
      <a id="clientes" class="menu-card" href="clientes.php">
        <h2>Administrar Clientes</h2>
        <p>Guarda los datos de contacto y la licencia de cada cliente.</p>
      </a>
      <a id="reservas" class="menu-card" href="reservas.php">
        <h2>Crear Reservas</h2>
        <p>Registra nuevas reservas y gestiona las existentes.</p>
      </a>
      <a id="devoluciones" class="menu-card" href="devoluciones.php">
        <h2>Recibir Devoluciones</h2>
        <p>Registra la entrega y actualiza el estado del vehículo.</p>
      </a>
      <a id="historial" class="menu-card" href="historial.php">
        <h2>Ver Historial</h2>
        <p>Consulta el historial de reservas y devoluciones.</p>
      </a>
      <a id="disponibilidad" class="menu-card" href="disponibilidad.php">
        <h2>Ver Disponibilidad</h2>
        <p>Consulta la disponibilidad de vehículos en cualquier momento.</p>
      </a>
    </div>
  </main>
</body>

</html>