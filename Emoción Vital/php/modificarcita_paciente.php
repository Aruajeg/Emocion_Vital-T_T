<?php
// filepath: c:\Users\Angelo\Documents\GitHub\Emocion_Vital-T_T\Emoción Vital\php\modificarcita.php
session_start();
if(!isset($_SESSION['usuario'])){
    header("Location: ../index.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "implantacion");
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$cita = null;
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Procesar modificación
if(isset($_POST['modificar'])) {
    $tipo_cita = isset($_POST['tipo_cita']) ? $_POST['tipo_cita'] : '';
    $fecha = isset($_POST['fecha_cita']) ? $_POST['fecha_cita'] : '';
    $hora = isset($_POST['hora_cita']) ? $_POST['hora_cita'] : '';
    $motivo = isset($_POST['descr_causa']) ? $_POST['descr_causa'] : '';
    $status = isset($_POST['Status']) ? $_POST['Status'] : '';
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    if($id > 0 && $tipo_cita && $fecha && $hora && $motivo && $status) {
        $stmt = $conn->prepare("UPDATE solicitar_cita SET tipo_cita=?, fecha_cita=?, hora_cita=?, descr_causa=?, Status=? WHERE ID_solicitud=?");
        $stmt->bind_param("sssssi", $tipo_cita, $fecha, $hora, $motivo, $status, $id);
        $stmt->execute();
        $stmt->close();
        $conn->close();
        header("Location: /php/consultarcitas.php?id=$id&mensaje=Modificación exitosa");
        exit;
    }
}

// Obtener datos de la cita a modificar SOLO si no se acaba de modificar
if($id > 0 && !isset($_POST['modificar'])) {
    $result = $conn->query("SELECT * FROM solicitar_cita WHERE ID_solicitud = $id");
    if($result && $result->num_rows > 0){
        $cita = $result->fetch_assoc();
    } else {
        echo "<p style='color:red;text-align:center;'>Cita no encontrada.</p>";
        $conn->close();
        exit;
    }
} elseif(!$cita) {
    echo "<p style='color:red;text-align:center;'>ID de cita no válido.</p>";
    $conn->close();
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Cita</title>
    <link rel="stylesheet" href="/Style/modificarcita.css">

</head>
<body>
    <h1>Modificar Cita Psicológica</h1>
    <div class="table-section">
        <?php if($cita): ?>
        <form method="post">
            <input type="hidden" name="id" value="<?= htmlspecialchars($cita['ID_solicitud']) ?>">
            <label for="tipo_cita">Tipo de Cita:
                <select id="tipo_cita" name="tipo_cita" required>
                    <option value="ONLINE" <?= (isset($cita['tipo_cita']) && $cita['tipo_cita']=='ONLINE')?'selected':'' ?>>ONLINE</option>
                    <option value="PRESENCIAL" <?= (isset($cita['tipo_cita']) && $cita['tipo_cita']=='PRESENCIAL')?'selected':'' ?>>PRESENCIAL</option>
                </select>
            </label>
            <label for="fecha_cita">Fecha:
                <input type="date" id="fecha_cita" name="fecha_cita" value="<?= isset($cita['fecha_cita']) ? htmlspecialchars($cita['fecha_cita']) : '' ?>" required>
            </label>
            <label for="hora_cita">Hora:
                <input type="time" id="hora_cita" name="hora_cita" value="<?= isset($cita['hora_cita']) ? htmlspecialchars($cita['hora_cita']) : '' ?>" required>
            </label>
            <label for="descr_causa">Motivo:
                <textarea id="descr_causa" name="descr_causa" required><?= isset($cita['descr_causa']) ? htmlspecialchars($cita['descr_causa']) : '' ?></textarea>
            </label>
            <label for="Status">Status:
                <select id="Status" name="Status" required>
                    <option value="ACTIVO" <?= (isset($cita['Status']) && strtoupper($cita['Status'])=='ACTIVO')?'selected':'' ?>>ACTIVO</option>
                    <option value="INACTIVO" <?= (isset($cita['Status']) && strtoupper($cita['Status'])=='INACTIVO')?'selected':'' ?>>INACTIVO</option>
                </select>
            </label>
            <button type="submit" name="modificar">Guardar Cambios</button>
            <div style="margin-top:20px;">
            <a href="/php/consultarcitas_paciente.php" class="volver-inicio">
            <i class="fas fa-arrow-left"></i>Cancelar
            </a>
            </div>
            
        </form>
        <?php endif; ?>
    </div>
</body>
</html>