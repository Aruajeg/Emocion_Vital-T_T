<?php
// filepath: c:\Users\Angelo\Documents\GitHub\Emocion_Vital-T_T\Emoción Vital\php\eliminarcita.php

session_start();
if(!isset($_SESSION['usuario'])){
    header("Location: ../index.php");
    exit;
}

if(isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $conn = new mysqli("localhost", "root", "", "implantacion");
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }
    // Cambia el Status a 'INACTIVO' para el ID indicado
    $stmt = $conn->prepare("UPDATE solicitar_cita SET Status = 'INACTIVO' WHERE ID_solicitud = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}
header("Location: /php/consultarcitas_paciente.php");
exit;
?>