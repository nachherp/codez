<?php
session_start();
include('../../connection/connection.php');

$filter_date = isset($_POST['filter_date']) ? $_POST['filter_date'] : '';
$filter_estado = isset($_POST['filter_estado']) ? $_POST['filter_estado'] : '';

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
    <title>Denthub Admin | Agenda</title>
    <link rel="stylesheet" href="../../style/normalize.css">
    <link rel="stylesheet" href="../admin-ui.css">
</head>
<body>
<header class="topbar">
    <div class="topbar-inner">
        <a class="logo" href="../../index.html"><img src="../../img/logo.png" alt="Denthub"></a>
        <ul class="nav-links">
            <li><a href="../index.php">Dashboard</a></li>
            <li><a class="active" href="#">Agenda</a></li>
            <li><a href="../pacientes/index.php">Pacientes</a></li>
            <li><a href="../control_de_pagos/index.php">Pagos</a></li>
        </ul>
    </div>
</header>

<main class="page">
    <section class="panel">
        <div class="panel-header">
            <div>
                <h2>Administrar citas</h2>
                <p>Filtra por fecha y estado para priorizar tareas clínicas.</p>
            </div>
        </div>

        <form method="post" class="filters" aria-label="Filtros de citas">
            <div class="field">
                <label for="filter_date">Fecha</label>
                <input type="date" name="filter_date" id="filter_date" value="<?= htmlspecialchars($filter_date) ?>">
            </div>
            <div class="field">
                <label for="filter_estado">Estado</label>
                <select name="filter_estado" id="filter_estado">
                    <option value="">Todos</option>
                    <option value="Pendiente" <?= $filter_estado == 'Pendiente' ? 'selected' : '' ?>>Pendiente</option>
                    <option value="Pagado" <?= $filter_estado == 'Pagado' ? 'selected' : '' ?>>Pagado</option>
                </select>
            </div>
            <div class="field" style="align-self:flex-end;">
                <button type="submit" class="btn">Filtrar</button>
            </div>
        </form>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Motivo</th>
                        <th>Comentarios</th>
                        <th>Monto total</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()):
                        $fecha_hora = new DateTime($row['fecha_hora']); ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nombre']) ?></td>
                            <td><?= htmlspecialchars($row['telefono']) ?></td>
                            <td><?= $fecha_hora->format('Y-m-d') ?></td>
                            <td><?= $fecha_hora->format('H:i') ?></td>
                            <td><?= htmlspecialchars($row['motivo']) ?></td>
                            <td><?= htmlspecialchars($row['comentarios']) ?></td>
                            <td><?= htmlspecialchars($row['monto_total']) ?></td>
                            <td>
                                <span class="badge <?= $row['estado'] === 'Pagado' ? 'success' : 'warning' ?>">
                                    <?= htmlspecialchars($row['estado']) ?>
                                </span>
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="../control_de_pagos/registrar_pago.php?id_cita=<?= $row['id_cita'] ?>" class="btn ghost">Registrar pago</a>
                                    <?php if ($row['monto_total'] === 'No asignado'): ?>
                                        <form action="eliminar_cita.php" method="post">
                                            <input type="hidden" name="id_cita" value="<?= $row['id_cita'] ?>">
                                            <button type="submit" class="btn danger">Cancelar</button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="9">No hay citas para los filtros seleccionados.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

<footer class="footer">
    <p>&copy; 2026 Denthub. Plataforma de gestión dental.</p>
</footer>
</body>
</html>

<?php
$result->free();
$conn->close();
?>
