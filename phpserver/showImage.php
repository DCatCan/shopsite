<?php 

require_once 'connect.php';
    

    $id = $_GET["id"];
    $row;

    $aQuery = "Select prodImage, imgType from productImage where id=$id";

    if ($r = mysqli_query($dbc, $aQuery)) {
        $row = mysqli_fetch_assoc($r);

    }






    header("Content-type: " .  $row['imgType']);

    

    echo $row['prodImage'];

?>