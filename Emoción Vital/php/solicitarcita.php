<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agendar Cita Psicológica</title>
    <link rel="stylesheet" href="/Style/llenardatos.css">
    <style>
        .volver-inicio {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 24px;
            background: #4e73df;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.2s;
        }
        .volver-inicio:hover {
            background: #2e59d9;
            color: #fff;
            text-decoration: none;
        }
        .volver-inicio i {
            margin-right: 6px;
        }
    </style>
</head>
<body>
    <div class="container" style="max-width:600px;margin:40px auto;">
        <h2>Agendar Cita Psicológica</h2>
        <?php
        if (isset($_GET['mensaje']) && $_GET['mensaje'] !== '') {
            echo '<div class="alert">' . htmlspecialchars($_GET['mensaje']) . '</div>';
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

        // Obtener pacientes
        $pacientes = [];
        $res_pac = $conn->query("SELECT id_paciente, Nombre_1, Apellido_1 FROM paciente");
        while ($row = $res_pac->fetch_assoc()) {
            $pacientes[] = $row;
        }

        // Obtener psicólogos
        $psicologos = [];
        $res_psico = $conn->query("SELECT id_psicologo, Nombre_1, Apellido_1 FROM psicologo");
        while ($row = $res_psico->fetch_assoc()) {
            $psicologos[] = $row;
        }
        ?>
        <form method="post" action="/php/solicitarcitalogica.php">
            <div>
                <label for="id_paciente">Paciente:</label>
                <select id="id_paciente" name="id_paciente" required class="form-control">
                    <option value="">Seleccione</option>
                    <?php foreach($pacientes as $p): ?>
                        <option value="<?= htmlspecialchars($p['id_paciente']) ?>">
                            <?= htmlspecialchars($p['Nombre_1'] . ' ' . $p['Apellido_1']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="id_psicologo">Psicólogo:</label>
                <select id="id_psicologo" name="id_psicologo" required class="form-control">
                    <option value="">Seleccione</option>
                    <?php foreach($psicologos as $ps): ?>
                        <option value="<?= htmlspecialchars($ps['id_psicologo']) ?>">
                            <?= htmlspecialchars($ps['Nombre_1'] . ' ' . $ps['Apellido_1']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="tipo_cita">Tipo de Cita:</label>
                <select id="tipo_cita" name="tipo_cita" required class="form-control">
                    <option value="">Seleccione</option>
                    <option value="ONLINE">ONLINE</option>
                    <option value="PRESENCIAL">PRESENCIAL</option>
                </select>
            </div>
            <div>
                <label for="fecha">Fecha de la cita:</label>
                <input type="date" id="fecha" name="fecha" required class="form-control">
            </div>
            <div>
                <label for="hora">Hora de la cita:</label>
                <input type="time" id="hora" name="hora" required class="form-control">
            </div>
            <div>
                <label for="motivo">Motivo de la cita:</label>
                <textarea id="motivo" name="motivo" rows="2" required class="form-control"
                          minlength="5" maxlength="255" title="Describa el motivo de la cita"></textarea>
            </div>
            <!-- Estado eliminado del formulario -->
            <div style="margin-top:20px;">
                <button type="submit" class="btn btn-primary">Agendar Cita</button>
            </div>
            <div style="margin-top:20px;">
        <a href="/php/dashboard.php" class="volver-inicio">
            <i class="fas fa-arrow-left"></i> Volver al inicio
        </a>
            </div>
        </form>
    </div>
    <!-- Font Awesome para el ícono -->
    <script src="https://kit.fontawesome.com/4b8b3e1c1a.js" crossorigin="anonymous"></script>
</body>
</html>