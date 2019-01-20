<?php
    ini_set('diplay_errors', 1);
    error_reporting(E_ALL);


    function debug($data){
        echo "<pre>";
            var_dump($data);
        echo "</pre>";
        exit;
    }