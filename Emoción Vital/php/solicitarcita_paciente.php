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
        .container {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .form-control {
            width: 100%;
            padding: 10px;
            margin: 8px 0 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .btn-primary {
            background-color: #4e73df;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .btn-primary:hover {
            background-color: #2e59d9;
        }
        .alert {
            padding: 10px;
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .page-title {
            text-align: center;
            color:rgb(202, 223, 219);
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2 class="page-title">Solicitar Cita</h2>
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
        <form method="post" action="/php/solicitarcitalogica_paciente.php">
            <div>
                <label for="id_paciente">Paciente:</label>
                <select id="id_paciente" name="id_paciente" required class="form-control">
                    <option value="">Seleccione un paciente</option>
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
                    <option value="">Seleccione un psicólogo</option>
                    <?php foreach($psicologos as $ps): ?>
                        <option value="<?= htmlspecialchars($ps['id_psicologo']) ?>">
                            <?= htmlspecialchars($ps['Nombre_1'] . ' ' . $ps['Apellido_1']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div>
                <label for="tipo_cita">Modalidad de Cita:</label>
                <select id="tipo_cita" name="tipo_cita" required class="form-control">
                    <option value="">Seleccione la modalidad</option>
                    <option value="ONLINE">ONLINE</option>
                    <option value="PRESENCIAL">PRESENCIAL</option>
                </select>
            </div>
            
            <div>
                <label for="tipo_consulta">Tipo de Consulta:</label>
                <select id="tipo_consulta" name="tipo_consulta" required class="form-control">
                    <option value="">Seleccione el tipo de consulta</option>
                    <option value="Adulto">Adulto</option>
                    <option value="Adolescente">Adolescente</option>
                    <option value="Infante">Infante</option>
                    <option value="Pareja">Pareja</option>
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
            
            <div style="margin-top:20px;">
                <button type="submit" class="btn btn-primary">Agendar Cita</button>
            </div>
            
            <div style="margin-top:20px;">
                <a href="/php/dashboard_paciente.php" class="volver-inicio">
                    <i class="fas fa-arrow-left"></i> Volver al inicio
                </a>
            </div>
        </form>
    </div>
    <!-- Font Awesome para el ícono -->
    <script src="https://kit.fontawesome.com/4b8b3e1c1a.js" crossorigin="anonymous"></script>
    
    <script>
        // Validación de fecha mínima (hoy o en el futuro)
        document.addEventListener('DOMContentLoaded', function() {
            const fechaInput = document.getElementById('fecha');
            const hoy = new Date().toISOString().split('T')[0];
            fechaInput.min = hoy;
            
            // Validación de hora para citas presenciales (horario laboral)
            document.getElementById('tipo_cita').addEventListener('change', function() {
                if(this.value === 'PRESENCIAL') {
                    document.getElementById('hora').min = '08:00';
                    document.getElementById('hora').max = '17:00';
                } else {
                    document.getElementById('hora').removeAttribute('min');
                    document.getElementById('hora').removeAttribute('max');
                }
            });
        });
    </script>
</body>
</html>