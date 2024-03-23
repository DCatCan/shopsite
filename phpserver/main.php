<?php

require 'connect.php';
require 'function.php';

// $cookieValue = rand(100000,999999);
// $cookieTime = time()+3600*3;


// setcookie($cookieName,$cookieValue, $cookieTime);



$header = file_get_contents(get_pathC("header.html"));
$mainbody = file_get_contents(get_pathC("main.html"));
$footer = file_get_contents(get_pathC("footer.html"));

$header = str_replace("--headtitle--", "main", $header);

$rows = getTable($dbc,'mainText');

for ($i=0; $i < 4; $i++) { 

    $title = $rows[$i]['title'];
    $text = $rows[$i]['theText'];

    $mainbody = str_replace('--title'.$i.'--', $title, $mainbody);
    $mainbody = str_replace('--text'.$i.'--', $text, $mainbody);

}

header("Content-type: text/html");
echo $header . $mainbody . $footer;



?>
