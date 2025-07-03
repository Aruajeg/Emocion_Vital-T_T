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
    $tipo_consulta = isset($_POST['tipo_consulta']) ? $_POST['tipo_consulta'] : '';
    $motivo = isset($_POST['descr_causa']) ? $_POST['descr_causa'] : '';
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    if($id > 0 && $tipo_cita && $motivo && $tipo_consulta) {
        $stmt = $conn->prepare("UPDATE solicitar_cita SET tipo_cita=?, tipo_consulta=?, descr_causa=? WHERE ID_solicitud=?");
        $stmt->bind_param("sssi", $tipo_cita, $tipo_consulta, $motivo, $id);
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
    <style>
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-adulto {
            background-color: #3498db;
            color: white;
        }
        .badge-infante {
            background-color: #2ecc71;
            color: white;
        }
        .badge-adolescente {
            background-color: #9b59b6;
            color: white;
        }
        .badge-pareja {
            background-color: #e67e22;
            color: white;
        }
    </style>
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
            
            <label for="tipo_consulta">Tipo de Consulta:
                <select id="tipo_consulta" name="tipo_consulta" required>
                    <option value="Adulto" <?= (isset($cita['tipo_consulta']) && $cita['tipo_consulta']=='Adulto')?'selected':'' ?>>Adulto</option>
                    <option value="Adolescente" <?= (isset($cita['tipo_consulta']) && $cita['tipo_consulta']=='Adolescente')?'selected':'' ?>>Adolescente</option>
                    <option value="Infante" <?= (isset($cita['tipo_consulta']) && $cita['tipo_consulta']=='Infante')?'selected':'' ?>>Infante</option>
                    <option value="Pareja" <?= (isset($cita['tipo_consulta']) && $cita['tipo_consulta']=='Pareja')?'selected':'' ?>>Pareja</option>
                </select>
            </label>
            
            <label for="descr_causa">Motivo:
                <textarea id="descr_causa" name="descr_causa" required><?= isset($cita['descr_causa']) ? htmlspecialchars($cita['descr_causa']) : '' ?></textarea>
            </label>
            
            <button type="submit" name="modificar">Guardar Cambios</button>
            <div style="margin-top:20px;">
                <a href="/php/consultarcitas.php" class="volver-inicio">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
            </div>
        </form>
        <?php endif; ?>
    </div>
</body>
</html>