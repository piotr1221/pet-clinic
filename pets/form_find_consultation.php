<?php
session_start();
require '../utilities/check_session.php';
check_session();
require '../utilities/form_error_msg.php';
check_permission(array('user', 'client'));
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
    <title>Consultar perro</title>
</head>
<body>
        <?php
            require '../snippets/navbar.php';
            echo go_back(false, "../home/home.php");
        ?>
    <div class="container">
        <div class="row content">
            <form class="transbox center" action="find_consultation.php" method="POST">
                <div style="text-align:center">
                    <h1>Sistema de Identificacion Perruno</h1>
                    <h2>Buscador de consultas medicas</h2>
                </div>
                <br>
                <div class="form-group">
                    
                <?php
                $msg;
                if($_SESSION['user_type'] == 'user') {
                    $msg = "DNI de la mascota";
                    $name = "dni";
                } elseif ($_SESSION['user_type'] == 'client') {
                    $msg = "Nombre de la mascota";
                    $name = "name";
                }
                echo "<label for='text'>{$msg}</label>
                    <Input type='text' name={$name} class='form-control'>"
                ?>

                </div>
                <br>
                <Button type="submit" name="submit" value="Buscar" class="btn btn-primary">
                    Buscar
                </Button>
                <p></p>
            </form>
        </div>
    </div>
</body>
</html>