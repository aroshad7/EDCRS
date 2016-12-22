<?php
include_once 'connect.inc.php';

$id = $_POST["id"];
$password = $_POST["password"];

    $query="SELECT `password` FROM `doctor` WHERE `doc_id`='$id'";
    $sql = "UPDATE `edcrs`.`doctor` SET `status`=true WHERE `doc_id`='$id'";
    $query_two = "SELECT `full_name` FROM `doctor` WHERE `doc_id`='$id'";

    $query2="SELECT `password` FROM `health_officer` WHERE `officer_id`='$id'";
    $sql2 = "UPDATE `edcrs`.`health_officer` SET `status`=true WHERE `officer_id`='$id'";
    $query_two2 = "SELECT `full_name` FROM `health_officer` WHERE `officer_id`='$id'";


if($query_run=mysql_query($query)){
    if(mysql_num_rows($query_run)!=0){
        $query_row = mysql_fetch_assoc($query_run);
        if(md5($password) == $query_row['password']){
            echo "1";
            $query_stat=mysql_query($sql);
        }
        else{
            echo "Incorrect password!";
        }

    }
    else{
        //echo "Invalid user_id!";
        /**************************************************************/
        if($query_run2=mysql_query($query2)){
            if(mysql_num_rows($query_run2)!=0){
                $query_row = mysql_fetch_assoc($query_run2);
                if(md5($password) == $query_row['password']){
                    echo "2";
                    $query_stat=mysql_query($sql2);
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
        /**************************************************************/
    }
}
else{
    echo mysql_error();
}

?>
