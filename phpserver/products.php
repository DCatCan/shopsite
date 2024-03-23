<?php
require 'connect.php';
require 'function.php';

// Page handling 

$header = file_get_contents(get_pathC("header.html"));
$productPage = file_get_contents(get_pathC("products.html"));
$footer = file_get_contents(get_pathC("footer.html"));

$pagePieces = explode('<!-- card -->', $productPage);
$header = str_replace("--headtitle--", "Products", $header);

echo $header . $pagePieces[0];




// display all the products from the DB 
$getQuery = 'SELECT p.*, im.* 
            FROM prodInfo as p, productImage as im 
            where p.id = im.id 
            group by p.id;';


if ($r =  mysqli_query($dbc, $getQuery)) {
    while ($row = mysqli_fetch_assoc($r)) {

        $submit = '<button class="btn btn-success" type="submit" name="add">Add</button>';

        if ($row['stock'] < 1) {
            $submit = '<button class="btn btn-warning" type="submit" name="add" disabled>Add</button>';
        }
        $id = $row['id'];
        $name = $row['pname'];


        $temp_piece = $pagePieces[1];


        $temp_piece = str_replace('--submit--', $submit, $temp_piece);

        $temp_piece = str_replace('--id--', $id, $temp_piece);
        $temp_piece = str_replace('--pname--', $name, $temp_piece);

        $temp_piece = str_replace('--stock--', $row['stock'], $temp_piece);
        $temp_piece = str_replace('--img--', "showImage.php?id=$id", $temp_piece);
        $temp_piece = str_replace('--price--', $row['price'], $temp_piece);
        $temp_piece = str_replace('--detail--', "details.php?id=$id", $temp_piece);

        echo $temp_piece;
    }
}





// add products to the cart
if (isset($_POST['add']) && $_POST['amount'] > 0) {

    $id = $_POST['prodId'];
    $amount = $_POST['amount'];

    addItem($dbc, $id, $amount);

}


// Page handling 

echo $pagePieces[2] . $footer;
