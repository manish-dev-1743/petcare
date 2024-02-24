<?php

function getUrlSegment($index){
    $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uriSegments = explode('/', $uri_path);
    if(isset($uriSegments[$index+1])){
        return $uriSegments[$index+1];
    }else{
        return '';
    }
}