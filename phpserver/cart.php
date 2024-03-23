<?php

require 'connect.php';
require 'function.php';



$header = file_get_contents(get_pathC("header.html"));
$mainbody = file_get_contents(get_pathC("cart.html"));
$footer = file_get_contents(get_pathC("footer.html"));

$header = str_replace("--headtitle--", "cart", $header);
echo $header;
$pagePieces = explode('<!-- lol -->', $mainbody);
echo $pagePieces[0];


if (isset($_POST['delete'])) {
    if (!empty($_POST['check_list'])) {
        foreach ($_POST['check_list'] as $result) {
            unset($_SESSION['cart'][$result]);

        }
    }
} else if (isset($_POST['checkout'])) {
    checkout($dbc, $_SESSION['cart']);
    unset($_SESSION['cart']);
    echo '<p>Thank you for your purchase!</p>';
}


$lastPage = $pagePieces[2];

$total = 0;

if (!empty($_SESSION['cart'])) {
    

    foreach ($_SESSION['cart'] as $key => $result) {
        

        $tempPage = $pagePieces[1];
        $id = $result['id'];
        $row = getItem($dbc, $id);


        $amount = $result['amount'];
        $price = $row['price'];
        $index = $key;
        $prodTot = $amount*$price;
    
        $total+= $prodTot;
    
        
        $tempPage = str_replace('--index--', $index,$tempPage);
        $tempPage = str_replace('--id--', $id, $tempPage);
        $tempPage =  str_replace('--item--', $row['pname'], $tempPage);
        $tempPage = str_replace('--price--', $price, $tempPage );
        $tempPage = str_replace('--prodTot--', $prodTot, $tempPage );
        $tempPage =  str_replace('--amount--', $amount, $tempPage);

    
        echo $tempPage;
    }
}else {
    echo '<p class="px-3">No products to show.</p>';
}

$lastPage =  str_replace('--total--', $total, $lastPage);


echo $lastPage . $footer;

?>
