<?php 

require '../function.php';
require 'connect.php';


$header = file_get_contents(get_pathA("adminHeader.html"));
$contactEdit = file_get_contents(get_pathA("contactEdit.html"));
$header = str_replace("--headtitle--", "ContactEdit", $header);







if (isset($_POST['update_contact'])) {
    $iNr = $_POST["iNr"];
    $nNr = $_POST['nNr'];
    $street = $_POST['street'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    

    $update_contact =  "UPDATE contact
                        SET iNr = ?,
                            nNr = ?,
                            street = ?,
                            email = ?,
                            rndMessage = ?
                        where id = 1;";
                        
    $insert_contact = "INSERT INTO contact (iNr, nNr, street, email, rndMessage) values (?,?,?,?,?);";

    if (tableEmpty($dbc, "contact")) {
        if ($stmt = $dbc->prepare($insert_contact)) {
        
            $stmt -> bind_param('sssss', $iNr, $nNr, $street, $email, $message);
            $stmt -> execute();
            $stmt -> close();
            print 'Contact inserted!';
    
    
        }else {
            print '<p style="color: red;">Could not insert the database because:<br />' .
                    mysqli_error($dbc) . '.</p>'; 
            
        }
    }else {
        if ($stmt = $dbc->prepare($update_contact)) {
        
            $stmt -> bind_param('sssss', $iNr, $nNr, $street, $email, $message);
            $stmt -> execute();
            $stmt -> close();
            print 'Contact updated!';
    
    
        }else {
            print '<p style="color: red;">Could not insert the database because:<br />' .
                    mysqli_error($dbc) . '.</p>'; 
            
        }
    }
    




    
}


$getQuery = 'SELECT * from contact;';

if($r =  mysqli_query($dbc, $getQuery)){
    if ($row = mysqli_fetch_assoc($r)) {

        $contactEdit = str_replace('--iNr--', $row['iNr'], $contactEdit);
        $contactEdit = str_replace('--nNr--', $row['nNr'], $contactEdit);
        $contactEdit = str_replace('--street--', $row['street'], $contactEdit);
        $contactEdit = str_replace('--email--', $row['email'], $contactEdit);
        $contactEdit = str_replace('--descript--', $row['rndMessage'], $contactEdit);



        
    }
}





echo $header . $contactEdit;





?>