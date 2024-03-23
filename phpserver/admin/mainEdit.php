<?php 

require '../function.php';
require 'connect.php';


$header = file_get_contents(get_pathA("adminHeader.html"));
$frontEdit = file_get_contents(get_pathA("frontEdit.html"));
$header = str_replace("--headtitle--", "Main Edit", $header);


$pages = explode('<!-- section -->', $frontEdit);

$insert_text = "INSERT INTO mainText (title, theText) values (?,?);";


// If the database is empty but we have submited text for the main page, insert.

if (isset($_POST['update_main']) && tableEmpty($dbc, 'mainText')) {
    for ($index=1; $index < 5; $index++) { 

        $title = $_POST['title'.$index];
        $text =  $_POST['text' .$index];

        if ($stmt = $dbc ->prepare($insert_text) ) {
            $stmt -> bind_param('ss', $title, $text);
            $stmt -> execute();
            $stmt -> close();
        }        
    }


}

$update_text =  "UPDATE mainText
                        SET title = ?,
                            theText = ?
                        where id = ?;";
// If database already has data then update the data.

if (isset($_POST['update_main']) && !tableEmpty($dbc, 'mainText')) {

    for ($index=1; $index < 5; $index++) { 

        $title = $_POST['title'.$index];
        $text =  $_POST['text' .$index];

        if ($stmt = $dbc ->prepare($update_text) ) {
            $stmt -> bind_param('sss', $title, $text,$index);
            $stmt -> execute();
            $stmt -> close();
        }        
    }
    
}


echo $header . $pages[0];





if (tableEmpty($dbc,'mainText') && !isset($_POST['update_main'])) {
    for ($index=1; $index < 5; $index++) { 
        $temp = $pages[1];

        $title = 'title' . $index;
        $text = 'text' . $index;

        $temp = str_replace('--titlepart--', $title, $temp);
        $temp = str_replace('--textpart--', $text, $temp);
        

        echo $temp;

    }


}else {
    $result = getTable($dbc, 'mainText');
     for ($index=1; $index < 5; $index++) { 
        $temp = $pages[1];

        $title = 'title' . $index;
        $text = 'text' . $index;

        $temp = str_replace('--titlepart--', $title, $temp);
        $temp = str_replace('--textpart--', $text, $temp);

        $title = $result[$index-1]['title'];
        $text =  $result[$index-1]['theText'];
        $temp = str_replace('--title--', $title, $temp);
        $temp = str_replace('--text--', $text, $temp);

        echo $temp;

    }
}









echo $pages[2];





?>