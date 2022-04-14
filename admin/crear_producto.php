<?php
require '../db/db_connection.php';
require "../utilities/upload_file_to_gcs.php";
session_start();
require '../utilities/check_session.php';
check_session();
check_permission(array('admin'));

if (isset($_POST['submit'])) {
    $file = $_FILES['image'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];
    $fileNameSplit = explode('.', $fileName);
    $fileExtension = strtolower(end($fileNameSplit));
    $allowedExtensions = array('jpg', 'jpeg', 'png');

    if ($fileError != 0) return;
    
    if (!in_array($fileExtension, $allowedExtensions)) return;

    $fileNewName = uniqid('', true) . ".{$fileExtension}";
    $tmpFolder = substr($fileTmpName, 0, strrpos($fileTmpName, "\\"));
    $fileNewTmpPath = "{$tmpFolder}\\{$fileNewName}";

    move_uploaded_file($fileTmpName, $fileNewTmpPath);

    $gcsPath = "productos/{$fileNewName}";
    $v6 = uploadFileToGCS($fileNewTmpPath, $gcsPath);

    if($v6 == null) return;

    if (!$conn) die("Error de conexion: " . mysqli_connect_error());

    $sql = "INSERT INTO productos (nombre, descripcion, precio, url, stock) VALUES
            ('{$_POST['name']}', '{$_POST['descripcion']}',
            {$_POST['precio']}, '{$v6}', {$_POST['stock']})";

    $result = mysqli_query($conn, $sql);
    if (!$result){
        addFail();
        return;
    }

    redirectToHome();
}

function addFail() {
    $_SESSION['form_msg'] = "Ocurrio un fallo al intentar registrar el producto";
    header("location: form_crear_producto.php");
    return;
}

function redirectToHome() {
    $_SESSION['form_msg'] = "Producto añadido exitosamente";
    header("location: ../home/home.php");
}
?>