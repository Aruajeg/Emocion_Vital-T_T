<?php
session_start();
if(!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}

// Datos de conexión
$host = "localhost";
$user = "root";
$pass = "";
$db = "implantacion";

// Conexión a la base de datos
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

// Insertar en la base de datos
$sql = "INSERT INTO solicitar_cita (
    id_paciente, 
    id_psicologo, 
    tipo_cita, 
    tipo_consulta, 
    fecha_cita, 
    hora_cita, 
    descr_causa, 
    Status
) VALUES (
    '$id_paciente', 
    '$id_psicologo', 
    '$tipo_cita', 
    '$tipo_consulta', 
    '$fecha', 
    '$hora', 
    '$motivo', 
    'Activo'
)";

if ($conn->query($sql) === TRUE) {
    header("Location: ../php/dashboard_paciente.php?mensaje=Cita agendada exitosamente");
} else {
    header("Location: ../php/solicitarcita_paciente.php?mensaje=Error al agendar cita: " . $conn->error);
}

$conn->close();
?>