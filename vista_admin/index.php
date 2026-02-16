<?php
session_start();
include('../connection/connection.php');

$id_administrador = $_SESSION['id_administrador'];

$stmt = $conn->prepare("SELECT nombre, apellido_paterno, apellido_materno, correo, telefono FROM administradores WHERE id_administrador = ?");
$stmt->bind_param("i", $id_administrador);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $admin = $result->fetch_assoc();
} else {
    echo "No se encontraron datos del administrador.";
    exit();
}
$stmt->close();

$citas_stmt = $conn->prepare("SELECT c.fecha_hora, c.motivo, p.nombre AS paciente_nombre, p.apellido_paterno AS paciente_apellido
    FROM citas c
    JOIN pacientes p ON c.id_paciente = p.id_paciente
    WHERE c.estado = 'Pendiente'
    ORDER BY c.fecha_hora
    LIMIT 5");
$citas_stmt->execute();
$citas_result = $citas_stmt->get_result();

$citas = [];
while ($row = $citas_result->fetch_assoc()) {
    $citas[] = $row;
}
$citas_stmt->close();

$totalPacientes = $conn->query("SELECT COUNT(*) AS total FROM pacientes")->fetch_assoc()['total'];
$totalCitasHoy = $conn->query("SELECT COUNT(*) AS total FROM citas WHERE DATE(fecha_hora) = CURDATE()")->fetch_assoc()['total'];
$totalPendientes = $conn->query("SELECT COUNT(*) AS total FROM citas WHERE estado = 'Pendiente'")->fetch_assoc()['total'];
$totalPagadoMes = $conn->query("SELECT IFNULL(SUM(monto_total), 0) AS total FROM pagos WHERE MONTH(fecha_pago) = MONTH(CURDATE()) AND YEAR(fecha_pago) = YEAR(CURDATE())")->fetch_assoc()['total'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Denthub Admin | Dashboard</title>
    <link rel="stylesheet" href="../style/normalize.css">
    <link rel="stylesheet" href="./admin-ui.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>
<header class="topbar">
    <div class="topbar-inner">
        <a class="logo" href="../index.html"><img src="../img/logo.png" alt="Denthub"></a>
        <ul class="nav-links">
            <li><a class="active" href="./index.php">Dashboard</a></li>
            <li><a href="./calendario_admin/index.php">Agenda</a></li>
            <li><a href="./pacientes/index.php">Pacientes</a></li>
            <li><a href="./control_de_pagos/index.php">Pagos</a></li>
        </ul>
        <div class="icon-links" aria-label="Acciones rápidas">
            <a href="../registro_usr/index.html" title="Perfil"><img src="../img/usuario (1).png" alt="Perfil"></a>
            <a href="https://www.google.com.mx/maps/preview" title="Ubicación"><img src="../img/marcador (2).png" alt="Ubicación"></a>
            <a href="../index.html" title="Inicio"><img src="../img/hogar (2).png" alt="Inicio"></a>
        </div>
    </div>
</header>

<main class="page">
    <section class="hero">
        <h1>Hola, <?= htmlspecialchars($admin['nombre']) ?>. Panel operativo de clínica</h1>
        <p>Supervisa agenda, pacientes y pagos desde una vista clara para reducir tiempos de operación en recepción y dirección administrativa.</p>
    </section>

    <section class="kpi-grid" aria-label="Indicadores clave">
        <article class="kpi-card"><h2><?= htmlspecialchars($totalPacientes) ?></h2><p>Pacientes registrados</p></article>
        <article class="kpi-card"><h2><?= htmlspecialchars($totalCitasHoy) ?></h2><p>Citas para hoy</p></article>
        <article class="kpi-card"><h2><?= htmlspecialchars($totalPendientes) ?></h2><p>Citas pendientes</p></article>
        <article class="kpi-card"><h2>$<?= number_format((float)$totalPagadoMes, 2) ?></h2><p>Ingresos del mes</p></article>
    </section>

    <section class="panel">
        <div class="panel-header">
            <div>
                <h2>Próximas acciones</h2>
                <p>Listado de pendientes próximos para actuar rápido.</p>
            </div>
            <a class="btn ghost" href="./calendario_admin/index.php">Ver agenda completa</a>
        </div>

        <?php if (count($citas) > 0): ?>
            <div class="table-wrap">
                <table>
                    <thead>
                    <tr>
                        <th>Paciente</th>
                        <th>Fecha y hora</th>
                        <th>Motivo</th>
                        <th>Estado</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($citas as $cita): ?>
                        <tr>
                            <td><?= htmlspecialchars($cita['paciente_nombre']) . ' ' . htmlspecialchars($cita['paciente_apellido']) ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($cita['fecha_hora'])) ?></td>
                            <td><?= htmlspecialchars($cita['motivo']) ?></td>
                            <td><span class="badge warning">Pendiente</span></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <strong>Sin pendientes por ahora.</strong>
                <p>No hay citas marcadas como pendientes.</p>
            </div>
        <?php endif; ?>
    </section>
</main>

<footer class="footer">
    <p>&copy; 2026 Denthub. Plataforma de gestión dental.</p>
</footer>
</body>
</html>
