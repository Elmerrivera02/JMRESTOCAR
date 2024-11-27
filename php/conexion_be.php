<?php

    $conexion = mysqli_connect("localhost", "root", "", "login_register_bd");
    if (!$conexion) {
        die("Error de conexión: " . mysqli_connect_error());
    }
    /*if($conexion){
        echo 'Conectado exitosamente';
    }else{
        echo 'No se pudo conectar a la base de datos';
    }*/
?>