<?php
require_once "../vendor/autoload.php";
require "../db/db_connection.php";
require "../utilities/parse_gcsUri.php";

use Google\Cloud\Storage\StorageClient;

if (!$conn) die("Error de conexion: " . mysqli_connect_error());

$dni = intval($_POST['dni']);

$sql = "SELECT * FROM consulta AS c 
        INNER JOIN usuario AS u on c.id_user = u.id 
        WHERE dni_perro = {$dni}";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

$id_consulta = intval($_POST['id_consulta']);
$sql = "SELECT * FROM consulta_archivos WHERE id_consulta={$id_consulta}";
$files = mysqli_query($conn, $sql);
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
}
?>

<html>
<head>
<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'
        integrity='sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3' crossorigin='anonymous'>
    <link href='../styles/style.css' rel='stylesheet'>
</head>
<body style='background-image:none;'>
<form class='transbox center'>
    <div class='form-group'>
        <label for='text'>DNI del Perro</label>
        <input value='<?php $row['dni_perro'] ?>' class='form-control' readonly>
    </div>
    <br>
    <div class='form-group'>
        <label for='text'>Medico</label>
        <input value='<?php $row['name'] ?>' class='form-control' readonly>
    </div>
    <br>
    <div class='form-group'>
        <label for='text'>Sintomas</label>
        <textarea class='form-control' readonly><?php $row['sintoma'] ?></textarea>
    </div>
    <br>
    <div class='form-group'>
        <label for='text'>Diagnostico</label>
        <textarea class='form-control' readonly><?php $row['diagnostico'] ?></textarea>
    </div>
    <br>
    <div class='form-group'>
        <label for='text'>Medicacion</label>
        <textarea class='form-control'><?php $row['medicacion'] ?></textarea>
    </div>
    <br>
    <div class='form-group'>
        <label for='text'>Examen de Sangre</label>
        <textarea class='form-control'><?php $row['examen_sangre'] ?></textarea>
    </div>
    <br>
    <div class='form-group'>
        <label for='text'>Costo</label>
        <input type='number' value=<?php $row['costo'] ?> class='form-control'>
    </div>
    <br>
    <div class='form-group'>
        <label for='radio'>Pagado</label>
        <input type='radio' class='form-check-input' <?php $si ?>>Si
        <label class='form-check-label' for='radio1'></label>
        <input type='radio' class='form-check-input' <?php $no ?>>No
        <label class='form-check-label' for='radio2'></label>
    </div>
    <br>
    <div class='form-group'>
        <label for='file'>Rayos X</label>
        <br>
    </div>
    <br>
    <?php
        $num_files = mysqli_num_rows($files);
        for ($i = 0; $i < $num_files; $i++){
            $file = mysqli_fetch_array($files);
            $redisKey = "consultation_detail_file_{$file['id']}";
            $imgUrl = getImgUrl($redisKey, $file['url']);
            $imgClass = 'img-row';
            $style = 'width:250px;height:250px;';
            $html .= "<img src={$imgUrl}  style=$style>";
        }
    ?>
    </form>
</body>
</html>