<?php
session_start();
include('../../connection/connection.php');

$sql = "SELECT citas.id_cita, pacientes.nombre, pacientes.apellido_paterno, citas.fecha_hora, citas.motivo,
               IFNULL(pagos.monto_total, 'Pendiente') as monto_total,
               IF(pagos.monto_total IS NOT NULL, 'Pagado', 'Pendiente') as estado_pago
        FROM citas
        INNER JOIN pacientes ON citas.id_paciente = pacientes.id_paciente
        LEFT JOIN pagos ON citas.id_cita = pagos.id_cita
        ORDER BY citas.fecha_hora DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Denthub Admin | Pagos</title>
    <link rel="stylesheet" href="../../style/normalize.css">
    <link rel="stylesheet" href="../admin-ui.css">
</head>
<body>
<header class="topbar">
    <div class="topbar-inner">
        <a class="logo" href="../../index.html"><img src="../../img/logo.png" alt="Denthub"></a>
        <ul class="nav-links">
            <li><a href="../index.php">Dashboard</a></li>
            <li><a href="../calendario_admin/index.php">Agenda</a></li>
            <li><a href="../pacientes/index.php">Pacientes</a></li>
            <li><a class="active" href="#">Pagos</a></li>
        </ul>
    </div>
</header>

<main class="page">
    <section class="panel">
        <div class="panel-header">
            <div>
                <h2>Control de pagos</h2>
                <p>Visualiza cobros por cita y registra pagos pendientes rápidamente.</p>
            </div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Paciente</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Motivo</th>
                        <th>Monto total</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()):
                        $fecha_hora = new DateTime($row['fecha_hora']); ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nombre']) . ' ' . htmlspecialchars($row['apellido_paterno']) ?></td>
                            <td><?= $fecha_hora->format('Y-m-d') ?></td>
                            <td><?= $fecha_hora->format('H:i') ?></td>
                            <td><?= htmlspecialchars($row['motivo']) ?></td>
                            <td><?= htmlspecialchars($row['monto_total']) ?></td>
                            <td>
                                <span class="badge <?= $row['estado_pago'] === 'Pagado' ? 'success' : 'warning' ?>">
                                    <?= htmlspecialchars($row['estado_pago']) ?>
                                </span>
                            </td>
                            <td><a class="btn ghost" href="registrar_pago.php?id_cita=<?= $row['id_cita'] ?>">Registrar pago</a></td>
                        </tr>
                    <?php endwhile; ?>
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
$conn->close();
?>
