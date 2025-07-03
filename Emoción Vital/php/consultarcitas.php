<?php
session_start();
if(!isset($_SESSION['usuario'])) {
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

// Determinar el ordenamiento según la selección del usuario
$orden = isset($_GET['orden']) ? $_GET['orden'] : 'id_asc';

switch($orden) {
    case 'id_asc':
        $order_by = "sc.ID_solicitud ASC";
        $orden_descripcion = "Orden: ID (Más antiguo primero)";
        break;
    case 'id_desc':
        $order_by = "sc.ID_solicitud DESC";
        $orden_descripcion = "Orden: ID (Más nuevo primero)";
        break;
    case 'fecha_asc':
        $order_by = "sc.fecha_cita ASC, sc.hora_cita ASC";
        $orden_descripcion = "Orden: Fecha (La más proxima primero)";
        break;
    case 'fecha_desc':
        $order_by = "sc.fecha_cita DESC, sc.hora_cita DESC";
        $orden_descripcion = "Orden: Fecha (La más alejada primero)";
        break;
    default:
        $order_by = "sc.ID_solicitud ASC";
        $orden_descripcion = "Orden: ID (Más antiguo primero)";
}

// Consulta SQL con ordenamiento dinámico (incluyendo Tipo_consulta)
$sql = "
SELECT 
    sc.ID_solicitud,
    p.Nombre_1 AS Paciente_Nombre,
    p.Apellido_1 AS Paciente_Apellido,
    ps.Nombre_1 AS Psicologo_Nombre,
    ps.Apellido_1 AS Psicologo_Apellido,
    sc.tipo_cita,
    sc.tipo_consulta,
    sc.fecha_cita,
    sc.hora_cita,
    sc.descr_causa,
    sc.Status
FROM solicitar_cita sc
INNER JOIN paciente p ON sc.id_paciente = p.id_paciente
INNER JOIN psicologo ps ON sc.id_psicologo = ps.id_psicologo
WHERE sc.Status = 'Activo'
ORDER BY $order_by
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
    <style>
        .table-citas {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table-citas th, .table-citas td {
            padding: 10px 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .table-citas th {
            background-color: #4e73df;
            color: white;
            font-weight: bold;
        }
        .table-citas tr:hover {
            background-color: #f5f5f5;
        }
        .no-data {
            padding: 20px;
            text-align: center;
            color: #666;
            font-style: italic;
        }
        .volver-inicio {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #4e73df;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s;
        }
        .volver-inicio:hover {
            background: #2e59d9;
        }
        .table-section {
            max-width: 1300px;
            margin: 30px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .table-container {
            overflow-x: auto;
        }
        .acciones a {
            margin: 0 5px;
            color: #3498db;
            text-decoration: none;
        }
        .acciones a:hover {
            color: #2980b9;
        }
        .fa-trash-alt {
            color: #e74c3c !important;
        }
        .filtros-container {
            margin: 20px 0;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }
        .filtro-orden {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .filtro-orden label {
            font-weight: bold;
            margin-right: 5px;
        }
        .filtro-orden select {
            padding: 8px 12px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        .filtro-orden button {
            padding: 8px 15px;
            background-color: #4e73df;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .filtro-orden button:hover {
            background-color: #2e59d9;
        }
        .orden-actual {
            font-style: italic;
            color: #666;
            margin-left: 15px;
        }
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
    <div class="table-section">
        <h1 style="text-align:center; margin-bottom:30px;">Consultar Citas Activas</h1>
        
        <!-- Filtros de ordenamiento -->
        <div class="filtros-container">
            <form method="GET" class="filtro-orden">
                <label for="orden">Ordenar por:</label>
                <select name="orden" id="orden">
                    <option value="id_asc" <?= $orden == 'id_asc' ? 'selected' : '' ?>>ID (Más antiguo primero)</option>
                    <option value="id_desc" <?= $orden == 'id_desc' ? 'selected' : '' ?>>ID (Más nuevo primero)</option>
                    <option value="fecha_asc" <?= $orden == 'fecha_asc' ? 'selected' : '' ?>>Fecha (La más proxima primero)</option>
                    <option value="fecha_desc" <?= $orden == 'fecha_desc' ? 'selected' : '' ?>>Fecha (La más alejada primero)</option>
                </select>
                <button type="submit">Aplicar</button>
                <span class="orden-actual"><?= $orden_descripcion ?></span>
            </form>
        </div>

        <?php if ($result && $result->num_rows > 0): ?>
            <div class="table-container">
                <table class="table-citas">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Paciente</th>
                            <th>Psicólogo</th>
                            <th>Tipo Cita</th>
                            <th>Tipo Consulta</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Motivo</th>
                            <th>Estado</th>
                            <th class="acciones">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $indice = 1;
                        while($row = $result->fetch_assoc()): 
                            // Determinar la clase CSS según el tipo de consulta
                            $badge_class = '';
                            switch($row['tipo_consulta']) {
                                case 'Adulto': $badge_class = 'badge-adulto'; break;
                                case 'Infante': $badge_class = 'badge-infante'; break;
                                case 'Adolescente': $badge_class = 'badge-adolescente'; break;
                                case 'Pareja': $badge_class = 'badge-pareja'; break;
                                default: $badge_class = '';
                            }
                        ?>
                            <tr>
                                <td><?= $indice ?></td>
                                <td><?= htmlspecialchars($row['Paciente_Nombre'] . ' ' . $row['Paciente_Apellido']) ?></td>
                                <td><?= htmlspecialchars($row['Psicologo_Nombre'] . ' ' . $row['Psicologo_Apellido']) ?></td>
                                <td><?= htmlspecialchars($row['tipo_cita']) ?></td>
                                <td>
                                    <span class="badge <?= $badge_class ?>">
                                        <?= htmlspecialchars($row['tipo_consulta']) ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($row['fecha_cita']) ?></td>
                                <td><?= htmlspecialchars($row['hora_cita']) ?></td>
                                <td><?= htmlspecialchars($row['descr_causa']) ?></td>
                                <td><?= htmlspecialchars($row['Status']) ?></td>
                                <td class="acciones">
                                    <a href="/php/modificarcita.php?id=<?= $row['ID_solicitud'] ?>" title="Modificar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="/php/eliminarcita.php?id=<?= $row['ID_solicitud'] ?>" 
                                       title="Eliminar" 
                                       onclick="return confirm('¿Seguro que deseas eliminar esta cita?');">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php 
                        $indice++;
                        endwhile; 
                        ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="no-data">No hay citas activas en este momento.</div>
        <?php endif; ?>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="/php/dashboard.php" class="volver-inicio">
                <i class="fas fa-arrow-left"></i> Volver al inicio
            </a>
        </div>
    </div>
    <?php $conn->close(); ?>
</body>
</html>