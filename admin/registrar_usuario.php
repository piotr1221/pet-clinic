<?php
require '../db/db_connection.php';
session_start();
require '../utilities/check_session.php';
check_session();
check_permission(array('admin'));

if (isset($_POST['submit'])) {
    $nombre = $_POST['Nombre'];
    $email = $_POST['Email'];
    $password = $_POST['Password'];
    if (!matchRegex($password)){
        echo "<script>
                alert('La contraseña no cumple el estandar.');
                window.location.href='form_registrar_usuario.php';
            </script>";
            return;
    }
    $hashPassword = password_hash($password, PASSWORD_DEFAULT);

    if (!$conn) die("Error de conexion: " . mysqli_connect_error());

    $sql = "INSERT INTO usuario (email, password, name) ";
    $sql .= "VALUES ('$email', '$hashPassword', '$nombre')";
    
    if (!mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Ocurrio un error durante el registro. Intente de nuevo.');
                window.location.href='form_registrar_usuario.php';
            </script>";
    }
    echo "<script>
            alert('Usuario registrado exitosamente');
            window.location.href='../home/home.php';
        </script>";
}

function matchRegex($password) {
    // $numeric = "(?=(?:.*?[0-9]){2})";
    // $upperCase = "(?=(?:.*?[A-Z]){1})";
    // $special = "(?=(?:.*?[#$%&/?]){2})";
    // $lowerCase = "(?=(?:.*?[a-z]){1})";
    // $characters = "[A-Za-z0-9\W]";
    // $minLenght = "{8,}";

    // $regex = "~^{$numeric}{$upperCase}{$special}{$lowerCase}{$characters}{$minLenght}$~";
    $regex = "~^[\W]{1,}$~";
    $match = preg_match($regex, $password);
    return $match;
}

?>