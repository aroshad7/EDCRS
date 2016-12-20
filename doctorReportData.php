<?php
/**
 * Created by PhpStorm.
 * User: Arosha D
 * Date: 12/20/2016
 * Time: 7:08 PM
 */

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
$city_id = $_POST["city_id"];
$age = (int)$_POST["age"];
$age_group_id;
$disease_id = $_POST["disease_name"];
$disease_type = $_POST["disease_type"];
$disease_description = $_POST["disease_description"];
$disease_name = $disease_id;

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



$check_sql = "SELECT `national_id` FROM `patient` WHERE `national_id`=`$national_id`";
$patient_update_sql = "UPDATE `edcrs`.`patient` SET `age`=`$age`, `age_group_id`=`Sage_group_id` WHERE `national_id`=`$national_id`";
$patient_insert_sql = "INSERT INTO patient"."(full_name,national_id,age,age_group_id)"."VALUES('$full_name','$national_id','$age','$age_group_id')";
$checked_insert_sql = "INSERT INTO checked"."(doc_id,national_id)"."VALUES('$doc_id','$national_id')";
$diagnose_insert_sql = "INSERT INTO diagnosed_with"."(national_id,disease_id)"."VALUES('$national_id','$disease_id')";

$disease_insert_sql = "INSERT INTO epidemic_disease"."(disease_name,type,description)"."VALUES('$disease_name','$disease_type','$disease_description')";
$has_insert_sql =  "INSERT INTO has"."(disease_name,report_id)"."VALUES('$disease_name','$disease_type','$$disease_description')";
$report_insert_sql = "INSERT INTO reports"."(doc_id,disease_id)"."VALUES('$doc_id','$disease_id')";
$infects_insert_sql = "INSERT INTO infects"."(disease_id,age_group_id)"."VALUES($disease_id',$age_group_id)";
$found_in_insert_sql = "INSERT INTO found_in"."(disease_id,city_id)"."VALUES('$disease_id',$city_id)";

?>

