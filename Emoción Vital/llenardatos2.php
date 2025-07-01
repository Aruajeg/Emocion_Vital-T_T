<?php
// Conexión y procesamiento del formulario
$host = "localhost";
$user = "root";
$pass = "";
$db = "implantacion";
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

function validar_texto($texto, $min = 2, $max = 30) {
    return preg_match("/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{{$min},{$max}}$/u", $texto);
}
function validar_correo($correo) {
    return filter_var($correo, FILTER_VALIDATE_EMAIL) &&
           preg_match('/@(gmail|hotmail|yahoo|outlook|icloud|live|edu|gov|mail|protonmail|gmx|aol|zoho|yandex|correo|company|empresa|instituto|co|ve|mx|ar|cl|pe|uy|ec|bo|py|br|cr|gt|hn|ni|pa|sv|do|cu|pr|us)\./i', $correo);
}
function validar_numero($numero, $min = 5, $max = 20) {
    return preg_match("/^[0-9]{{$min},{$max}}$/", $numero);
}
function validar_telefono($telefono) {
    return preg_match("/^[0-9]{7,15}$/", $telefono);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre1 = trim($_POST["nombre1"]);
    $nombre2 = trim($_POST["nombre2"]);
    $apellido1 = trim($_POST["apellido1"]);
    $apellido2 = trim($_POST["apellido2"]);
    $correo = trim($_POST["correo"]);
    $telefono = trim($_POST["telefono"]);
    $n_documento = trim($_POST["n_documento"]);
    $tipo_documento = trim($_POST["tipo_documento"]);
    $fecha_nacimiento = trim($_POST["fecha_nacimiento"]);
    $sexo = trim($_POST["sexo"]);
    $desc_paciente = trim($_POST["desc_paciente"]);

    // Validaciones
    if (
        !validar_texto($nombre1) ||
        ($nombre2 && !validar_texto($nombre2, 0, 30)) ||
        !validar_texto($apellido1) ||
        ($apellido2 && !validar_texto($apellido2, 0, 30)) ||
        !validar_correo($correo) ||
        !validar_telefono($telefono) ||
        !validar_numero($n_documento, 5, 20) ||
        !in_array($tipo_documento, ['V','E','P','J']) ||
        !preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha_nacimiento) ||
        !in_array($sexo, ['Masculino','Femenino','Otro']) ||
        strlen($desc_paciente) < 5
    ) {
        $mensaje = urlencode("Datos inválidos. Verifique los campos e intente de nuevo.");
        header("Location: llenardatos.php?mensaje=$mensaje");
        exit();
    }

    // Escapar para SQL
    $nombre1 = $conn->real_escape_string($nombre1);
    $nombre2 = $conn->real_escape_string($nombre2);
    $apellido1 = $conn->real_escape_string($apellido1);
    $apellido2 = $conn->real_escape_string($apellido2);
    $correo = $conn->real_escape_string($correo);
    $telefono = $conn->real_escape_string($telefono);
    $n_documento = $conn->real_escape_string($n_documento);
    $tipo_documento = $conn->real_escape_string($tipo_documento);
    $fecha_nacimiento = $conn->real_escape_string($fecha_nacimiento);
    $sexo = $conn->real_escape_string($sexo);
    $desc_paciente = $conn->real_escape_string($desc_paciente);

    $sql = "INSERT INTO paciente (ID_usuario, ID_direccion, Nombre_1, Nombre_2, Apellido_1, Apellido_2, Contrasena, Status, Correo, Telefono, N_documento, Tipo_documento, Fecha_nacimiento, P1, RP1, P2, RP2, Desc_paciente, Tipo_paciente, Sexo)
            VALUES (0, 0, '$nombre1', '$nombre2', '$apellido1', '$apellido2', '', 'Activo', '$correo', '$telefono', '$n_documento', '$tipo_documento', '$fecha_nacimiento', '', '', '', '', '$desc_paciente', 'Adulto', '$sexo')";
    if ($conn->query($sql) === TRUE) {
        // Registro exitoso, redirigir al dashboard
        header("Location: /php/dashboard.php");
        exit();
    } else {
        // Si hay error, regresar al formulario con mensaje
        $mensaje = urlencode("Error: " . $conn->error);
        header("Location: llenardatos.php?mensaje=$mensaje");
        exit();
    }
}
?>