<?php 
include('./dbConfig.php');

$targetDirectory = 'images/';
$fileName = basename($_FILES["file"]["name"]);
$targetFilePath = $targetDirectory . $fileName;
$fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
$imageId = $_GET['id'];

if (!is_numeric($imageId) || $imageId <= 0) {
    exit('Invalid ID');
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($fileName)) {
    $arrImageTypes = array('jpg', 'png', 'jpeg', 'gif', 'pdf');
    if (in_array($fileType, $arrImageTypes)) {
        $sql = "SELECT file_name FROM images WHERE id = :id";
        $sth = $db->prepare($sql);
        $sth->bindParam(':id', $imageId, PDO::PARAM_INT);
        $sth->execute();
        $getImageName = $sth->fetch();

        $deleteImage = unlink($targetDirectory . $getImageName['file_name']);

        if ($deleteImage) {
            $uploadImageForServer = move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath);
        }

        if ($uploadImageForServer) {
            $sql = "UPDATE images SET file_name = :fileName WHERE id = :id";
            $sth = $db->prepare($sql);
            $sth->bindParam(':fileName', $fileName, PDO::PARAM_STR);
            $sth->bindParam(':id', $imageId, PDO::PARAM_INT);
            $sth->execute();

            if ($sth->rowCount() > 0) {
                header('Location:' . './html/index.php', true, 303);
                exit();
            }
        } else {
            // Error message if file could not be uploaded
            exit('File could not be uploaded.');
        }
    } else {
        // Error message if the file type is not allowed
        exit('Invalid file type.');
    }
} else {
    // Error message if the request method is not POST or the file name is empty
    exit('Invalid request.');
}
?>