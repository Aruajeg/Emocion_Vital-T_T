<?php
session_start();
if(!isset($_SESSION['usuario'])){
    echo '<div class="alert alert-danger">No autenticado.</div>';
    exit;
}

$host = "localhost";
$user = "root";
$pass = "";
$db = "implantacion";
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    echo '<div class="alert alert-danger">Error de conexión.</div>';
    exit;
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

// Estilo inspirado en el dashboard
?>
<style>
.perfil-card {
    background: rgba(22, 74, 65, 0.6); /* verde oscuro translúcido */
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    padding: 28px 24px 18px 24px;
    max-width: 420px;
    margin: 0 auto;
}
.perfil-card .perfil-header {
    background: transparent;
    color: #f1b24a; /* amarillo */
    border-radius: 8px 8px 0 0;
    padding: 14px 20px;
    margin: -28px -24px 20px -24px;
    font-size: 1.25rem;
    font-weight: bold;
    letter-spacing: 1px;
    text-align: center;
    border-bottom: 4px solid #f1b24a;
}
.perfil-card .list-group-item {
    background: transparent;
    border: none;
    border-bottom: 1px solid #f1b24a;
    font-size: 1.08rem;
    padding-left: 0;
    padding-right: 0;
    color: #fff;
}
.perfil-card .list-group-item strong {
    color: #f1b24a;
}
.perfil-card .list-group-item:last-child {
    border-bottom: none;
}
</style>
<div class="perfil-card">
    <div class="perfil-header">
        <i class="fas fa-user-circle me-2"></i>Perfil de Usuario
    </div>
    <ul class="list-group list-group-flush mb-2">
        <?php foreach($datos_usuario as $campo => $valor): ?>
            <li class="list-group-item"><strong><?= htmlspecialchars($campo) ?>:</strong> <?= htmlspecialchars($valor) ?></li>
        <?php endforeach; ?>
    </ul>
</div>
