<?php 
include('./dbConfig.php');

$targetDirectory = 'images/';
$imageId = $_GET['id'];

if (!empty($imageId)) {
    if (!is_numeric($imageId) || $imageId <= 0) {
        // Handle the error here
        exit('Invalid ID');
    }

    $sql = "SELECT file_name FROM images WHERE id = :id";
    $sth = $db->prepare($sql);
    $sth->bindParam(':id', $imageId, PDO::PARAM_INT);
    $sth->execute();
    $getImageName = $sth->fetch();

    $deleteImage = unlink($targetDirectory . $getImageName['file_name']);

    if($deleteImage) {
        $sql = "DELETE FROM images WHERE id = :id";
        $sth = $db->prepare($sql);
        $sth->bindParam(':id', $imageId, PDO::PARAM_INT);
        $sth->execute();

        if($sth->rowCount() > 0) {
            header('location:' . './html/index.php', true, 303);
            exit();
        }
    } 
}
?>