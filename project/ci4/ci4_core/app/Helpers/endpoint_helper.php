<?php 

function api_endpoint($params=""){
    $endpoint = "http://192.168.1.70:7038/api/".$params;
    return $endpoint;

    
}
