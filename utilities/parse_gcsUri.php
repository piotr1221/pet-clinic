<?php
    function parse_gcsUri($gcsUri){
        $split = explode( "/", substr($gcsUri, 5), 2);
        return $split;
    }
?>