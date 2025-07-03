<?php
session_start();
if(!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}

// Verificar que el id_usuario está en la sesión
if(!isset($_SESSION['id_usuario'])) {
    die("Error: No se encontró el ID de usuario en la sesión");
}
$id_usuario = $_SESSION['id_usuario'];

// Conexión a la base de datos
$host = "localhost";
$user = "root";
$pass = "";
$db = "implantacion";
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Recibir y sanitizar datos del formulario
$id_paciente = $conn->real_escape_string($_POST['id_paciente']);
$id_psicologo = $conn->real_escape_string($_POST['id_psicologo']);
$tipo_cita = $conn->real_escape_string($_POST['tipo_cita']);
$tipo_consulta = $conn->real_escape_string($_POST['tipo_consulta']);
$fecha = $conn->real_escape_string($_POST['fecha']);
$hora = $conn->real_escape_string($_POST['hora']);
$motivo = $conn->real_escape_string($_POST['motivo']);

// Validar que el tipo de consulta sea uno de los valores permitidos
$tipos_permitidos = ['Adulto', 'Adolescente', 'Infante', 'Pareja'];
if(!in_array($tipo_consulta, $tipos_permitidos)) {
    header("Location: ../php/solicitarcita_paciente.php?mensaje=Tipo de consulta no válido");
    exit();
}

// Validar que el paciente pertenece al usuario actual (seguridad adicional)
$stmt_verificar = $conn->prepare("SELECT id_paciente FROM paciente WHERE id_paciente = ? AND id_usuario = ?");
$stmt_verificar->bind_param("ii", $id_paciente, $id_usuario);
$stmt_verificar->execute();
$stmt_verificar->store_result();

if($stmt_verificar->num_rows === 0) {
    header("Location: ../php/solicitarcita_paciente.php?mensaje=Paciente no válido");
    exit();
}
$stmt_verificar->close();

// Insertar en la base de datos con consulta preparada
$sql = "INSERT INTO solicitar_cita (
    id_paciente, 
    id_psicologo, 
    tipo_cita, 
    tipo_consulta, 
    fecha_cita, 
    hora_cita, 
    descr_causa, 
    Status,
    ID_usuario
) VALUES (?, ?, ?, ?, ?, ?, ?, 'Activo', ?)";

$stmt = $conn->prepare($sql);
if($stmt === false) {
    die("Error en la preparación de la consulta: " . $conn->error);
}

$stmt->bind_param("iisssssi", 
    $id_paciente, 
    $id_psicologo, 
    $tipo_cita, 
    $tipo_consulta,
    $fecha, 
    $hora, 
    $motivo,
    $id_usuario
);

if($stmt->execute()) {
    header("Location: ../php/dashboard_paciente.php?mensaje=Cita agendada exitosamente");
} else {
    error_log("Error al agendar cita: " . $stmt->error);
    header("Location: ../php/solicitarcita_paciente.php?mensaje=Error al agendar cita");
}

$stmt->close();
$conn->close();
?>