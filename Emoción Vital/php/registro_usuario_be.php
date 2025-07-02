<?php

    include 'conexion_be.php';
    $ID_cargo = 2;

//VALIDAR QUE EL CARGO EXISTA
$sql_verificar = "SELECT ID FROM cargo WHERE ID = $ID_cargo";
$resultado = mysqli_query($conexion, $sql_verificar);

if (mysqli_num_rows($resultado) === 0){
    die("Error: El cargo seleccionado no existe (ID: $ID_cargo)");
}   
    $Correo = $_POST['correo'];
    $Username = $_POST['username'];
    $Contrasena = $_POST['contrasena'];
    $verificar_contrasena = $_POST['verificar_contrasena'];

    $query = "INSERT INTO usuario(correo, username, contrasena) VALUES('$Correo', '$Username', MD5('$Contrasena'))";

    //Verificar que el correo no se repita en la BD
    $verificar_correo = mysqli_query($conexion, "SELECT * FROM usuario WHERE correo = '$Correo' ");

    if(mysqli_num_rows($verificar_correo) > 0){
        echo '<script> 
            alert("Este correo ya esta registrado, intenta con otro diferente");
            window.location = "../login_register.php";
        </script>';
        exit();
    }

    //Verificar que el usuario no se repita en la BD
    $verificar_usuario = mysqli_query($conexion, "SELECT * FROM usuario WHERE username = '$Username' ");

    if(mysqli_num_rows($verificar_usuario) > 0){
        echo '<script> 
            alert("Este usuario ya esta registrado, intenta con otro diferente");
            window.location = "../login_register.php";
        </script>';
        exit();
    }
    
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