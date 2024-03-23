<?php 

    $servername = "atlas.dsv.su.se";
    $username = "usr_19543601";
    $password = "543601";
    $dbname = "db_19543601";
    $port = 3306;
    $dbc = new mysqli($servername,$username,$password,$dbname,$port);

    
    // Connect to the database

    if (mysqli_error($dbc)) {
        echo '<p>Couldnt Connect to database!</p>';
    }

    // Only use https header
    $url =  $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    
    if ($_SERVER['HTTPS'] != 'on' || empty($_SERVER['HTTPS']) ) {
        header('Location: https://' . $url);   
    
        exit;
    }


    

    if (session_status() !== PHP_SESSION_ACTIVE || session_status() === PHP_SESSION_NONE) {
        session_start();     
    }
    
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    





 ?>