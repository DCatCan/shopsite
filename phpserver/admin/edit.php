<?php 

require '../function.php';
require 'connect.php';


$header = file_get_contents(get_pathA("adminHeader.html"));
$edit = file_get_contents(get_pathA("edit.html"));
$header = str_replace("--headtitle--", "Edit", $header);

$id = $_POST['prodId'];



if (isset($_POST['update_shit'])) {
    $pnamn = $_POST["prod"];
    $stock = $_POST['stock'];
    $descript = $_POST['descrip'];
    $price = $_POST['price'];
    

    $update_product =  "UPDATE prodInfo
                        SET pname = ?,
                            descript = ?,
                            stock = ?,
                            price = ?
                        WHERE id = ?;";

    $update_image ="UPDATE productImage
                    SET prodImage = ?,
                        imgType = ?
                    WHERE id = ?;";


    if (is_uploaded_file($_FILES['image']['tmp_name'])){

        $img_stuff = file_get_contents($_FILES['image']['tmp_name']);
        $imgType = $_FILES['image']['type'];

        if ($stmt = $dbc->prepare($update_image)) {
            $stmt->bind_param('sss', $img_stuff, $imgType,$id);
            $stmt -> execute();
            $stmt -> close();
        }else {
            print '<p style="color: red;">Could not insert the database because:<br />' .
                mysqli_error($dbc) . '.</p>'; 
            
        }
        
    }

    if ($stmt = $dbc->prepare($update_product)) {
        
        $stmt -> bind_param('sssss', $pnamn, $descript, $stock, $price,$id);
        $stmt -> execute();
        $stmt -> close();
        print 'Store updated!';


    }else {
        print '<p style="color: red;">Could not insert the database because:<br />' .
                mysqli_error($dbc) . '.</p>'; 
        
    }




    
}


$getQuery = 'SELECT p.*, im.* 
            FROM prodInfo as p, productImage as im 
            where p.id = ' . $id . ' and im.id = '.$id . ';';

if($r =  mysqli_query($dbc, $getQuery)){
    if ($row = mysqli_fetch_assoc($r)) {

        $submit = '<button class="btn btn-success" type="submit" name="add">Add</button>';
        if ($row['stock'] < 1) {
            $submit = '<button class="btn btn-warning" type="submit" name="add" disabled>Add</button>';
        }
        $edit = str_replace('--img--', "../showImage.php?id=$id" , $edit );

        $edit = str_replace('--id--', $id, $edit);
        $edit = str_replace('--name--', $row['pname'], $edit);
        $edit = str_replace('--descript--', $row['descript'], $edit);
        $edit = str_replace('--stock--', $row['stock'], $edit);
        $edit = str_replace('--price--', $row['price'], $edit);



        
    }
}





echo $header . $edit;
;





?>