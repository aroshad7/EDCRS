<?php
/**
 * Created by PhpStorm.
 * User: Arosha D
 * Date: 12/20/2016
 * Time: 7:08 PM
 */

include_once 'connect.inc.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "edcrs";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$doc_id = $_POST["doc_id"];
$full_name = $_POST["full_name"];
$national_id = $_POST["national_id"];

$postal_code = $_POST["postal_code"];
$city_name = $_POST["city_name"];
$district_name = $_POST["district_name"];
$district_id = get_district_id($district_name);
$city_id = city_id_calculate($city_name, $district_name);

$age = (int)$_POST["age"];
$age_group_id = age_group_calculate($age);

$disease_id = $_POST["disease_name"];
$disease_type = $_POST["disease_type"];
$disease_description = $_POST["disease_description"];
$disease_name = $disease_id;





$check_patient_sql = "SELECT `national_id` FROM `patients` WHERE `national_id`='$national_id'";
$patient_update_sql = "UPDATE `edcrs`.`patients` SET `age`='$age', `age_group_id`='$age_group_id' WHERE `national_id`='$national_id'";
$patient_insert_sql = "INSERT INTO patients"."(full_name,national_id,age,age_group_id)"."VALUES('$full_name','$national_id','$age','$age_group_id')";
$checked_insert_sql = "INSERT INTO checked"."(doc_id,national_id)"."VALUES('$doc_id','$national_id')";
$diagnose_insert_sql = "INSERT INTO diagnosed_with"."(national_id,disease_id)"."VALUES('$national_id','$disease_id')";

$check_city_sql = "SELECT `city_id` FROM `city` WHERE `city_id`='$city_id'";
$city_insert_sql = "INSERT INTO city"."(city_id,city_name,postal_code,district_id)"."VALUES('$city_id','$city_name','$postal_code','$district_id')";

$check_disease_sql = "SELECT `disease_id` FROM `epidemic_disease` WHERE `disease_id`='$disease_id'";
$disease_insert_sql = "INSERT INTO epidemic_disease"."(disease_id,disease_name,type,description)"."VALUES('$disease_id','$disease_name','$disease_type','$disease_description')";
$has_insert_sql =  "INSERT INTO has"."(disease_name,report_id)"."VALUES('$disease_name','$disease_type','$disease_description')";
$report_insert_sql = "INSERT INTO reports"."(doc_id,disease_id)"."VALUES('$doc_id','$disease_id')";
$infects_insert_sql = "INSERT INTO infects"."(disease_id,age_group_id)"."VALUES('$disease_id','$age_group_id')";
$found_in_insert_sql = "INSERT INTO found_in"."(disease_id,city_id)"."VALUES('$disease_id','$city_id')";


if($query_run_checked=mysql_query($check_city_sql)){
    if(mysql_num_rows($query_run_checked)==0){
        $query_stat=mysql_query($city_insert_sql);
        echo ("City added!");
        echo PHP_EOL;
    }
    else{
        echo "City already exists!";
        echo PHP_EOL;
    }
}
else{
    echo mysql_error();
    echo PHP_EOL;
}


if($query_run_disease=mysql_query($check_disease_sql)){
    if(mysql_num_rows($query_run_disease)==0){
        $query_stat=mysql_query($disease_insert_sql);
        $query_stat=mysql_query($has_insert_sql);
        $query_stat=mysql_query($report_insert_sql);
        $query_stat=mysql_query($infects_insert_sql);
        $query_stat=mysql_query($found_in_insert_sql);
        echo ("Disease added!");
        echo PHP_EOL;
    }
    else{
        echo "Disease already exists!";
        echo PHP_EOL;
    }
}
else{
    echo mysql_error();
    echo PHP_EOL;
}


if($query_run_disease=mysql_query($check_patient_sql)){
    if(mysql_num_rows($query_run_disease)==0){
        $query_stat=mysql_query($patient_insert_sql);
        $query_stat=mysql_query($diagnose_insert_sql);
        $query_stat=mysql_query($checked_insert_sql);
        echo ("Person added!");
        echo PHP_EOL;
    }
    else{
        $query_stat=mysql_query($patient_update_sql);
        echo "Person updated!";
        echo PHP_EOL;
    }
}
else{
    echo mysql_error();
    echo PHP_EOL;
}






function age_group_calculate($age){
    $age_group_id = 0;
    if($age <= 5){
        $age_group_id=1;
    }
    elseif($age > 5 and $age <= 10){
        $age_group_id=2;
    }
    elseif($age > 10 and $age <= 15){
        $age_group_id=3;
    }
    elseif($age > 15 and $age <= 24){
        $age_group_id=4;
    }
    elseif($age > 24 and $age <= 35){
        $age_group_id=5;
    }
    elseif($age > 35 and $age <= 45){
        $age_group_id=6;
    }
    elseif($age > 45 and $age <= 60){
        $age_group_id=7;
    }
    elseif($age > 60 and $age <= 70){
        $age_group_id=8;
    }
    elseif($age > 70){
        $age_group_id=9;
    }
    return $age_group_id;
}


function city_id_calculate($city_name, $district_name){
    $city_id = $city_name . "@" . $district_name;
    return ($city_id);
}

function get_district_id($district_name){
    $get_district_id_sql = "SELECT `district_id` FROM `district` WHERE `district_name`='$district_name'";
        if($query_run_district=mysql_query($get_district_id_sql)){
            if(mysql_num_rows($query_run_district)!=0){
                $query_row = mysql_fetch_assoc($query_run_district);
                return ($query_row['district_id']);
            }
            else{
                echo "Invalid user_id!";
                echo PHP_EOL;
            }
        }
        else{
            echo mysql_error();
            echo PHP_EOL;
        }
    return;
}



?>

