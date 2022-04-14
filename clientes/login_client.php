<?php
require_once "../vendor/autoload.php";
require '../db/db_connection.php';
session_start();
if(isset($_SESSION['user_type'])){
    header("location: home/home.php");
    return;
}

if (isset($_POST['submit'])) {
    if (!$conn) die("Error de conexion: " . mysqli_connect_error());

    $_SESSION['login_url'] = "../clientes/form_login_client.php";

    $dni = $_REQUEST['dni'];
    $password = $_REQUEST['password'];

    $sql = "SELECT * FROM cliente WHERE dni = '{$dni}'";
    $result = mysqli_query($conn, $sql);

    if (!isset($result)) {
        loginFail();
        return;
    }

    $row = mysqli_fetch_array($result);

    if (!password_verify($password, $row['password']) or $row['is_deleted'] == 1){
        loginFail();
        return;
    }

    redirectToHome($row);
}
function loginFail(){
    $_SESSION['form_msg'] = "Credenciales incorrectas";
    header("location: form_register_client.php");
    return;
}

function redirectToHome($row) {
    $_SESSION['id'] = $row['id'];
    $_SESSION['dni'] = $row['dni'];
    $_SESSION['is_client'] = 1;
    $_SESSION['user_type'] = 'client';
    header("location: ../home/home.php");
}
?>