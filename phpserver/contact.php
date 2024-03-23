<?php

    require 'connect.php';
    require 'function.php';


    $header = file_get_contents(get_pathC("/header.html"));
    $contact = file_get_contents(get_pathC("/contact.html"));
    $footer = file_get_contents( get_pathC("/footer.html"));

    $header = str_replace("--headtitle--", "Contact", $header);

    $getQuery = 'SELECT * from contact;';

    if($r =  mysqli_query($dbc, $getQuery)){
        if ($row = mysqli_fetch_assoc($r)) {
    
            $contact = str_replace('--iNr--', $row['iNr'], $contact);
            $contact = str_replace('--nNr--', $row['nNr'], $contact);
            $contact = str_replace('--street--', $row['street'], $contact);
            $contact = str_replace('--email--', $row['email'], $contact);
            $contact = str_replace('--descript--', $row['rndMessage'], $contact);
    
    
    
            
        }
    }

    echo $header . $contact . $footer;



?>