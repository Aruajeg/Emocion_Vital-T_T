<?php
session_start();
if(!isset($_SESSION['usuario'])){
    echo '<script> 
        alert("Debes iniciar sesión para tener acceso a esta página");
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

// Solo mostrar citas con Status 'Activo'
$sql = "
SELECT 
    sc.ID_solicitud,
    p.Nombre_1 AS Paciente_Nombre,
    p.Apellido_1 AS Paciente_Apellido,
    ps.Nombre_1 AS Psicologo_Nombre,
    ps.Apellido_1 AS Psicologo_Apellido,
    sc.tipo_cita,
    sc.fecha_cita,
    sc.hora_cita,
    sc.descr_causa,
    sc.Status
FROM solicitar_cita sc
INNER JOIN paciente p ON sc.id_paciente = p.id_paciente
INNER JOIN psicologo ps ON sc.id_psicologo = ps.id_psicologo
WHERE sc.Status = 'Activo'
ORDER BY sc.fecha_cita DESC, sc.hora_cita DESC
";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consultar Citas</title>
    <link rel="stylesheet" href="/Style/gestioncita.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <h1 style="text-align:center; margin-top:30px;">Consultar Citas</h1>
    <div class="table-section">
        <h2>Listado de Citas</h2>
        <?php if ($result && $result->num_rows > 0): ?>
            <div class="table-container">
                <table class="table-citas">
                    <tr>
                        <th>ID Solicitud</th>
                        <th>Paciente</th>
                        <th>Psicólogo</th>
                        <th>Tipo de Cita</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Motivo</th>
                        <th>Status</th>
                        <th>Acciones</th>
                    </tr>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['ID_solicitud']) ?></td>
                            <td><?= htmlspecialchars($row['Paciente_Nombre'] . ' ' . $row['Paciente_Apellido']) ?></td>
                            <td><?= htmlspecialchars($row['Psicologo_Nombre'] . ' ' . $row['Psicologo_Apellido']) ?></td>
                            <td><?= htmlspecialchars($row['tipo_cita']) ?></td>
                            <td><?= htmlspecialchars($row['fecha_cita']) ?></td>
                            <td><?= htmlspecialchars($row['hora_cita']) ?></td>
                            <td><?= htmlspecialchars($row['descr_causa']) ?></td>
                            <td><?= htmlspecialchars($row['Status']) ?></td>
                            <td>
                                <a href="/php/modificarcita_paciente.php?id=<?= $row['ID_solicitud'] ?>" title="Modificar"><i class="fas fa-edit"></i></a>
                                <a href="/php/eliminarcita_paciente.php?id=<?= $row['ID_solicitud'] ?>" title="Eliminar" onclick="return confirm('¿Seguro que deseas eliminar esta cita?');"><i class="fas fa-trash-alt" style="color:#e74c3c;"></i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            </div>
        <?php else: ?>
            <div class="no-data">No hay citas agendadas.</div>
        <?php endif; ?>
        <a href="/php/dashboard_paciente.php" class="volver-inicio">
            <i class="fas fa-arrow-left"></i> Volver al inicio
        </a>
    </div>
    <?php $conn->close(); ?>
</body>
</html>