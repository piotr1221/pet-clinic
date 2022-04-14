<?php
require "../db/db_connection.php";
session_start();
require '../utilities/check_session.php';
check_session();
check_permission(array('admin', 'user', 'client'));

if (isset($_POST['submit'])) {
    if ($_POST['password1'] != $_POST['password2']){
        changePasswordFail("Las contraseñas no coinciden");
        return;
    }

    $sql;
    if ($_SESSION['user_type'] == 'user' or $_SESSION['user_type'] == 'admin') {
        $sql = "SELECT * FROM usuario
                WHERE email = '{$_POST['email']}'
                AND id = {$_SESSION['id']}";
    } elseif ($_SESSION['user_type'] == 'client') {
        $sql = "SELECT * FROM cliente
                WHERE dni = {$_POST['dni']}
                AND id = {$_SESSION['id']}";
    }

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 0){
        changePasswordFail("Dato erroneo");
        return;
    }

    $hash = password_hash($_POST['password1'], PASSWORD_DEFAULT);

    if ($_SESSION['user_type'] == 'user' or $_SESSION['user_type'] == 'admin') {
        $sql = "UPDATE usuario
                SET password = '{$hash}'
                WHERE id = {$_SESSION['id']}";
    } elseif ($_SESSION['user_type'] == 'client') {
        $sql = "UPDATE cliente
                SET password = '{$hash}'
                WHERE id = {$_SESSION['id']}";
    }
    mysqli_query($conn, $sql);
    redirectToLogin();
}

function changePasswordFail($msg){
    $_SESSION['form_msg'] = $msg;
    header("location: form_change_password.php");
    return;
}

function redirectToLogin() {
    session_destroy();
    echo "<script>alert('Contraseña cambiada correctamente')</script>";
    header("location: ../index.php");
    exit();
}

?>