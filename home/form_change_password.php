<?php
    session_start();
    require '../utilities/check_session.php';
    check_session();
    require '../utilities/form_error_msg.php';
    check_permission(array('user', 'admin', 'client'));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="../styles/style.css" rel="stylesheet">
    <title>Configurar cuenta</title>
</head>

<body>
    <?php
        require '../snippets/navbar.php';
         echo go_back(false, "../home/home.php");
    ?>
    <div class="container">
        <div class="row content">
            <form class="transbox center" action="change_password.php" method="POST">
                <h2>Cambio de contraseña</h2>
                <?php
                $msg;
                if($_SESSION['user_type'] == 'user' or $_SESSION['user_type'] == 'admin') {
                    $msg = "Email";
                    $name = "email";
                } elseif ($_SESSION['user_type'] == 'client') {
                    $msg = "DNI";
                    $name = "dni";
                }
                echo "<label for='text'>{$msg}</label>
                    <Input type='text' name={$name} class='form-control'>"
                ?>
                <div class="form-group">
                    <label for="email">Contraseña nueva</label>
                    <input type="text" name="password1" class="form-control" required>
                </div>
                <br>
                <div class="form-group">
                    <label for="text">Repetir contraseña nueva</label>
                    <input type="text" name="password2" class="form-control" required>
                </div>
                <br>
                <button type="submit" name="submit" class="btn btn-primary">Registrar</button>
                <label for="submit">(Seras redirigido al inicio se sesion)</label>
                <p></p>
            </form>
        </div>
    </div>
</body>
</html>