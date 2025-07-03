<?php
    $Correo = $_POST['correo'];
    $Contrasena = $_POST['contrasena'];    
    session_start();

    include 'conexion_be.php';

    $consulta="SELECT * FROM usuario WHERE correo='$Correo' and contrasena= MD5('$Contrasena')";
    $resultado=mysqli_query($conexion, $consulta);

    $filas=mysqli_fetch_array($resultado);

    if($filas['ID_cargo']==1){ //Administrador
        $_SESSION['usuario'] = $Correo;
        $_SESSION['id_usuario'] = $filas['ID_usuario'];
        header("location: /php/dashboard.php");
        exit;
    }else
    if($filas['ID_cargo']==2){ //Paciente
        $_SESSION['usuario'] = $Correo;
        $_SESSION['id_usuario'] = $filas['ID_usuario'];
        header("location: /php/dashboard_paciente.php");
        exit;
    }

    else {
        
        echo '<script> 
            alert("Correo o Contraseña incorrectos, por favor verifique los datos e intente nuevamente");
            window.location = "../login_register.php";
        </script>';
        exit;
    }
    mysqli_free_result($resultado);
    mysqli_close($conexion);
    ?>
