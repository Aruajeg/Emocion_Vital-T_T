<?php
session_start();
if(!isset($_SESSION['usuario'])){
    echo '<script> 
        alert("Debes iniciar sesión para acceder a tu perfil");
        window.location = "index.php";
        </script>';
    session_destroy();
    die();
}

$host = "localhost";
$user = "root";
$pass = "";
$db = "implantacion";
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$username = $_SESSION['usuario'];

// Buscar usuario en la tabla usuario para obtener ID y cargo
$stmt = $conn->prepare("SELECT ID_usuario, ID_cargo, Correo FROM usuario WHERE Correo=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($id_usuario, $id_cargo, $correo);
$stmt->fetch();
$stmt->close();

// Obtener datos de usuario y descripción del cargo
$stmt = $conn->prepare("SELECT u.Username, u.Correo, u.Status, c.Descripcion FROM usuario u INNER JOIN cargo c ON u.ID_cargo = c.ID WHERE u.Correo=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($usuario_username, $usuario_correo, $usuario_status, $cargo_descripcion);
$stmt->fetch();
$stmt->close();

$datos_usuario = [
    'Usuario' => $usuario_username,
    'Correo' => $usuario_correo,
    'Cargo' => $cargo_descripcion
];

$datos = [];
$tipo = '';
if ($id_cargo == 1) { // Administrador
    $tipo = 'Administrador';
    $sql = "SELECT Nombre_1, Nombre_2, Apellido_1, Apellido_2, Correo, N_documento, Tipo_documento, Status FROM administrador WHERE Username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($n1, $n2, $a1, $a2, $correo, $ndoc, $tdoc, $status);
    if ($stmt->fetch()) {
        $datos = [
            'Nombre 1' => $n1,
            'Nombre 2' => $n2,
            'Apellido 1' => $a1,
            'Apellido 2' => $a2,
            'Correo' => $correo,
            'N° Documento' => $ndoc,
            'Tipo Documento' => $tdoc,
            'Status' => $status
        ];
    }
    $stmt->close();
} elseif ($id_cargo == 2) { // Paciente
    $tipo = 'Paciente';
    $sql = "SELECT Nombre_1, Nombre_2, Apellido_1, Apellido_2, Correo, Telefono, N_documento, Tipo_documento, Fecha_nacimiento, Status, Tipo_paciente, Sexo FROM paciente WHERE ID_usuario=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $stmt->bind_result($n1, $n2, $a1, $a2, $correo, $tel, $ndoc, $tdoc, $fnac, $status, $tipo_pac, $sexo);
    if ($stmt->fetch()) {
        $datos = [
            'Nombre 1' => $n1,
            'Nombre 2' => $n2,
            'Apellido 1' => $a1,
            'Apellido 2' => $a2,
            'Correo' => $correo,
            'Teléfono' => $tel,
            'N° Documento' => $ndoc,
            'Tipo Documento' => $tdoc,
            'Fecha Nacimiento' => $fnac,
            'Tipo Paciente' => $tipo_pac,
            'Sexo' => $sexo,
            'Status' => $status
        ];
    }
    $stmt->close();
} else { // Psicólogo (ID_cargo no definido en cargo, pero puedes ajustar si tienes más cargos)
    $tipo = 'Psicólogo';
    $sql = "SELECT Nombre_1, Nombre_2, Apellido_1, Apellido_2, Correo, Telefono, N_documento, Tipo_documento, Status FROM psicologo WHERE ID_usuario=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $stmt->bind_result($n1, $n2, $a1, $a2, $correo, $tel, $ndoc, $tdoc, $status);
    if ($stmt->fetch()) {
        $datos = [
            'Nombre 1' => $n1,
            'Nombre 2' => $n2,
            'Apellido 1' => $a1,
            'Apellido 2' => $a2,
            'Correo' => $correo,
            'Teléfono' => $tel,
            'N° Documento' => $ndoc,
            'Tipo Documento' => $tdoc,
            'Status' => $status
        ];
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>Perfil de Usuario</title>
    <link href="/Style/styles_dashboard.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Perfil de Usuario</h2>
        <div class="card" style="max-width:500px;">
            <div class="card-header bg-primary text-white">
                <?= htmlspecialchars($tipo) ?>
            </div>
            <div class="card-body">
                <h5>Datos de Usuario</h5>
                <ul class="list-group list-group-flush mb-3">
                    <?php foreach($datos_usuario as $campo => $valor): ?>
                        <li class="list-group-item"><strong><?= htmlspecialchars($campo) ?>:</strong> <?= htmlspecialchars($valor) ?></li>
                    <?php endforeach; ?>
                </ul>
                <!-- Se eliminó el apartado de Datos Personales -->
            </div>
        </div>
        <a href="dashboard.php" class="btn btn-secondary mt-4">Volver al Dashboard</a>
    </div>
</body>
</html>

</body>
</html>
