<?php
header('Content-Type: application/json');

$host = "localhost";
$user = "root";
$pass = "";
$db = "implantacion";
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die(json_encode([]));
}

$fecha = $conn->real_escape_string($_GET['fecha']);
$id_psicologo = $conn->real_escape_string($_GET['id_psicologo']);
$exclude_id = isset($_GET['exclude_id']) ? intval($_GET['exclude_id']) : 0;

$sql = "SELECT hora_cita FROM solicitar_cita 
        WHERE fecha_cita = '$fecha' 
        AND id_psicologo = '$id_psicologo'
        AND Status = 'Activo'";
        
if ($exclude_id > 0) {
    $sql .= " AND ID_solicitud != $exclude_id";
}

$result = $conn->query($sql);
$horariosOcupados = [];

while ($row = $result->fetch_assoc()) {
    $horariosOcupados[] = $row['hora_cita'];
}

echo json_encode($horariosOcupados);
$conn->close();
?>