<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../php/login.php?mensaje=Debes iniciar sesión para registrar pacientes");
    exit();
}

// Conexión a la base de datos
$host = "localhost";
$user = "root";
$pass = "";
$db = "implantacion";
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Recoger datos del formulario
$nombre1 = $conn->real_escape_string($_POST['nombre1']);
$nombre2 = $conn->real_escape_string($_POST['nombre2']);
$apellido1 = $conn->real_escape_string($_POST['apellido1']);
$apellido2 = $conn->real_escape_string($_POST['apellido2']);
$correo = $conn->real_escape_string($_POST['correo']);
$telefono = $conn->real_escape_string($_POST['telefono']);
$n_documento = $conn->real_escape_string($_POST['n_documento']);
$tipo_documento = $conn->real_escape_string($_POST['tipo_documento']);
$fecha_nacimiento = $conn->real_escape_string($_POST['fecha_nacimiento']);
$sexo = $conn->real_escape_string($_POST['sexo']);
$desc_paciente = $conn->real_escape_string($_POST['desc_paciente']);
$id_usuario = $_SESSION['id_usuario']; // Obtenemos el ID de la sesión

// Validación básica
if(empty($nombre1) || empty($apellido1) || empty($n_documento)) {
    header("Location: ../registrarpaciente_paciente.php?mensaje=Los campos marcados con * son obligatorios");
    exit();
}

// Insertar en la base de datos
$sql = "INSERT INTO paciente (Nombre_1, Nombre_2, Apellido_1, Apellido_2, Correo, Telefono, N_documento, Tipo_documento, Fecha_nacimiento, Sexo, desc_paciente, ID_usuario) 
        VALUES ('$nombre1', '$nombre2', '$apellido1', '$apellido2', '$correo', '$telefono', '$n_documento', '$tipo_documento', '$fecha_nacimiento', '$sexo', '$desc_paciente', '$id_usuario')";

if ($conn->query($sql) === TRUE) {
    // Redirección a dashboard.php después de registro exitoso
    header("Location: ../php/dashboard.php?mensaje=Paciente registrado exitosamente");
} else {
    header("Location: ../php/registrarpaciente.php?mensaje=Error al registrar paciente: " . $conn->error);
}

$conn->close();
?>