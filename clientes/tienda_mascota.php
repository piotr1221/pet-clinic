<?php
session_start();
require_once "../vendor/autoload.php";
require "../db/db_connection.php";
require "../utilities/parse_gcsUri.php";
require '../utilities/check_session.php';
check_session();
require '../utilities/form_error_msg.php';
check_permission(array('admin', 'client'));
use Google\Cloud\Storage\StorageClient;

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

?>

<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='utf-8' />
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no' />
    <title>Sistema de registro perruno</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css' rel='stylesheet' />
    <link href='../styles/style_home.css' rel='stylesheet' />
</head>
<body>
    <?php
        require '../snippets/navbar.php';
        echo go_back(false, "../home/home.php");
    ?>

    <div class="container">
        <div class="row">
            <?php
                $sql = "SELECT * FROM productos";
                $result = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($result);
                for ($i = 0; $i < $count; $i++) {
                    $row = mysqli_fetch_array($result);
                    $redisKey = "product_image_{$row['id']}";
                    $imgUrl = getImgUrl($redisKey, $row['url']);
                    echo "<div class='col-12 col-md-4'>
                    <div class='card mb-4'>
                        <img clas='card-img-top' src='{$imgUrl}' style='height:300px;width:100%;' alt='Imagen no disponible'>
                        <div class='card-body'>
                            <h2 class='h4 card-title'>{$row['nombre']}</h2>
                            <h3 class='h5 card-subtitle mb-3'>S./ {$row['precio']} - Stock {$row['stock']}</h3>
                            <p class='card-text'>{$row['descripcion']}</p>
                            <form action='producto_comprado.php' method='POST'>
                                <input name='product_id' value={$row['id']} hidden>
                                <button type='submit' name='submit' class='btn btn-primary'>Comprar</button>
                            </form>
                        </div>
                    </div>
                </div>";
                }
            ?>
        </div>
    </div>

</body>
</html>