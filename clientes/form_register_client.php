<?php
    session_start();
    require '../utilities/check_session.php';
    check_session();
    require '../utilities/form_error_msg.php';
    check_permission(array('user'));
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
    <title>Registrar usuario</title>
</head>

<body>
    <?php
        require '../snippets/navbar.php';
         echo go_back(false, "../home/home.php");
    ?>
    <div class="container">
        <div class="row content">
            <form class="transbox center" action="register_client.php" method="POST">
                <h2>Registro de usuario</h2>
                <div class="form-group">
                    <label for="email">DNI</label>
                    <input type="text" name="dni" class="form-control" required>
                </div>
                <br>
                <div class="form-group">
                    <label for="text">Nombre</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <br>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="text" name="password" class="form-control"
                        minlength="1" required>
                </div>
                <br>
                <button type="submit" name="submit" class="btn btn-primary">Registrar</button>
                <p></p>
            </form>
        </div>
    </div>
</body>
</html>