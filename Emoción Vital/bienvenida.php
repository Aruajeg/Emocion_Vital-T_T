<?php

    session_start();

    if(!isset($_SESSION['usuario'])){
        echo '<script> 
            alert("Debes iniciar sesión para tener acceso a esta página");
            window.location = "index.php";
              </script>';
            session_destroy();
            die();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenida</title>
</head>
<body>
    <h1>Bienvenido Work in progress (God blees)</h1>
    <a href="php/cerrar_sesion.php">Cerrar sesión</a>
</body>
</html>