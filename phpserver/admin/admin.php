<?php

    require 'connect.php';
    require '../function.php';

    $header = file_get_contents(get_pathA("adminHeader.html"));
    $adminPage = file_get_contents(get_pathA("admin.html"));
    $header = str_replace("--headtitle--", "Admin", $header);


    if (isset($_POST['postshit'])) {
        $pnamn = $_POST["prod"];
        $stock = $_POST['stock'];
        $descript = $_POST['descrip'];
        $price = $_POST['price'];
        $insert_product = "INSERT INTO prodInfo (pname, descript, stock, price) values (?,?,?,?);";

        $insert_image = "INSERT INTO productImage (pname, prodImage, imgType) values (?,?,?);";


        if (is_uploaded_file($_FILES['image']['tmp_name'])){

            $img_stuff = file_get_contents($_FILES['image']['tmp_name']);
            $imgType = $_FILES['image']['type'];

            if ($stmt = $dbc->prepare($insert_image)) {
                $stmt->bind_param('sss',$pnamn, $img_stuff, $imgType);
                $stmt -> execute();
                $stmt -> close();
            }else {
                print '<p style="color: red;">Could not insert the database because:<br />' .
                    mysqli_error($dbc) . '.</p>'; 
                
            }
            
        }else {
            $imgStuff = null;
            $imgType = null;

            if ($stmt = $dbc->prepare($insert_image)) {
                $stmt->bind_param('sss',$pnamn, $imgStuff, $imgType);
                $stmt -> execute();
                $stmt -> close();
            }else {
                print '<p style="color: red;">Could not insert the database because:<br />' .
                    mysqli_error($dbc) . '.</p>'; 
                
            }
            
        }

        if ($stmt = $dbc->prepare($insert_product)) {
            
            $stmt -> bind_param('ssss', $pnamn, $descript, $stock, $price);
            $stmt -> execute();
            $stmt -> close();
            print 'Store updated!';


        }else {
            print '<p style="color: red;">Could not insert the database because:<br />' .
                    mysqli_error($dbc) . '.</p>'; 
            
        }




        
    }



    echo $header . $adminPage;



?>