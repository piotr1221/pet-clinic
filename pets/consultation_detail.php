<?php
require_once "../vendor/autoload.php";
require "../db/db_connection.php";
require "../utilities/parse_gcsUri.php";
use Google\Cloud\Storage\StorageClient;

session_start();
require '../utilities/check_session.php';
check_session();
check_permission(array('user', 'client'));

if (!$conn) die("Error de conexion: " . mysqli_connect_error());

$dni = $_SESSION['dni_perro_detalle'];

$sql = "SELECT * FROM consulta AS c 
        INNER JOIN usuario AS u on c.id_user = u.id 
        WHERE c.id = {$_REQUEST['consultation_id']}";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
// print_r($row);
// echo $_REQUEST['consultation_id'];
// return;
$sql = "SELECT * FROM consulta_archivos WHERE id_consulta={$_REQUEST['consultation_id']}";

$files = mysqli_query($conn, $sql);
//unset($_SESSION['dni_perro_detalle']);
generateHTML($row, $files);

function getImgUrl($dni, $gcsUri) {
    $split = parse_gcsUri($gcsUri);
    $storage = new StorageClient([
        'keyFilePath' => '../taller-web-344204-0c646a6ae3d2.json',
    ]);
    $bucket = $storage->bucket($split[0]);
    $object = $bucket->object($split[1]);

    $redis = new Predis\Client();
    $urlInfo = $redis->exists($dni);
    $url;
    if(!$urlInfo) {
        echo "<script>console.log('Hash created in redis')</script>";
        $url = generateNewUrl($object);
        $redis->hmset(
            $dni, 
            array(
                "url" => $url,
                "timestamp" => time()
            )
        );
        return $url;
    }

    $urlTimestamp = (int) $redis->hget($dni, 'timestamp');
    $nowTimestamp = time();
    if ($nowTimestamp - $urlTimestamp > 600) {
        echo "<script>console.log('Url updated')</script>";
        $url = generateNewUrl($object);
        $redis->hset($dni, "url", $url);
        $redis->hset($dni, "timestamp", $nowTimestamp);
        return $url;
    }

    return $redis->hget($dni, 'url');
}

function generateNewUrl($object) {
    $url = $object->signedUrl(
        # This URL is valid for 10 minutes
        new \DateTime('10 min'),
        [
            'version' => 'v4',
        ]
    );
    return $url;
}

function generateHTML($row, $files) {
$si = ''; $no = '';
if ($row['is_payed'] == 1){
    $si = 'checked="checked"';
} if($row['is_payed'] == 0) {
    $no = 'checked="checked"';
}

$html = "";
$html .= "<html>
    <head>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'
            integrity='sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3' crossorigin='anonymous'>
        <link href='/reloca/styles/style.css' rel='stylesheet'>
    </head>
    <body>";

    require '../snippets/navbar.php';
    echo go_back(false, "find_consultation.php");

$html .= "<form class='transbox center'>
                <div class='form-group'>
                    <label for='text'>DNI del Perro</label>
                    <input value={$row['dni_perro']} class='form-control' readonly>
                </div>
                <br>
                <div class='form-group'>
                    <label for='text'>Medico</label>
                    <input value={$row['name']} class='form-control' readonly>
                </div>
                <br>
                <div class='form-group'>
                    <label for='text'>Sintomas</label>
                    <textarea class='form-control' readonly>{$row['sintoma']}</textarea>
                </div>
                <br>
                <div class='form-group'>
                    <label for='text'>Diagnostico</label>
                    <textarea class='form-control' readonly>{$row['diagnostico']}</textarea>
                </div>
                <br>
                <div class='form-group'>
                    <label for='text'>Medicacion</label>
                    <textarea class='form-control' readonly>{$row['medicacion']}</textarea>
                </div>
                <br>
                <div class='form-group'>
                    <label for='text'>Examen de Sangre</label>
                    <textarea class='form-control' readonly>{$row['examen_sangre']}</textarea>
                </div>
                <br>
                <div class='form-group'>
                    <label for='text'>Costo</label>
                    <input type='number' value='{$row['costo']}' class='form-control' readonly>
                </div>
                <br>
                <div class='form-group'>
                    <label for='radio'>Pagado</label>
                    <input type='radio' class='form-check-input' {$si}>Si
                    <label class='form-check-label' for='radio1'></label>
                    <input type='radio' class='form-check-input' {$no}>No
                    <label class='form-check-label' for='radio2'></label>
                </div>
                <br>
                <div class='form-group'>
                    <label for='file'>Rayos X</label>
                    <br>
                </div>
                <br>";

            $num_files = mysqli_num_rows($files) + 1;
            for ($i = 1; $i < $num_files; $i++){
                $file = mysqli_fetch_array($files);
                $redisKey = "consultation_detail_file_{$file['id']}";
                $imgUrl = getImgUrl($redisKey, $file['url']);
                $html .= "<a href={$imgUrl}>Imagen {$i}</a> ";
            }

        $html .= "<p></p></form>
    </body>
    </html>";
    echo $html;
}
?>