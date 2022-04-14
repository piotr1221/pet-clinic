<?php
require "../db/db_connection.php";
require "../utilities/upload_file_to_gcs.php";

session_start();
require '../utilities/check_session.php';
check_session();
check_permission(array('user'));

if (isset($_POST['submit'])) {
    $file = $_FILES['Foto'];
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

    $gcsPath = "{$_REQUEST['Codigo']}/{$fileNewName}";
    $v6 = uploadFileToGCS($fileNewTmpPath, $gcsPath);
    
    if($v6 == null) return;

    if (!$conn) die("Error de conexion: " . mysqli_connect_error());

    $v1 = $_REQUEST['Codigo'];
    $v2 = $_REQUEST['Nombre'];
    $v3 = $_REQUEST['FechNac'];
    $v4 = $_REQUEST['Raza'];
    $v5 = $_REQUEST['Genero'];
    $dni_cliente = $_REQUEST['dni_cliente'];

    $sql = "SELECT id FROM cliente WHERE dni = '{$dni_cliente}'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    $sql = "INSERT INTO Perro (DNI, Nombre, id_cliente, Raza, Genero, FechaNacimiento, Foto) ";
    $sql .= "VALUES ('$v1', '$v2', {$row['id']},'$v4', '$v5', '$v3', '$v6' )";
    echo $sql;
    return;
    if (!mysqli_query($conn, $sql)) {
        registerPetFail("Ocurrio un error al registrar la mascota");
    }
    $_SESSION['form_msg'] = "Perro registrado exitosamente";
    header("location: ../home/home.php");
}

function registerPetFail($error){
    $_SESSION['form_msg'] = $error;
    header("location: form_register_pet.php");
    return;
}

?>