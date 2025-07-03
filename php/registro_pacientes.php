<?php
// Iniciar sesión para manejar mensajes de estado
session_start();

// Configuración de la base de datos para verificar conexión
$host = "localhost";
$usuario = "root";
$password = "";
$base_datos = "implantacion";

// Crear conexión para verificar estado
$conexion = new mysqli($host, $usuario, $password, $base_datos);
$estado_conexion = $conexion->connect_error ? "Desconectado" : "Conectado";
$conexion->close();

// Obtener mensajes de sesión si existen
$mensaje = $_SESSION['mensaje'] ?? '';
$tipo_mensaje = $_SESSION['tipo_mensaje'] ?? '';
$datos_previos = $_SESSION['datos_previos'] ?? [];

// Limpiar mensajes de sesión después de mostrarlos
unset($_SESSION['mensaje'], $_SESSION['tipo_mensaje'], $_SESSION['datos_previos']);

// Función para mantener valores previos en caso de error
function mantenerValor($campo, $datos_previos) {
    return htmlspecialchars($datos_previos[$campo] ?? '');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/Style/estilos_pacientes.css">
  <title>Sistema de Registro de Pacientes - Emoción Vital</title>
</head>
<body>

  <!-- Header con información del sistema -->
  <header class="header-sistema">
    <div class="container">
      <h1>🏥 Sistema de Registro de Pacientes</h1>
      <p class="subtitulo">Emoción Vital - Centro de Salud Mental</p>
      <div class="estado-sistema">
        <span class="estado-label">Estado de la Base de Datos:</span>
        <span class="estado-valor <?php echo $estado_conexion === 'Conectado' ? 'conectado' : 'desconectado'; ?>">
          <?php echo $estado_conexion; ?>
        </span>
      </div>
    </div>
  </header>

  <!-- Mensajes de estado -->
  <?php if (!empty($mensaje)): ?>
  <div class="mensaje-sistema <?php echo $tipo_mensaje; ?>">
    <div class="container">
      <p><?php echo htmlspecialchars($mensaje); ?></p>
      <?php if ($tipo_mensaje === 'exito'): ?>
        <div style="text-align:center; margin-top:18px;">
          <a href="/php/dashboard_paciente.php" class="btn btn-success" style="background:linear-gradient(90deg,#51cf66,#295C45);color:#fff;font-weight:bold;padding:12px 28px;border-radius:8px;text-decoration:none;font-size:1.1rem;display:inline-block;box-shadow:0 2px 8px #295C4522;">
            Volver al inicio
          </a>
        </div>
      <?php endif; ?>
    </div>
  </div>
  <?php endif; ?>

  <main class="container">
    <section class="form-register">
      <form action="procesar_registro_paciente.php" method="POST" onsubmit="return validarFormulario()">
        <h4>📋 Datos del Paciente</h4>
        <div class="form-grid">
          <select class="controls" name="Tipo_Cedula" required>
            <option value="">Seleccione tipo de cédula *</option>
            <option value="V" <?php echo mantenerValor('Tipo_Cedula', $datos_previos) === 'V' ? 'selected' : ''; ?>>V - Venezolano</option>
            <option value="E" <?php echo mantenerValor('Tipo_Cedula', $datos_previos) === 'E' ? 'selected' : ''; ?>>E - Extranjero</option>
            <option value="J" <?php echo mantenerValor('Tipo_Cedula', $datos_previos) === 'J' ? 'selected' : ''; ?>>J - Jurídico</option>
            <option value="P" <?php echo mantenerValor('Tipo_Cedula', $datos_previos) === 'P' ? 'selected' : ''; ?>>P - Pasaporte</option>
          </select>
          <input class="controls" type="text" name="Cedula" placeholder="Ingrese su número de cédula (8 dígitos) *" required maxlength="8" pattern="\d{8}" value="<?php echo mantenerValor('Cedula', $datos_previos); ?>">
          <input class="controls" type="text" name="Primer_Nombre" placeholder="Ingrese su primer nombre *" required pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,50}" value="<?php echo mantenerValor('Primer_Nombre', $datos_previos); ?>">
          <input class="controls" type="text" name="Segundo_Nombre" placeholder="Ingrese su segundo nombre (opcional)" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,50}" value="<?php echo mantenerValor('Segundo_Nombre', $datos_previos); ?>">
          <input class="controls" type="text" name="Primer_Apellido" placeholder="Ingrese su primer apellido *" required pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,50}" value="<?php echo mantenerValor('Primer_Apellido', $datos_previos); ?>">
          <input class="controls" type="text" name="Segundo_Apellido" placeholder="Ingrese su segundo apellido (opcional)" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,50}" value="<?php echo mantenerValor('Segundo_Apellido', $datos_previos); ?>">
          <input class="controls" type="number" name="Num_Hijos" placeholder="Número de hijos (0-20)" min="0" max="20" value="<?php echo mantenerValor('Num_Hijos', $datos_previos); ?>">
          <input class="controls" type="tel" name="Teléfono" placeholder="Ingrese su número de teléfono *" required maxlength="11" pattern="\d{10,11}" value="<?php echo mantenerValor('Teléfono', $datos_previos); ?>">
          <input class="controls" type="date" name="Fecha_Nacimiento" required max="<?php echo date('Y-m-d'); ?>" value="<?php echo mantenerValor('Fecha_Nacimiento', $datos_previos); ?>">
          <input class="controls" type="email" name="Correo" placeholder="Ingrese su correo electrónico *" required maxlength="100" value="<?php echo mantenerValor('Correo', $datos_previos); ?>">
        </div>
        <div class="botones-formulario">
          <input class="botons" type="submit" value="💾 Registrar Paciente">
        </div>
      </form>
    </section>

    <!-- Información adicional -->
    <section class="info-adicional">
      <div class="info-card">
        <h5>📝 Información Importante</h5>
        <ul>
          <li>Los campos marcados con * son obligatorios</li>
          <li>La cédula debe tener exactamente 8 dígitos numéricos</li>
          <li>Los nombres y apellidos solo pueden contener letras y espacios</li>
          <li>El teléfono debe tener entre 10 y 11 dígitos</li>
          <li>La fecha de nacimiento no puede ser futura</li>
        </ul>
      </div>
    </section>
  </main>

  <!-- Footer -->
  <footer class="footer-sistema">
    <div class="container">
      <p>&copy; <?php echo date('Y'); ?> Emoción Vital - Sistema de Gestión de Pacientes</p>
    </div>
  </footer>

  <!-- Referencia al archivo JavaScript externo -->
  <script src="validacion_pacientes.js"></script>

</body>
</html>