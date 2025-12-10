<?php
/* ARCHIVO DE CONEXIÓN A LA BASE DE DATOS*/
    $servidor = "localhost";  
    $usuario = "root"; 
    $clave = ""; // Decidí no poner contraseña para simplificar.
    $base_datos = "biblioteca"; 

    $conexion = mysqli_connect($servidor, $usuario, $clave, $base_datos);

    /*if($conexion){
        echo "Conexión exitosa a la base de datos";
    }else{
        die("Conexión fallida, error: ".mysqli_connect_error()); 
    }*/
?>