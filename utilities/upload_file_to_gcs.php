<?php
require_once "../vendor/autoload.php";
use Google\Cloud\Storage\StorageClient;

function uploadFileToGCS($filePath, $gcsPath) {
    $gcsUri;
    try {
        $storage = new StorageClient([
            'keyFilePath' => '../taller-web-344204-0c646a6ae3d2.json',
        ]);
        $bucketName = 'reloca_taller_web';
        $bucket = $storage->bucket($bucketName);
        $options = [
            'name' => $gcsPath
        ];
        $object = $bucket->upload(
            fopen($filePath, 'r'),
            $options
        );
        $gcsUri = $object->gcsUri();
    } catch(Exception $e) {
        echo $e->getMessage();
        return null;
    } finally {
        unlink($filePath);
    }

    return $gcsUri;
}

?>