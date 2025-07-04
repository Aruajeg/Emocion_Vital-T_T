<?php
// Configuración de la base de datos
$host = "localhost";
$usuario = "root";
$password = "";
$base_datos = "emocionvital";

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

    // Validaciones básicas
    $errores = [];
    if (empty($tipo_cedula)) {
        $errores[] = "El tipo de cédula es obligatorio";
    }
    if (empty($primer_nombre)) {
        $errores[] = "El primer nombre es obligatorio";
    }
    if (empty($primer_apellido)) {
        $errores[] = "El primer apellido es obligatorio";
    }
    if (empty($cedula)) {
        $errores[] = "La cédula es obligatoria";
    }
    if (empty($telefono)) {
        $errores[] = "El teléfono es obligatorio";
    }
    if (empty($fecha_nacimiento)) {
        $errores[] = "La fecha de nacimiento es obligatoria";
    }
    if (empty($correo)) {
        $errores[] = "El correo es obligatorio";
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El formato del correo no es válido";
    }
    if (empty($id_direccion)) {
        $errores[] = "El ID de dirección es obligatorio";
    }
    if (empty($status_paciente)) {
        $errores[] = "El estado del paciente es obligatorio";
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
    }
    
} else {
    $mensaje = "No se recibieron datos del formulario";
    $tipo_mensaje = "error";
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
    
    <a href="index.html" class="boton">Volver al formulario</a>
</body>
</html>