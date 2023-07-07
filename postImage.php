<?php

include('./dbConfig.php');

//画像の保存先を指定
$targetDirectory = 'images/';
$fileName = basename($_FILES["file"]["name"]);
$targetFilePath = $targetDirectory . $fileName;
//拡張子を取得
$fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($fileName)) {
    $arrImageTypes = array('jpg', 'png', 'jpeg', 'gif', 'pdf');
    if (in_array($fileType, $arrImageTypes)) {
        $postImageForSeerver = move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath);

        if ($postImageForSeerver) {
            $insert = $db->query("INSERT INTO images (file_name) VALUES ('" . $fileName . "')");
        }
    }
}

header('Location:' . './html/index.php', true, 303);
exit();