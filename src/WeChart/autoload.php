<?php
function __autoload($className) {
    $parts = explode("\\", $className);
    array_shift($parts);

    $classPath = dirname(__FILE__)."/".implode('/', $parts).'.php';
    if(file_exists($classPath)){
        require_once($classPath);
    } else {
        echo 'class file '.$classPath.' not found!';
    }
}