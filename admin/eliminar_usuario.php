<?php
require '../db/db_connection.php';
session_start();
require '../utilities/check_session.php';
check_session();
check_permission(array('admin'));

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!$conn) die("Error de conexion: " . mysqli_connect_error());

    $sql = "SELECT * FROM usuario
            WHERE id = {$_SESSION['id']}
            AND is_admin = 1
            AND is_deleted = 0";

    $result = mysqli_query($conn, $sql);
    if (!$result) {
        eliminateFail();
        return;
    }

    $admin = mysqli_fetch_array($result);
    if (!password_verify($password, $admin['password'])){
        eliminateFail();
        return;
    }

    $sql = "UPDATE usuario SET is_deleted = 1 WHERE email = '{$email}'";
    mysqli_query($conn, $sql);
    redirectToHome();
}

function eliminateFail() {
    $_SESSION['form_msg'] = "Datos incorrectos";
    header("location: form_eliminar_usuario.php");
    return;
}

function redirectToHome() {
    $_SESSION['form_msg'] = "Eliminacion de usuario exitosa";
    header("location: ../home/home.php");
}

?>