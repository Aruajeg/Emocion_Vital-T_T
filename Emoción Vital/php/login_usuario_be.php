<?php

    session_start();

    include 'conexion_be.php';

    $Correo = $_POST['correo'];
    $Contrasena = $_POST['contrasena'];

    $validar_login = mysqli_query($conexion, "SELECT * FROM usuario WHERE correo='$Correo' and contrasena='$Contrasena'");

    if(mysqli_num_rows($validar_login) > 0){
        $_SESSION['usuario'] = $Correo;
        header("location: ../bienvenida.php");
        exit;
    } else {
        echo '<script> 
            alert("Correo o Contraseña incorrectos, por favor verifique los datos e intente nuevamente");
            window.location = "../login_register.php";
        </script>';
        exit;
    }


?>