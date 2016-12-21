<?php
$mysql_host="localhost";
$mysql_user="root";
$mysql_pass="";

$mysql_error_text="Connection error!";
$mysql_db="edcrs";


if(!mysql_connect($mysql_host, $mysql_user, $mysql_pass) || !mysql_select_db("$mysql_db")){
        echo $mysql_error_text;
}
else{//echo "Connected";
}


?>
