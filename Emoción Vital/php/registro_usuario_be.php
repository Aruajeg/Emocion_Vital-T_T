<?php

    include 'conexion_be.php';
    
    $Correo = $_POST['correo'];
    $Username = $_POST['username'];
    $Contrasena = $_POST['contrasena'];
    $verificar_contrasena = $_POST['verificar_contrasena'];
    $ID_cargo = $_POST['ID_cargo'];
    

    $query = "INSERT INTO usuario(correo, username, contrasena, ID_cargo) VALUES ('$Correo', '$Username', MD5('$Contrasena'), '$ID_cargo')";

    //Verificar que el correo no se repita en la BD
    $verificar_correo = mysqli_query($conexion, "SELECT * FROM usuario WHERE correo = '$Correo' ");

    if(mysqli_fetch_array($verificar_correo) > 0){
        echo '<script> 
            alert("Este correo ya esta registrado, intenta con otro diferente");
            window.location = "../login_register.php";
        </script>';
        exit();
    }

    //Verificar que el usuario no se repita en la BD
    $verificar_usuario = mysqli_query($conexion, "SELECT * FROM usuario WHERE username = '$Username' ");

    if(mysqli_fetch_array($verificar_usuario) > 0){
        echo '<script> 
            alert("Este usuario ya esta registrado, intenta con otro diferente");
            window.location = "../login_register.php";
        </script>';
        exit();
    }

    $ejecutar =mysqli_query($conexion, $query);
    
    if($ejecutar){
        echo'
        <script>
            alert("Nuevo usuario registrado correctamente");
            window.location = "../login_register.php";
        </script>';
    } else {
        echo'
        <script>
            alert("Error inesperado, intente nuevamente");
            window.location = "../login_register.php";
        </script>';
    }

    mysqli_close($conexion);
?>