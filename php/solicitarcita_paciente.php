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

// Conexión a la base de datos
$host = "localhost";
$user = "root";
$pass = "";
$db = "implantacion";
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener el ID del usuario de la sesión
$id_usuario = $_SESSION['id_usuario']; // Asegúrate de que esto esté configurado al iniciar sesión

// Obtener solo los pacientes asociados a este usuario
$pacientes = [];
$res_pac = $conn->prepare("SELECT id_paciente, Nombre_1, Apellido_1 FROM paciente WHERE id_usuario = ?");
$res_pac->bind_param("i", $id_usuario);
$res_pac->execute();
$result = $res_pac->get_result();
while ($row = $result->fetch_assoc()) {
    $pacientes[] = $row;
}
$res_pac->close();

// Obtener psicólogos
$psicologos = [];
$res_psico = $conn->query("SELECT id_psicologo, Nombre_1, Apellido_1 FROM psicologo");
while ($row = $res_psico->fetch_assoc()) {
    $psicologos[] = $row;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agendar Cita Psicológica</title>
    <link rel="stylesheet" href="/Style/llenardatos.css">
    <style>
        /* Estilos generales */
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
            color:rgb(22, 74, 65);
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .error-message {
            color: #dc3545;
            font-size: 14px;
            margin-top: -10px;
            margin-bottom: 15px;
            display: none;
        }
        
        /* Estilos para los bloques horarios */
        .time-slots-container {
            margin-top: 10px;
        }
        .time-slot {
            display: block;
            width: 100%;
            padding: 12px;
            margin-bottom: 8px;
            border: 2px solid #ddd;
            border-radius: 6px;
            background-color: #f8f9fa;
            text-align: center;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .time-slot:hover {
            background-color: #e9ecef;
            border-color: #adb5bd;
        }
        .time-slot.selected {
            background-color: #4e73df;
            color: white;
            border-color: #4e73df;
        }
        .time-slot.disabled {
            background-color: #f8f9fa;
            color: #adb5bd;
            cursor: not-allowed;
            border-style: dashed;
        }
        .time-slot.ocupado {
            background-color: #ffeeba;
            color: #856404;
            border-color: #ffeeba;
            cursor: not-allowed;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1 class="page-title">Solicitar Cita</h1>
        <?php
        if (isset($_GET['mensaje']) && $_GET['mensaje'] !== '') {
            echo '<div class="alert">' . htmlspecialchars($_GET['mensaje']) . '</div>';
        }
        ?>
        <form method="post" action="/php/solicitarcitalogica_paciente.php" id="citaForm">
            <!-- Campos del formulario -->
            <div>
                <label for="id_paciente">Paciente:</label>
                <select id="id_paciente" name="id_paciente" required class="form-control">
                    <?php if(empty($pacientes)): ?>
                        <option value="">No tienes pacientes registrados</option>
                    <?php else: ?>
                        <option value="">Seleccione un paciente</option>
                        <?php foreach($pacientes as $p): ?>
                            <option value="<?= htmlspecialchars($p['id_paciente']) ?>">
                                <?= htmlspecialchars($p['Nombre_1'] . ' ' . $p['Apellido_1']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
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
                <div id="fecha-error" class="error-message">Las citas solo están disponibles de Lunes a Viernes</div>
            </div>
            
            <!-- Selector de bloques horarios -->
            <div>
                <label>Seleccione el horario:</label>
                <input type="hidden" id="hora" name="hora" required>
                <div id="time-slots-container" class="time-slots-container">
                    <div class="time-slot" data-value="08:00 - 09:45">08:00 - 09:45</div>
                    <div class="time-slot" data-value="10:00 - 11:45">10:00 - 11:45</div>
                    <div class="time-slot" data-value="13:00 - 14:45">13:00 - 14:45</div>
                    <div class="time-slot" data-value="15:00 - 16:45">15:00 - 16:45</div>
                </div>
                <div id="hora-error" class="error-message">Por favor seleccione un horario</div>
                <div id="hora-ocupada-error" class="error-message" style="display:none;">Este horario ya está ocupado</div>
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
        document.addEventListener('DOMContentLoaded', function() {
            const fechaInput = document.getElementById('fecha');
            const horaHiddenInput = document.getElementById('hora');
            const timeSlots = document.querySelectorAll('.time-slot');
            const fechaError = document.getElementById('fecha-error');
            const horaError = document.getElementById('hora-error');
            const horaOcupadaError = document.getElementById('hora-ocupada-error');
            const form = document.getElementById('citaForm');
            const idPsicologoSelect = document.getElementById('id_psicologo');
            
            // Establecer fecha mínima (hoy)
            const hoy = new Date();
            const hoyFormateado = hoy.toISOString().split('T')[0];
            fechaInput.min = hoyFormateado;
            
            // Validar día de la semana (Lunes a Viernes)
            fechaInput.addEventListener('change', function() {
                const selectedDate = new Date(this.value);
                const dayOfWeek = selectedDate.getDay(); // 0=Domingo, 1=Lunes, ..., 6=Sábado
                
                if (dayOfWeek === 0 || dayOfWeek === 6) {
                    this.value = '';
                    fechaError.style.display = 'block';
                } else {
                    fechaError.style.display = 'none';
                    if (idPsicologoSelect.value && this.value) {
                        verificarHorariosOcupados();
                    }
                }
            });
            
            // Cuando se selecciona un psicólogo
            idPsicologoSelect.addEventListener('change', function() {
                if (fechaInput.value) {
                    verificarHorariosOcupados();
                }
            });
            
            // Función para verificar horarios ocupados
            async function verificarHorariosOcupados() {
                const fecha = fechaInput.value;
                const idPsicologo = idPsicologoSelect.value;
                
                if (!fecha || !idPsicologo) return;
                
                try {
                    const response = await fetch(`/php/verificar_horarios.php?fecha=${fecha}&id_psicologo=${idPsicologo}`);
                    const horariosOcupados = await response.json();
                    
                    // Resetear todos los slots
                    timeSlots.forEach(slot => {
                        slot.classList.remove('ocupado', 'disabled');
                        slot.style.pointerEvents = 'auto';
                    });
                    
                    // Marcar horarios ocupados
                    horariosOcupados.forEach(horario => {
                        const [horaInicio, horaFin] = horario.split(' - ');
                        const slot = Array.from(timeSlots).find(s => {
                            const [slotInicio, slotFin] = s.dataset.value.split(' - ');
                            return (
                                (horaInicio >= slotInicio && horaInicio < slotFin) ||
                                (horaFin > slotInicio && horaFin <= slotFin) ||
                                (horaInicio <= slotInicio && horaFin >= slotFin)
                            );
                        });
                        
                        if (slot) {
                            slot.classList.add('ocupado');
                            slot.style.pointerEvents = 'none';
                            if (slot.classList.contains('selected')) {
                                slot.classList.remove('selected');
                                horaHiddenInput.value = '';
                            }
                        }
                    });
                    
                } catch (error) {
                    console.error('Error al verificar horarios:', error);
                }
            }
            
            // Selección de horario
            timeSlots.forEach(slot => {
                slot.addEventListener('click', function() {
                    if (this.classList.contains('ocupado')) return;
                    
                    // Deseleccionar todos los slots primero
                    timeSlots.forEach(s => {
                        s.classList.remove('selected');
                    });
                    
                    // Seleccionar este slot
                    this.classList.add('selected');
                    horaHiddenInput.value = this.dataset.value;
                    horaError.style.display = 'none';
                    horaOcupadaError.style.display = 'none';
                });
            });
            
            // Validar al enviar el formulario
            form.addEventListener('submit', function(e) {
                let isValid = true;
                
                if (!fechaInput.value) {
                    fechaError.style.display = 'block';
                    isValid = false;
                }
                
                if (!horaHiddenInput.value) {
                    horaError.style.display = 'block';
                    isValid = false;
                } else {
                    // Verificar si el horario seleccionado está ocupado
                    const slotSeleccionado = Array.from(timeSlots).find(s => s.classList.contains('selected'));
                    if (slotSeleccionado && slotSeleccionado.classList.contains('ocupado')) {
                        horaOcupadaError.style.display = 'block';
                        isValid = false;
                    }
                }
                
                if (!isValid) {
                    e.preventDefault();
                    
                    // Desplazarse al primer error
                    if (!fechaInput.value) {
                        fechaInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        fechaInput.focus();
                    } else if (!horaHiddenInput.value || horaOcupadaError.style.display === 'block') {
                        document.getElementById('time-slots-container').scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }
            });
        });
    </script>
</body>
</html>