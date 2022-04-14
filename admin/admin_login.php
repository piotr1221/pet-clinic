<?php
require_once "../vendor/autoload.php";
require "../db/db_connection.php";

session_start();
if(isset($_SESSION['user_type'])){
    header("location: home/home.php");
    return;
}

if (isset($_POST['submit'])) {
    if (!$conn) die("Error de conexion: " . mysqli_connect_error());

    $_SESSION['login_url'] = "../admin/form_admin_login.php";

    $email = $_REQUEST['Email'];
    $password = $_REQUEST['Password'];

    $sql = "SELECT * FROM usuario WHERE email = '{$email}' AND is_admin = 1";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) == 0){
        loginFail();
        return;
    }

    $row = mysqli_fetch_array($result);

    if (!password_verify($password, $row['password']) or $row['is_deleted'] == 1){
        loginFail();
        return;
    }

    redirectToAdminHome($row);
}
function loginFail(){
    $_SESSION['form_msg'] = "Credenciales incorrectas";
    header("location: form_admin_login.php");
    return;
}

function redirectToAdminHome($row) {
    $_SESSION['is_admin'] = $row['is_admin'];
    $_SESSION['id'] = $row['id'];
    $_SESSION['email'] = $row['email'];
    $_SESSION['name'] = $row['name'];
    $_SESSION['user_type'] = 'admin';
    header("location: ../home/home.php");
}
?>