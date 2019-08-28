<?php
    $config = array();
    $config['dbname'] = 'dbgetlesson';
    $config['host'] = 'localhost';
    $config['dbuser'] = 'root';
    $config['dbpass'] = '';
    $config['jwt_key'] = "MB10b";
    global $pdo;
    try{
       $pdo = new PDO("mysql:dbname=".$config['dbname'].";host=".$config['host'],
                $config['dbuser'], $config['dbpass']);
    }catch(PDOException $e){
        echo 'Error'.$e->getMessage();
        exit;   
    }