<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "implantacion";
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Validaciones básicas
function validar_numero($numero) {
    return preg_match("/^[0-9]+$/", $numero);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_paciente = trim($_POST["id_paciente"]);
    $id_psicologo = trim($_POST["id_psicologo"]);
    $tipo_cita = trim($_POST["tipo_cita"]);
    $fecha_cita = trim($_POST["fecha"]);
    $hora_cita = trim($_POST["hora"]);
    $descr_causa = trim($_POST["motivo"]);

    // Validaciones
    if (
        !validar_numero($id_paciente) ||
        !validar_numero($id_psicologo) ||
        !in_array($tipo_cita, ['ONLINE', 'PRESENCIAL']) ||
        !preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha_cita) ||
        !preg_match('/^\d{2}:\d{2}$/', $hora_cita) ||
        strlen($descr_causa) < 5 || strlen($descr_causa) > 255
    ) {
        $mensaje = urlencode("Datos inválidos. Verifique los campos e intente de nuevo.");
        header("Location: solicitarcita_paciente.php?mensaje=$mensaje");
        exit();
    }

    // Escapar para SQL
    $id_paciente = $conn->real_escape_string($id_paciente);
    $id_psicologo = $conn->real_escape_string($id_psicologo);
    $tipo_cita = $conn->real_escape_string($tipo_cita);
    $fecha_cita = $conn->real_escape_string($fecha_cita);
    $hora_cita = $conn->real_escape_string($hora_cita);
    $descr_causa = $conn->real_escape_string($descr_causa);

    // Status por defecto: ACTIVO (pendiente)
    $status = "ACTIVO";

    $sql = "INSERT INTO solicitar_cita 
        (id_paciente, id_psicologo, tipo_cita, fecha_cita, hora_cita, descr_causa, Status)
        VALUES 
        ('$id_paciente', '$id_psicologo', '$tipo_cita', '$fecha_cita', '$hora_cita', '$descr_causa', '$status')";
    if ($conn->query($sql) === TRUE) {
        header("Location: /php/dashboard_paciente.php?mensaje=" . urlencode("Cita agendada correctamente."));
        exit();
    } else {
        $mensaje = urlencode("Error: " . $conn->error);
        header("Location: /php/solicitarcita_paciente.php?mensaje=$mensaje");
        exit();
    }
}
?>