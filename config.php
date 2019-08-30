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
                $config['dbuser'], $config['dbpass'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    }catch(PDOException $e){
        echo 'Error'.$e->getMessage();
        exit;   
    }