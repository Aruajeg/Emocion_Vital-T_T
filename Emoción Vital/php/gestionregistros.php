<?php
// Consultacitas.php
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

// Función para mostrar tablas con nombres personalizados
function mostrar_tabla($titulo, $sql, $conn, $custom_headers = [], $show_search = false) {
    echo "<div class='table-section'>";
    echo "<h2>$titulo</h2>";
    
    // Mostrar buscador solo para la tabla de pacientes
    if ($show_search) {
        echo '<div class="search-container">
            <form method="GET" class="search-form">
                <input type="text" name="busqueda" class="search-input" 
                       placeholder="Buscar por número de documento (solo números)" 
                       pattern="\d*" 
                       title="Solo se permiten números"
                       value="'.(isset($_GET['busqueda']) ? htmlspecialchars($_GET['busqueda']) : '').'">
                <button type="submit" class="search-button">
                    <i class="fas fa-search"></i> Buscar
                </button>';
        
        if(isset($_GET['busqueda']) && !empty($_GET['busqueda'])) {
            echo '<a href="'.strtok($_SERVER["REQUEST_URI"], '?').'" class="clear-search">
                    <i class="fas fa-times"></i> Limpiar búsqueda
                </a>';
        }
        
        echo '</form></div>';
    }
    
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        echo "<div class='table-container'><table class='table-citas'><tr>";
        
        // Obtener información de los campos
        $fields = $result->fetch_fields();
        
        // Mostrar encabezados personalizados o los originales
        foreach($fields as $field) {
            $header = $custom_headers[$field->name] ?? $field->name;
            echo "<th>" . htmlspecialchars($header) . "</th>";
        }
        echo "</tr>";
        
        // Mostrar filas de datos
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach($row as $cell) {
                echo "<td>" . htmlspecialchars($cell) . "</td>";
            }
            echo "</tr>";
        }
        echo "</table></div>";
    } else {
        $mensaje = isset($_GET['busqueda']) ? "No se encontraron resultados para la búsqueda" : "No hay registros";
        echo "<div class='no-data'>$mensaje</div>";
    }
    echo "</div>";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Registros</title>
    <link rel="stylesheet" href="/Style/gestioncita.css">
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
        .search-container {
            margin: 15px 0;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .search-form {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        .search-input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        .search-input:invalid {
            border-color: #e74c3c;
        }
        .search-button {
            padding: 10px 20px;
            background-color: #4e73df;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .search-button:hover {
            background-color: #2e59d9;
        }
        .clear-search {
            padding: 10px 15px;
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-left: 10px;
            display: inline-block;
            transition: background-color 0.3s;
        }
        .clear-search:hover {
            background-color: #5a6268;
            color: white;
        }
        .container {
            max-width: 900px;
            margin: 40px auto;
        }
        .table-section {
            margin-bottom: 30px;
        }
    </style>
    <!-- Font Awesome para el ícono -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <div class="container">
        <h2>Gestionar Registros</h2>

        <?php
        // Mapeo de nombres personalizados para PACIENTE
        $headers_paciente = [
            'ID_paciente' => 'ID',
            'Nombre_1' => 'Primer Nombre',
            'Nombre_2' => 'Segundo Nombre',
            'Apellido_1' => 'Primer Apellido',
            'Apellido_2' => 'Segundo Apellido',
            'Correo' => 'Correo Electrónico',
            'Telefono' => 'Teléfono',
            'N_documento' => 'Número de Documento',
            'Tipo_documento' => 'Tipo de Documento',
            'Fecha_nacimiento' => 'Fecha de Nacimiento',
            'Sexo' => 'Sexo'
        ];
        
        // Mapeo de nombres personalizados para PSICOLOGO
        $headers_psicologo = [
            'ID_psicologo' => 'ID',
            'Nombre_1' => 'Primer Nombre',
            'Nombre_2' => 'Segundo Nombre',
            'Apellido_1' => 'Primer Apellido',
            'Apellido_2' => 'Segundo Apellido',
            'Correo' => 'Correo Electrónico',
            'Telefono' => 'Teléfono'
        ];
        
        // Construir la consulta SQL para pacientes con filtro de búsqueda si existe
        $sql_pacientes = "SELECT ID_paciente, Nombre_1, Nombre_2, Apellido_1, Apellido_2, Correo, Telefono, 
                         N_documento, Tipo_documento, Fecha_nacimiento, Sexo FROM paciente";
        
        if(isset($_GET['busqueda']) && !empty($_GET['busqueda'])) {
            // Validar que solo contiene números
            if(preg_match('/^[0-9]+$/', $_GET['busqueda'])) {
                $busqueda = $conn->real_escape_string($_GET['busqueda']);
                $sql_pacientes .= " WHERE N_documento LIKE '%$busqueda%'";
            } else {
                echo '<script>alert("Por favor ingrese solo números para la búsqueda por cédula");</script>';
            }
        }
        
        // Tabla PACIENTE con nombres personalizados y buscador
        mostrar_tabla(
            "Pacientes",
            $sql_pacientes,
            $conn,
            $headers_paciente,
            true // Mostrar buscador
        );
        
        // Tabla PSICOLOGO con nombres personalizados
        mostrar_tabla(
            "Psicólogos",
            "SELECT ID_psicologo, Nombre_1, Nombre_2, Apellido_1, Apellido_2, Correo, Telefono FROM psicologo",
            $conn,
            $headers_psicologo
        );
        
        $conn->close();
        ?>
        <a href="/php/dashboard.php" class="volver-inicio">
            <i class="fas fa-arrow-left"></i> Volver al inicio
        </a>
    </div>

    <script>
        // Validación en el cliente para solo números
        document.querySelector('.search-input').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    </script>
</body>
</html>