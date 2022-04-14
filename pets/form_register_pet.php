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
    <title>Registrar perro</title>
</head>

<body>
        <?php
            require '../snippets/navbar.php';
            echo go_back(false, "../home/home.php");
        ?>
    <div class="container">
        <div class="row content">
            <form class="transbox center" action="register_pet.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="text">DNI</label>
                    <input type="text" name="Codigo" class="form-control">
                </div>
                <div class="form-group">
                    <label for="text">Nombre</label>
                    <input type="text" name="Nombre" class="form-control">
                </div>
                <div class="form-group">
                    <label for="text">DNI Cliente</label>
                    <input type="text" name="dni_cliente" class="form-control">
                </div>
                <div class="form-group">
                    <label for="date">Fecha de nacimiento</label>
                    <input type="date" name="FechNac" class="form-control">
                </div>
                <div class="form-group">
                    <label for="radio">Genero</label>
                    <input type="radio" class="form-check-input" id="radio1" name="Genero" value="1" checked> Macho
                    <label class="form-check-label" for="radio1"></label>
                    <input type="radio" class="form-check-input" id="radio2" name="Genero" value="0"> Hembra
                    <label class="form-check-label" for="radio2"></label>
                </div>
                <div class="form-group">
                    <label for="text">Raza</label>
                    <select class="form-select" name="Raza">
                        <option value="Pitbull">Pitbull</option>
                        <option value="Bulldog">Bulldog</option>
                        <option value="Shichu">Shichu</option>
                        <option value="Pequines">Pequines</option>
                        <option value="San Bernardo">San Bernardo</option>
                        <option value="Chiguahua">Chiguahua</option>
                        <option value="N/A">N/A</option>
                    </select>
                </div>
                <br>
                <div class="form-group">
                    <label for="file">Foto</label>
                    <br>
                    <input type="file" name="Foto">
                </div>
                <br>
                <button type="submit" name="submit" class="btn btn-primary">Registrar</button>
                <p></p>
            </form>
        </div>
    </div>
</body>

</html>