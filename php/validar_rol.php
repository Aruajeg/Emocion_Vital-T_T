<?php

include 'conexion_be.php';

//OBTENER EL ID_CARGO DESDE EL FORMULARIO
$ID_cargo = 2;

//VALIDAR QUE EL CARGO EXISTA
$sql_verificar = "SELECT ID FROM cargo WHERE ID = $ID_cargo";
$resultado = mysqli_query($conexion, $sql_verificar);

if (mysqli_num_rows($resultado) === 0){
    die("Error: El cargo seleccionado no existe (ID: $ID_cargo)");
}
?>