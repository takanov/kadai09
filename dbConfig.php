<?php

//どこに接続するのか
$dbName = 'mysql:host=localhost;dbname=kadai_9_test_db;charset=utf8';
//誰が接続するのか
$userName = 'root';

try {
    $db = new PDO($dbName, $userName);
    //var_dump('success');
} catch(\Throwable $th){
    exit();
}



