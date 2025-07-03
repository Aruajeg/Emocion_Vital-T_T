<?php
// Iniciar sesión para manejar mensajes y datos previos
session_start();

// Configuración de la base de datos
$host = "localhost";
$usuario = "root";
$password = "";
$base_datos = "implantacion";

// Crear conexión
$conexion = new mysqli($host, $usuario, $password, $base_datos);

// Verificar conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Configurar charset para caracteres especiales
$conexion->set_charset("utf8");

// Verificar si se recibieron datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Obtener y limpiar los datos del formulario
    $tipo_cedula = $conexion->real_escape_string(trim($_POST['Tipo_Cedula'] ?? ''));
    $cedula = $conexion->real_escape_string(trim($_POST['Cedula'] ?? ''));
    $primer_nombre = $conexion->real_escape_string(trim($_POST['Primer_Nombre'] ?? ''));
    $segundo_nombre = $conexion->real_escape_string(trim($_POST['Segundo_Nombre'] ?? ''));
    $primer_apellido = $conexion->real_escape_string(trim($_POST['Primer_Apellido'] ?? ''));
    $segundo_apellido = $conexion->real_escape_string(trim($_POST['Segundo_Apellido'] ?? ''));
    $num_hijos = $conexion->real_escape_string(trim($_POST['Num_Hijos'] ?? ''));
    $telefono = $conexion->real_escape_string(trim($_POST['Teléfono'] ?? ''));
    $fecha_nacimiento = $conexion->real_escape_string(trim($_POST['Fecha_Nacimiento'] ?? ''));
    $correo = $conexion->real_escape_string(trim($_POST['Correo'] ?? ''));
    $id_direccion = $conexion->real_escape_string(trim($_POST['ID_Direccion'] ?? ''));
    $status_paciente = $conexion->real_escape_string(trim($_POST['StatusPaciente'] ?? ''));

    // Validaciones completas
    $errores = [];
    
    // Validación del tipo de cédula
    if (empty($tipo_cedula)) {
        $errores[] = "El tipo de cédula es obligatorio";
    } elseif (!in_array($tipo_cedula, ['V', 'E', 'P', 'J'])) {
        $errores[] = "El tipo de cédula debe ser V, E, P o J";
    }
    
    // Validación de la cédula (8 dígitos, solo números)
    if (empty($cedula)) {
        $errores[] = "La cédula es obligatoria";
    } elseif (!preg_match('/^\d{8}$/', $cedula)) {
        $errores[] = "La cédula debe tener exactamente 8 dígitos numéricos";
    }
    
    // Validación del primer nombre (solo letras y espacios)
    if (empty($primer_nombre)) {
        $errores[] = "El primer nombre es obligatorio";
    } elseif (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $primer_nombre)) {
        $errores[] = "El primer nombre solo puede contener letras y espacios";
    } elseif (strlen($primer_nombre) < 2) {
        $errores[] = "El primer nombre debe tener al menos 2 caracteres";
    } elseif (strlen($primer_nombre) > 50) {
        $errores[] = "El primer nombre no puede exceder 50 caracteres";
    }
    
    // Validación del segundo nombre (opcional, solo letras y espacios)
    if (!empty($segundo_nombre)) {
        if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $segundo_nombre)) {
            $errores[] = "El segundo nombre solo puede contener letras y espacios";
        } elseif (strlen($segundo_nombre) < 2) {
            $errores[] = "El segundo nombre debe tener al menos 2 caracteres";
        } elseif (strlen($segundo_nombre) > 50) {
            $errores[] = "El segundo nombre no puede exceder 50 caracteres";
        }
    }
    
    // Validación del primer apellido (solo letras y espacios)
    if (empty($primer_apellido)) {
        $errores[] = "El primer apellido es obligatorio";
    } elseif (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $primer_apellido)) {
        $errores[] = "El primer apellido solo puede contener letras y espacios";
    } elseif (strlen($primer_apellido) < 2) {
        $errores[] = "El primer apellido debe tener al menos 2 caracteres";
    } elseif (strlen($primer_apellido) > 50) {
        $errores[] = "El primer apellido no puede exceder 50 caracteres";
    }
    
    // Validación del segundo apellido (opcional, solo letras y espacios)
    if (!empty($segundo_apellido)) {
        if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $segundo_apellido)) {
            $errores[] = "El segundo apellido solo puede contener letras y espacios";
        } elseif (strlen($segundo_apellido) < 2) {
            $errores[] = "El segundo apellido debe tener al menos 2 caracteres";
        } elseif (strlen($segundo_apellido) > 50) {
            $errores[] = "El segundo apellido no puede exceder 50 caracteres";
        }
    }
    
    // Validación del número de hijos (solo números, 0-20)
    if (!empty($num_hijos)) {
        if (!is_numeric($num_hijos) || $num_hijos < 0 || $num_hijos > 20) {
            $errores[] = "El número de hijos debe ser un número entre 0 y 20";
        }
    } else {
        $num_hijos = 0; // Valor por defecto si está vacío
    }
    
    // Validación del teléfono (solo números, 10-11 dígitos)
    if (empty($telefono)) {
        $errores[] = "El teléfono es obligatorio";
    } elseif (!preg_match('/^\d{10,11}$/', $telefono)) {
        $errores[] = "El teléfono debe tener entre 10 y 11 dígitos numéricos";
    }
    
    // Validación de la fecha de nacimiento
    if (empty($fecha_nacimiento)) {
        $errores[] = "La fecha de nacimiento es obligatoria";
    } else {
        $fecha_actual = new DateTime();
        $fecha_nac = DateTime::createFromFormat('Y-m-d', $fecha_nacimiento);
        
        if (!$fecha_nac) {
            $errores[] = "El formato de fecha de nacimiento no es válido (YYYY-MM-DD)";
        } else {
            $edad = $fecha_actual->diff($fecha_nac)->y;
            if ($edad < 0 || $edad > 120) {
                $errores[] = "La fecha de nacimiento no es válida (edad entre 0 y 120 años)";
            }
        }
    }
    
    // Validación del correo electrónico
    if (empty($correo)) {
        $errores[] = "El correo es obligatorio";
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El formato del correo no es válido";
    } elseif (strlen($correo) > 100) {
        $errores[] = "El correo no puede exceder 100 caracteres";
    }
    
    // Validación del ID de dirección (solo números)
    if (empty($id_direccion)) {
        $errores[] = "El ID de dirección es obligatorio";
    } elseif (!is_numeric($id_direccion) || $id_direccion <= 0) {
        $errores[] = "El ID de dirección debe ser un número positivo";
    }
    
    // Validación del status del paciente
    if (empty($status_paciente)) {
        $errores[] = "El estado del paciente es obligatorio";
    } elseif (!in_array($status_paciente, ['Activo', 'Inactivo', 'Pendiente'])) {
        $errores[] = "El estado del paciente debe ser Activo, Inactivo o Pendiente";
    }

    // Si no hay errores, insertar en la base de datos
    if (empty($errores)) {
        // Preparar la consulta SQL usando prepared statements para mayor seguridad
        $sql = "INSERT INTO paciente (
            Tipo_Cedula, Cedula, `Primer Nombre`, `Segundo Nombre`, `Primer Apellido`, `Segundo Apellido`,
            Num_Hijos, Teléfono, Fecha_Nacimiento, Correo, ID_Direccion, StatusPaciente
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ssssssssssis",
                $tipo_cedula,
                $cedula,
                $primer_nombre,
                $segundo_nombre,
                $primer_apellido,
                $segundo_apellido,
                $num_hijos,
                $telefono,
                $fecha_nacimiento,
                $correo,
                $id_direccion,
                $status_paciente
            );
            if ($stmt->execute()) {
                $mensaje = "¡Registro exitoso! Los datos del paciente han sido guardados correctamente.";
                $tipo_mensaje = "exito";
            } else {
                $mensaje = "Error al guardar los datos: " . $stmt->error;
                $tipo_mensaje = "error";
            }
            $stmt->close();
        } else {
            $mensaje = "Error en la preparación de la consulta: " . $conexion->error;
            $tipo_mensaje = "error";
        }
    } else {
        $mensaje = "Errores de validación: " . implode(", ", $errores);
        $tipo_mensaje = "error";
        
        // Guardar datos previos en sesión para mantenerlos en el formulario
        $_SESSION['datos_previos'] = [
            'Tipo_Cedula' => $tipo_cedula,
            'Cedula' => $cedula,
            'Primer_Nombre' => $primer_nombre,
            'Segundo_Nombre' => $segundo_nombre,
            'Primer_Apellido' => $primer_apellido,
            'Segundo_Apellido' => $segundo_apellido,
            'Num_Hijos' => $num_hijos,
            'Teléfono' => $telefono,
            'Fecha_Nacimiento' => $fecha_nacimiento,
            'Correo' => $correo,
            'ID_Direccion' => $id_direccion,
            'StatusPaciente' => $status_paciente
        ];
        
        // Redirigir de vuelta al formulario con mensaje de error
        $_SESSION['mensaje'] = $mensaje;
        $_SESSION['tipo_mensaje'] = $tipo_mensaje;
        header("Location: registro_pacientes.php");
        exit();
    }
    
} else {
    $mensaje = "No se recibieron datos del formulario";
    $tipo_mensaje = "error";
    
    // Redirigir de vuelta al formulario con mensaje de error
    $_SESSION['mensaje'] = $mensaje;
    $_SESSION['tipo_mensaje'] = $tipo_mensaje;
    header("Location: registro_pacientes.php");
    exit();
}

// Cerrar la conexión
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado del Registro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .mensaje {
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .exito {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }
        .boton {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }
        .boton:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="mensaje <?php echo $tipo_mensaje; ?>">
        <h2><?php echo $tipo_mensaje == 'exito' ? '✅ Éxito' : '❌ Error'; ?></h2>
        <p><?php echo htmlspecialchars($mensaje); ?></p>
    </div>
    
    <a href="registro_pacientes.php" class="boton">Volver al formulario</a>
</body>
</html>