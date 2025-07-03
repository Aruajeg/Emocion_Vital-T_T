<?php
// Consultacitas.php
session_start();
if(!isset($_SESSION['usuario'])){
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

// Función para mostrar tablas de forma agradable con encabezados personalizados y exclusión de columnas
function mostrar_tabla($titulo, $sql, $conn, $headers) {
    $result = $conn->query($sql);
    echo "<div class='table-section'>";
    echo "<h2>$titulo</h2>";
    if ($result && $result->num_rows > 0) {
        echo "<div class='table-container'><table class='table-citas'><tr>";
        // Encabezados personalizados
        foreach ($headers as $header) {
            echo "<th>" . htmlspecialchars($header) . "</th>";
        }
        echo "</tr>";
        // Filas
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach($row as $cell) {
                echo "<td>" . htmlspecialchars($cell) . "</td>";
            }
            echo "</tr>";
        }
        echo "</table></div>";
    } else {
        echo "<div class='no-data'>No hay registros</div>";
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
    </style>
    <!-- Font Awesome para el ícono -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <div class="container" style="max-width:900px;margin:40px auto;">
        <h2>Gestionar Registros</h2>
        <?php
        // Tabla PACIENTE
        mostrar_tabla(
            "Pacientes",
            "SELECT Nombre_1, Nombre_2, Apellido_1, Apellido_2, Correo, Telefono, N_documento, Tipo_documento, Fecha_nacimiento, Sexo FROM paciente",
            $conn,
            [
                "Primer Nombre", "Segundo Nombre", "Primer Apellido", "Segundo Apellido",
                "Correo", "Teléfono", "Número de Documento", "Tipo de Documento",
                "Fecha de Nacimiento", "Sexo"
            ]
        );
        // Tabla PSICOLOGO
        mostrar_tabla(
            "Psicólogos",
            "SELECT Nombre_1, Nombre_2, Apellido_1, Apellido_2, Correo, Telefono FROM psicologo",
            $conn,
            [
                "Primer Nombre", "Segundo Nombre", "Primer Apellido", "Segundo Apellido",
                "Correo", "Teléfono"
            ]
        );
        $conn->close();
        ?>
        <a href="/php/dashboard.php" class="volver-inicio">
            <i class="fas fa-arrow-left"></i> Volver al inicio
        </a>
    </div>
</body>
</html>