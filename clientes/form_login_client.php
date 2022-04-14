<?php
    session_start();
    if(isset($_SESSION['user_type'])){
        header("location: home/home.php");
        return;
    }
    require '../utilities/form_error_msg.php';
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
    <title>Login</title>
</head>
<body style="background-image: url('../images/perros.jpg');">
    <div class="container">
        <div class="row content">
            <form class="transbox center" action="login_client.php" method="POST">
                <h2>Acceso para clientes</h2>
                
                <div class="form-group">
                    <label for="text">DNI</label>
                    <Input type="text" name="dni" class="form-control"
                    required="required">
                </div>
                <div class="form-group">
                    <label for="text">Password</label>
                    <Input type="text" name="password" class="form-control"
                        required="required" minlength="1">
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