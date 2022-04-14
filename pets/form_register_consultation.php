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
    <title>Registrar consulta</title>
</head>

<body>
        <?php
            require '../snippets/navbar.php';
            echo go_back(false, "../home/home.php");
        ?>
    <div class="container">
        <div class="row content">
            <form class="transbox center" action="register_consultation.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="text">DNI</label>
                    <input type="text" name="dni" class="form-control">
                </div>
                <br>
                <div class="form-group">
                    <label for="text">Sintomas</label>
                    <textarea type="text" name="sintoma" class="form-control"></textarea>
                </div>
                <br>
                <div class="form-group">
                    <label for="text">Diagnostico</label>
                    <textarea type="text" name="diagnostico" class="form-control"></textarea>
                </div>
                <br>
                <div class="form-group">
                    <label for="text">Medicacion</label>
                    <textarea type="text" name="medicacion" class="form-control"></textarea>
                </div>
                <br>
                <div class="form-group">
                    <label for="text">Examen de Sangre</label>
                    <textarea type="text" name="examen_sangre" class="form-control"></textarea>
                </div>
                <br>
                <div class="form-group">
                    <label for="text">Costo</label>
                    <input type="number" name="costo" class="form-control">
                </div>
                <br>
                <div class="form-group">
                    <label for="radio">Pagado</label>
                    <input type="radio" class="form-check-input" id="radio1" name="is_payed" value="1" checked>Si
                    <label class="form-check-label" for="radio1"></label>
                    <input type="radio" class="form-check-input" id="radio2" name="is_payed" value="0">No
                    <label class="form-check-label" for="radio2"></label>
                </div>
                <br>
                <div class="form-group">
                    <label for="file">Foto</label>
                    <br>
                    <input type="file" name="files[]" multiple>
                </div>
                <br>
                <button type="submit" name="submit" class="btn btn-primary">Registrar</button>
                <p></p>
            </form>
        </div>
    </div>
</body>

</html>