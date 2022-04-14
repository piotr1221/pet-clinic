<?php
require_once "../vendor/autoload.php";
require "../utilities/upload_file_to_gcs.php";
require "../db/db_connection.php";
use Google\Cloud\Storage\StorageClient;

session_start();
require '../utilities/check_session.php';
check_session();
check_permission(array('user'));

if (isset($_POST['submit'])) {
    if (!$conn) die("Error de conexion: " . mysqli_connect_error());

    $dni = $_REQUEST['dni'];
    $costo = $_REQUEST['costo'];
    $sintoma = $_REQUEST['sintoma'];
    $diagnostico = $_REQUEST['diagnostico'];
    $medicacion = $_REQUEST['medicacion'];
    $examen_sangre = $_REQUEST['examen_sangre'];
    $is_payed = $_REQUEST['is_payed'];

    $sql = "SELECT COUNT(*) as cuenta FROM perro WHERE DNI = {$dni}";
    $result = mysqli_query($conn, $sql);
    $perro = mysqli_fetch_array($result);

    if($perro['cuenta'] == 0) {
        registerConsultationFail("El DNI del perro no existe");
        return;
    }

    $sql = "INSERT INTO consulta (dni_perro, id_user, costo, sintoma, diagnostico, medicacion, examen_sangre, is_payed) ";
    $sql .= "VALUES ({$dni}, {$_SESSION['id']}, '{$costo}', '{$sintoma}', '{$diagnostico}', '{$medicacion}', '{$examen_sangre}', {$is_payed})";

    if (!mysqli_query($conn, $sql)) {
        registerConsultationFail("Ocurrio un error al registrar la consutla");
        return;
    }

    $sql = "SELECT id FROM consulta WHERE dni_perro = {$dni}
            ORDER BY fecha_consulta DESC LIMIT 1";

    $result = mysqli_query($conn, $sql);
    $consulta = mysqli_fetch_array($result);

    saveFiles($consulta['id'], $conn);

    $_SESSION['form_msg'] = "Consulta registrada con exito";
    header("location: ../home/home.php");
}
function registerConsultationFail($error){
    $_SESSION['form_msg'] = $error;
    header("location: form_register_consultation.php");
    echo $error;
    return;
}

function saveFiles($id_consulta, $conn) {
    $total = count($_FILES['files']['name']);
    $files = [];

    for($i=0 ; $i < $total ; $i++) {
        $fileName = $_FILES['files']['name'][$i];
        $fileTmpName = $_FILES['files']['tmp_name'][$i];
        $fileSize = $_FILES['files']['size'][$i];
        $fileError = $_FILES['files']['error'][$i];
        $fileType = $_FILES['files']['type'][$i];
        $fileNameSplit = explode('.', $fileName);
        $fileExtension = strtolower(end($fileNameSplit));

        $allowedExtensions = array('jpg', 'jpeg', 'png', 'pdf');

        if ($fileError != 0) return null;
        
        if (!in_array($fileExtension, $allowedExtensions)) return null;

        $fileNewName = uniqid('', true) . ".{$fileExtension}";
        $tmpFolder = substr($fileTmpName, 0, strrpos($fileTmpName, "\\"));
        $fileNewTmpPath = "{$tmpFolder}\\{$fileNewName}";

        move_uploaded_file($fileTmpName, $fileNewTmpPath);
        
        $gcsPath = "{$_REQUEST['dni']}/consultas/{$id_consulta}/{$fileNewName}";
        $files[] = uploadFileToGCS($fileNewTmpPath, $gcsPath);
    }

    $sql = "INSERT INTO consulta_archivos (id_consulta, url) VALUES ";
    $n = count($files) - 1;
    for($i = 0; $i < $n; $i++){
        $sql .= "({$id_consulta}, '{$files[$i]}'), ";
    }
    $sql .= "({$id_consulta}, '{$files[$n]}');";
    mysqli_query($conn, $sql);
}

?>