<?php
session_start();
include('../../connection/connection.php');

$filter_date = isset($_POST['filter_date']) ? $_POST['filter_date'] : '';
$filter_estado = isset($_POST['filter_estado']) ? $_POST['filter_estado'] : '';

// Consulta para obtener todas las citas junto con la información de los pacientes
$sql = "SELECT citas.id_cita, pacientes.nombre, pacientes.telefono, citas.fecha_hora, citas.motivo, citas.comentarios, 
               IFNULL(pagos.monto_total, 'No asignado') as monto_total, 
               IF(pagos.monto_total IS NULL, 'Pendiente', 'Pagado') as estado
        FROM citas
        INNER JOIN pacientes ON citas.id_paciente = pacientes.id_paciente
        LEFT JOIN pagos ON citas.id_cita = pagos.id_cita
        WHERE 1=1";

if ($filter_date) {
    $sql .= " AND DATE(citas.fecha_hora) = '$filter_date'";
}

if ($filter_estado) {
    $sql .= " AND IF(pagos.monto_total IS NULL, 'Pendiente', 'Pagado') = '$filter_estado'";
}

$sql .= " ORDER BY citas.fecha_hora ASC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Citas</title>
    <link rel="stylesheet" href="../../vista_cliente/administrar_cita/style.css">
</head>

<body>
    <header>
        <nav>
            <div class="arriba">
                <a class="navbar-brand" href="#">
                    <img src="../../img/logo.png" width="100" height="50" alt="">
                </a>
                <div class="navbar_items">
                    <li><a href="../index.php">Home</a></li>
                    <li><a href="#">Mis citas</a></li>
                    <li><a href="../pacientes/index.php">Pacientes</a></li>
                    <li><a href="../control_de_pagos/index.php">Control de pagos</a></li>
        
                    <div class="contenedor_icons">
                        <a class="navbar-brand" href="../registro/index.html">
                            <img src="../../img/usuario (1).png" alt="" width="30" height="24">
                        </a>
                        <a class="navbar-brand" href="https://www.google.com.mx/maps/preview">
                            <img src="../../img/marcador (2).png" alt="" width="30" height="24">
                        </a>
                        <a class="navbar-brand" href="#">
                            <img src="../../img/hogar (2).png" alt="" width="30" height="24">
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <div class="xd">
        <h1>Administrar Citas</h1>
    </div>
    <main>
        <section class="appointment-list">
            <h2>Todas las Citas</h2>
            <form method="post" class="filter-form">
                <label for="filter_date">Fecha:</label>
                <input type="date" name="filter_date" id="filter_date" value="<?= htmlspecialchars($filter_date) ?>">
                <label for="filter_estado">Estado:</label>
                <select name="filter_estado" id="filter_estado">
                    <option value="">Todos</option>
                    <option value="Pendiente" <?= $filter_estado == 'Pendiente' ? 'selected' : '' ?>>Pendiente</option>
                    <option value="Pagado" <?= $filter_estado == 'Pagado' ? 'selected' : '' ?>>Pagado</option>
                </select>
                <button type="submit" class="btn-primary">Filtrar</button>
            </form>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Motivo</th>
                        <th>Comentarios</th>
                        <th>Monto Total</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): 
                        $fecha_hora = new DateTime($row['fecha_hora']);
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nombre']) ?></td>
                        <td><?= htmlspecialchars($row['telefono']) ?></td>
                        <td><?= $fecha_hora->format('Y-m-d') ?></td>
                        <td><?= $fecha_hora->format('H:i') ?></td>
                        <td><?= htmlspecialchars($row['motivo']) ?></td>
                        <td><?= htmlspecialchars($row['comentarios']) ?></td>
                        <td><?= htmlspecialchars($row['monto_total']) ?></td>
                        <td><?= htmlspecialchars($row['estado']) ?></td>
                        <td>
                            <a href="../control_de_pagos/registrar_pago.php?id_cita=<?= $row['id_cita'] ?>" class="btn-primary">Registrar Pago</a>
                            <?php if ($row['monto_total'] === 'No asignado'): ?>
                                <form action="eliminar_cita.php" method="post" style="display:inline;">
                                    <input type="hidden" name="id_cita" value="<?= $row['id_cita'] ?>">
                                    <button type="submit" class="btn btn-danger">Cancelar</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>
    </main>
    <footer class="bg_footer">
        <div class="footer-container">
            <ul>
                <li><a href="#aviso-privacidad">Aviso de privacidad</a></li>
                <li><a href="#terminos-y-condiciones">Términos y condiciones</a></li>
                <li><a href="#mapa-de-sitio">Mapa de sitio</a></li>
            </ul>
            <p>&copy; 2023 Dentavida. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>

</html>

<?php
$result->free();
$conn->close();
?>

