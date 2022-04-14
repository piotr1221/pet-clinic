<?php
require '../db/db_connection.php';
session_start();
require '../utilities/check_session.php';
check_session();
check_permission(array('user'));

if (isset($_POST['submit'])) {
    $dni = $_POST['dni'];
    $name = $_POST['name'];
    $password = $_POST['password'];

    $hashPassword = password_hash($password, PASSWORD_DEFAULT);

    if (!$conn) die("Error de conexion: " . mysqli_connect_error());

    $sql = "INSERT INTO cliente (name, dni, password) ";
    $sql .= "VALUES ('$name', '$dni', '$hashPassword')";

    if (!mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Ocurrio un error durante el registro. Intente de nuevo.');
                window.location.href='FormRegistrarPersona.html';
            </script>";
    }

    redirectToHome("Cliente registrado exitosamente");
}

function redirectToHome($msg) {
    $_SESSION['form_msg'] = $msg;
    header("location: ../home/home.php");
}

?>