<?php 
require 'connect.php';
require 'function.php';


// Page handling 
$header = file_get_contents(get_pathC("header.html"));
$detailPage = file_get_contents(get_pathC("details.html"));
$footer = file_get_contents(get_pathC("footer.html"));



$header = str_replace("--headtitle--", 'moop', $header);


echo $header;

// Get Information on the product.

$id = $_POST['prodId'];

$getQuery = 'SELECT p.*, im.* 
            FROM prodInfo as p, productImage as im 
            where p.id = ' . $id . ' and im.id = '.$id . ';';

if($r =  mysqli_query($dbc, $getQuery)){
    if ($row = mysqli_fetch_assoc($r)) {

        $submit = '<button class="btn btn-success" type="submit" name="add">Add</button>';
        if ($row['stock'] < 1) {
            $submit = '<button class="btn btn-warning" type="submit" name="add" disabled>Add</button>';
        }
        $detailPage = str_replace('--submit--', $submit, $detailPage);

        $detailPage = str_replace('--id--', $id, $detailPage);
        $detailPage = str_replace('--name--', $row['pname'], $detailPage);
        $detailPage = str_replace('--descript--', $row['descript'], $detailPage);
        $detailPage = str_replace('--stock--', $row['stock'], $detailPage);
        $detailPage = str_replace('--img--', "showImage.php?id=$id" , $detailPage );
        $detailPage = str_replace('--price--', $row['price'], $detailPage);



        echo $detailPage;
        
    }
}

if (isset($_POST['add']) && $_POST['amount'] > 0) {

    $id = $_POST['prodId'];
    $amount = $_POST['amount'];

    addItem($dbc, $id,$amount);

}


// Page handling
echo $footer;

?>