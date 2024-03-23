<?php
require 'connect.php';
require '../function.php';



$header = file_get_contents(get_pathA('adminHeader.html'));
$productPage = file_get_contents(get_pathA("manage.html"));

$pagePieces = explode('<!-- card -->',$productPage);


$header = str_replace("--headtitle--", "Manage products", $header);


echo $header . $pagePieces[0];

if (isset($_POST['id'])) {
    remove_item($_POST['id'],$dbc);
}


$getQuery = 'SELECT p.*, im.* 
            FROM prodInfo as p, productImage as im 
            where p.id = im.id 
            group by p.id;';

if($r =  mysqli_query($dbc, $getQuery)){
    while ($row = mysqli_fetch_assoc($r)) {
        
        $temp_piece = $pagePieces[1];

        $id = $row['id'];
        $name = $row['pname'];

        $temp_piece = str_replace('--id--', $id, $temp_piece);
        $temp_piece = str_replace('--pname--', $name, $temp_piece);
        $temp_piece = str_replace('--descript--', $row['descript'], $temp_piece);
        $temp_piece = str_replace('--stock--', $row['stock'], $temp_piece);
        $temp_piece = str_replace('--price--', $row['price'], $temp_piece);
        $temp_piece = str_replace('--detail--', "details.php?id=$id", $temp_piece);



        echo $temp_piece;
        
    }
}




echo $pagePieces[2];
