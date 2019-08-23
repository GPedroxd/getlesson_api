<?php
    session_start();
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: *");

    require 'config.php';
    require 'Routers.php';
    require __DIR__.'/vendor/autoload.php';
    
    $core = new Core\Core();
    $core -> run();