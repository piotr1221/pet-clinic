<?php
    function check_session() {
        if (!isset($_SESSION['user_type'])) {
            $_SESSION['form_msg'] = "No has iniciado sesion";
            if (!isset($_SESSION['login_url'])){
                header("location: ../index.php");
                return;
            }
            header("location: {$_SESSION['login_url']}");
            return;
        }
    }

    function check_permission($roles){
        if (!in_array($_SESSION['user_type'], $roles)){
            header("location: ../home/home.php");
        }
    }
?>