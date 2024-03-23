<?php 

    $servername = "atlas.dsv.su.se";
    $username = "usr_19543601";
    $password = "543601";
    $dbname = "db_19543601";
    $port = 3306;
    $dbc = new mysqli($servername,$username,$password,$dbname,$port);

    

    if (mysqli_error($dbc)) {
        echo '<p>Couldnt Connect to database!</p>';
    }
    

    $mainTable = "CREATE TABLE IF NOT EXISTS productImage (
        id INT PRIMARY KEY AUTO_INCREMENT, 
        prodImage MEDIUMBLOB,
        imgType varchar(255)
        )";

    
    $infoTable = "CREATE TABLE IF NOT EXISTS prodInfo (
        id INT PRIMARY KEY AUTO_INCREMENT, 
        pname varchar(255),
        descript varchar(255),
        stock INT,
        price FLOAT
        )";

    $contTable = "CREATE TABLE IF NOT EXISTS contact (
        id INT PRIMARY KEY AUTO_INCREMENT, 
        iNr varchar(255),
        nNr varchar(255),
        street varchar(255),
        email varchar(255),
        rndMessage varchar(255)
        )";

    $info = "CREATE TABLE IF NOT EXISTS mainText (
        id INT PRIMARY KEY AUTO_INCREMENT, 
        title varchar(255),
        theText varchar(255));";


    if (mysqli_query($dbc, $mainTable)) {
    }else {
        print '<p style="color: red;">Could not create the database because:<br />' .
        mysqli_error($dbc) . '.</p>';
    }
    if (mysqli_query($dbc, $infoTable)) {

    }else {
        print '<p style="color: red;">Could not create the database because:<br />' .
        mysqli_error($dbc) . '.</p>';
    }

    if (mysqli_query($dbc, $contTable)) {

    }else {
        print '<p style="color: red;">Could not create the database because:<br />' .
        mysqli_error($dbc) . '.</p>';
    }

    if (mysqli_query($dbc, $info)) {

    }else {
        print '<p style="color: red;">Could not create the database because:<br />' .
        mysqli_error($dbc) . '.</p>';
    }

  
    $url =  $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    
    if ($_SERVER['HTTPS'] != 'on' || empty($_SERVER['HTTPS']) ) {
        header('Location: https://' . $url);   
    
        exit;
    }


    





 ?>