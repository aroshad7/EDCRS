<?php
include_once 'connect.inc.php';

$id = $_POST["id"];
$password = $_POST["password"];

if(true){
    $query="SELECT `password` FROM `doctor` WHERE `doc_id`='$id'";
    $sql = "UPDATE `edcrs`.`doctor` SET `status`=true WHERE `doc_id`='$id'";
    $query_two = "SELECT `full_name` FROM `doctor` WHERE `doc_id`='$id'";
}

else{
    $query="SELECT `password` FROM `health_officer` WHERE `reg_id`='$id'";
    $sql = "UPDATE `edcrs`.`health_officer` SET `status`=true WHERE `reg_id`='$id'";
    $query_two = "SELECT `full_name` FROM `health_officer` WHERE `reg_id`='$id'";
}

if($query_run=mysql_query($query)){
    if(mysql_num_rows($query_run)!=0){
        $query_row = mysql_fetch_assoc($query_run);
        if(md5($password) == $query_row['password']){
            echo "Login Successful!";
            if($query_run_name=mysql_query($query)){
                $query_row_name = mysql_fetch_assoc($query_run_name);
                //echo $query_row_name["full_name"];
            }
            $query_stat=mysql_query($sql);
        }
        else{
            echo "Incorrect password!";
        }

    }
    else{
        echo "Invalid user_id!";
    }
}
else{
    echo mysql_error();
}

?>
