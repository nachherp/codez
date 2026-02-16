<?php
session_start();
include('../../connection/connection.php');

$sql = "SELECT id_paciente, nombre, apellido_paterno, apellido_materno, fecha_nacimiento, telefono, correo FROM pacientes ORDER BY nombre ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Denthub Admin | Pacientes</title>
    <link rel="stylesheet" href="../../style/normalize.css">
    <link rel="stylesheet" href="../admin-ui.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>
<header class="topbar">
    <div class="topbar-inner">
        <a class="logo" href="../../index.html"><img src="../../img/logo.png" alt="Denthub"></a>
        <ul class="nav-links">
            <li><a href="../index.php">Dashboard</a></li>
            <li><a href="../calendario_admin/index.php">Agenda</a></li>
            <li><a class="active" href="#">Pacientes</a></li>
            <li><a href="../control_de_pagos/index.php">Pagos</a></li>
        </ul>
        <div class="icon-links">
            <a href="../../registro_usr/index.html" title="Perfil"><img src="../../img/usuario (1).png" alt="Perfil"></a>
            <a href="https://www.google.com.mx/maps/preview" title="Ubicación"><img src="../../img/marcador (2).png" alt="Ubicación"></a>
            <a href="../../index.html" title="Inicio"><img src="../../img/hogar (2).png" alt="Inicio"></a>
        </div>
    </div>
</header>

<main class="page">
    <section class="panel">
        <div class="panel-header">
            <div>
                <h2>Gestión de pacientes</h2>
                <p>Accede a perfiles clínicos y mantén la base organizada.</p>
            </div>
            <span class="badge success">Total: <?= (int)$result->num_rows ?></span>
        </div>

        <?php if ($result->num_rows > 0): ?>
            <div class="table-wrap">
                <table>
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Fecha de nacimiento</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nombre']) . ' ' . htmlspecialchars($row['apellido_paterno']) . ' ' . htmlspecialchars($row['apellido_materno']) ?></td>
                            <td><?= htmlspecialchars($row['fecha_nacimiento']) ?></td>
                            <td><?= htmlspecialchars($row['telefono']) ?></td>
                            <td><?= htmlspecialchars($row['correo']) ?></td>
                            <td>
                                <div class="actions">
                                    <a href="../pacientes/perfil_pac/index.php?id_paciente=<?= $row['id_paciente'] ?>" class="btn ghost">Ver perfil</a>
                                    <a href="eliminar_paciente.php?id_paciente=<?= $row['id_paciente'] ?>" class="btn danger">Eliminar</a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <strong>No se encontraron pacientes.</strong>
                <p>Registra pacientes desde el flujo de alta para iniciar su historial.</p>
            </div>
        <?php endif; ?>
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
