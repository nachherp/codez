<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../registro_adm/index.html');
    exit;
}

$correo = isset($_POST['correo']) ? trim($_POST['correo']) : '';
$contrasena = isset($_POST['contrasena']) ? trim($_POST['contrasena']) : '';

if ($correo === '' || $contrasena === '') {
    $_SESSION['error'] = 'Debes ingresar correo y contraseña.';
    header('Location: ../registro_adm/index.html');
    exit;
}

require_once './connection.php';

$sql = "SELECT id_administrador, nombre, apellido_paterno, apellido_materno, correo
        FROM administradores
        WHERE correo = ? AND contrasena = ?
        LIMIT 1";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    $_SESSION['error'] = 'No fue posible preparar la consulta de autenticación.';
    header('Location: ../registro_adm/index.html');
    exit;
}

$stmt->bind_param('ss', $correo, $contrasena);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows === 1) {
    $row = $result->fetch_assoc();

    $_SESSION['id_administrador'] = $row['id_administrador'];
    $_SESSION['nombre'] = $row['nombre'];
    $_SESSION['apellido_paterno'] = $row['apellido_paterno'];
    $_SESSION['apellido_materno'] = $row['apellido_materno'];
    $_SESSION['correo'] = $row['correo'];

    $stmt->close();
    $conn->close();

    header('Location: ../vista_admin/index.php');
    exit;
}

$stmt->close();
$conn->close();

$_SESSION['error'] = 'Correo o contraseña incorrectos.';
header('Location: ../registro_adm/index.html');
exit;
?>
