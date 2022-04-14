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
        <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css' rel='stylesheet' />
    <link href="../styles/style.css" rel="stylesheet">
    <title>Consultar perro</title>
</head>
<body>
        <?php
            require '../snippets/navbar.php';
            echo go_back(false, "../home/home.php");
        ?>
    <div class="">
        <div class="row content">
            <form class="transbox center" action="find_pet.php" method="POST">
                <h2>Sistema de Identificacion Perruno</h2>
                
                <div class="form-group">
                    <label for="text">Nombre</label>
                    <Input type="text" name="Nombre" class="form-control">
                </div>
                <br>
                <Button type="submit" name="submit" value="Buscar" class="btn btn-primary">
                    Buscar
                </Button>
                <p></p>
            </form>
        </div>
    </div>
    <script src="../scripts/includeHTML.js"></script>
</body>
</html>