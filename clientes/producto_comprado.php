<?php
    require '../db/db_connection.php';
    session_start();
    $_SESSION['form_msg'] = "Producto comprado";

    $sql = "UPDATE productos SET
            stock = ((SELECT stock FROM productos WHERE id = {$_POST['product_id']}) - 1)
            WHERE id = {$_POST['product_id']}";

    $result = mysqli_query($conn, $sql);

    header("location: tienda_mascota.php");
?>