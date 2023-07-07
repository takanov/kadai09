<?php
$url = $_SERVER['REQUEST_URI'];

if (strpos($url, 'imageDetail.php') !== false) {
    $imageId = $_GET['id'];
    
    if (!is_numeric($imageId) || $imageId <= 0) {
        // Handle the error here
        exit('Invalid ID');
    }

    $sql = "SELECT * FROM images WHERE id = :id";

    $sth = $db->prepare($sql);
    $sth->bindParam(':id', $imageId, PDO::PARAM_INT);
    $sth -> execute();
    $data['image'] = $sth -> fetch();

} else {
    $sql = "SELECT * FROM images ORDER BY create_date DESC";

    $sth = $db->prepare($sql);
    $sth -> execute();
    $data = $sth -> fetchAll();
}

return $data;

?>
