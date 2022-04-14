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

if (isset($_REQUEST['name'])){
    $_SESSION['name_perro_detalle'] = $_REQUEST['name'];
} elseif (isset($_REQUEST['dni'])) {
    $_SESSION['dni_perro_detalle'] = $_REQUEST['dni'];
}

$sql;
if ($_SESSION['user_type'] == 'client') {
    $sql = "SELECT * FROM consulta AS c INNER JOIN perro AS p
            ON c.dni_perro = p.DNI
            WHERE p.Nombre LIKE '{$_SESSION['name_perro_detalle']}'
            AND p.id_cliente = {$_SESSION['id']}
            ORDER BY c.fecha_consulta DESC";
} elseif ($_SESSION['user_type'] == 'user') {
    $sql = "SELECT * FROM consulta WHERE dni_perro = {$_SESSION['dni_perro_detalle']}
            ORDER BY fecha_consulta DESC";
}

$result = mysqli_query($conn, $sql);
generateHTML($result);

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
    <body style='background-image:none'>";

    require '../snippets/navbar.php';
    echo go_back(false, "form_find_consultation.php");

echo "<table class='table table-striped'>
    <thead>
        <tr>
        <th scope='col'>ID CONSULTA</th>
        <th scope='col'>Costo</th>
        <th scope='col'>Fecha</th>
        <th scope='col'>Sintomas</th>
        <th scope='col'>Diagnostico</th>
        <th scope='col'>Examen de sangre</th>";
        if ($_SESSION['user_type'] == 'user') {
            echo "<th scope='col'>Ver mas</th>
                </tr>";
        }

echo "</thead>
    <tbody>";
        $num_resultados = mysqli_num_rows($result);
        $debt = 0;
        for ($i=0; $i < $num_resultados; $i++) {
            $row = mysqli_fetch_array($result);
            $color = "";
            if ($row['is_payed'] == 0) {
                $debt += $row['costo'];
                $color = "gray";
            } else {
                $color = "white";
            }
            echo "<tr style='font-weight:bold; font-size:22px; background-color:{$color}'>
                    <td>{$row['id']}</td>
                    <td>{$row['costo']}</td>
                    <td>{$row['fecha_consulta']}</td>
                    <td>{$row['sintoma']}</td>
                    <td>{$row['diagnostico']}</td>
                    <td>{$row['examen_sangre']}</td>";
                    if ($_SESSION['user_type'] == 'user') {
                        echo "<td>
                            <form action='consultation_detail.php'>
                                <input name='consultation_id' value={$row['id']} hidden>
                                <button type='submit' class='btn btn-primary'>Ver detalle</button>
                            </form>
                        </td>";
                    }
                echo "</tr>";
        }
        
    echo "</tbody>
    </table>
    <p style='font-size:30px;font-weight:bold;'>Deuda total: {$debt}</p>
    </body>
    </html>";
}
?>