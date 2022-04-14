<?php
require_once "../vendor/autoload.php";
require "../db/db_connection.php";
require "../utilities/parse_gcsUri.php";

use Google\Cloud\Storage\StorageClient;

session_start();
require '../utilities/check_session.php';
check_session();
check_permission(array('user', 'client'));

if (isset($_POST['submit'])) {
    if (!$conn) die("Error de conexion: " . mysqli_connect_error());

    $v2 = $_REQUEST['Nombre'];

    $sql = "select * from Perro where Nombre like '".$v2."'";
    $result = mysqli_query($conn, $sql);

    generateHTML($result);
}

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

function generateHTML($result) {
echo "<html>
    <head>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'
            integrity='sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3' crossorigin='anonymous'>
        <link href='/reloca/styles/style.css' rel='stylesheet'>
    </head>
    <body style='background-image:none;'>";

    require '../snippets/navbar.php';
    echo go_back(false, "form_find_pet.php");

echo "<table class='table table-striped'>
    <thead>
        <tr>
        <th scope='col'>#</th>
        <th scope='col'>DNI</th>
        <th scope='col'>Nombre</th>
        <th scope='col'>Raza</th>
        <th scope='col'>Genero</th>
        <th scope='col'>FechaNacimiento</th>
        <th scope='col'>Foto</th>
        </tr>
    </thead>
    <tbody>";
        $num_resultados = mysqli_num_rows($result) + 1;
        for ($i=1; $i < $num_resultados; $i++) {
            $row = mysqli_fetch_array($result);
            $imgClass = 'img-row';
            $imgUrl = getImgUrl($row['DNI'], $row['Foto']);
            $genero;
            if ($row['Genero'] == 1) {
                $genero = 'Macho';
            } else {
                $genero = 'Hembra';
            }
            echo "<tr style='font-weight:bold; font-size:22px;'>
                    <th scope='row'>{$i}</th>
                    <td>{$row['DNI']}</td>
                    <td>{$row['Nombre']}</td>
                    <td>{$row['Raza']}</td>
                    <td>{$genero}</td>
                    <td>{$row['FechaNacimiento']}</td>
                    <td><img class={$imgClass} src={$imgUrl}></td>
                </tr>";
        }
        
    echo "</tbody>
    </table>
    </body>
    </html>";
}
?>