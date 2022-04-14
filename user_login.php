<?php
require_once "vendor/autoload.php";
require 'db/db_connection.php';

session_start();
if(isset($_SESSION['user_type'])){
    header("location: home/home.php");
    return;
}

if (!$conn) die("Error de conexion: " . mysqli_connect_error());

$_SESSION['login_url'] = "../index.php";

$email = $_REQUEST['Email'];
$password = $_REQUEST['Password'];

$sql = "SELECT * FROM usuario
        WHERE email = '{$email}'
        AND is_admin = 0
        AND is_deleted = 0";
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

function loginFail(){
    $_SESSION['form_msg'] = "Credenciales incorrectas";
    header("location: index.php");
    return;
}

function redirectToHome($row) {
    $_SESSION['is_admin'] = $row['is_admin'];
    $_SESSION['id'] = $row['id'];
    $_SESSION['email'] = $row['email'];
    $_SESSION['name'] = $row['name'];
    $_SESSION['user_type'] = 'user';
    header("location: home/home.php");
}
?>