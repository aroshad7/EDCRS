<?php
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


$epidemic_disease_id = $_POST["disease_name"];

$district_name = $_POST["district_name"];
$district_id=null;
if($district_name!=null){
    $district_id = get_district_id($district_name);
}

$city_name = $_POST["city_name"];
$city_id=null;
if($city_name!=null){
    $city_id = get_city_id($city_name,$district_id);
}


$sql;
$sql2;
$sql3;
$sql5;


/*if($epidemic_disease_id == NULL && $city_id == NULL){
    $sql = "SELECT status, national_id FROM diagnosed_with WHERE diagnosed_with.national_id IN (SELECT national_id from patients WHERE patients.city_id in (select city_id from city where city.district_id = '$district_id'))";
    $sql2 = "create or replace view search as SELECT status, national_id FROM diagnosed_with WHERE diagnosed_with.national_id IN (SELECT national_id from patients WHERE patients.city_id in (select city_id from city where city.district_id = '$district_id'))";
    $sql3 = "SELECT count(national_id), age_group from patientsGROUP BY age_group";

}*/
    /**************************************************************/
if($city_id == NULL && $district_name == NULL) {
    $sql = "SELECT status, national_id FROM diagnosed_with WHERE diagnosed_with.disease_id = '$epidemic_disease_id' and diagnosed_with.national_id IN (SELECT national_id from patients)";
    $sql2 = "create or replace view search as SELECT status, national_id FROM diagnosed_with WHERE diagnosed_with.disease_id = '$epidemic_disease_id' and diagnosed_with.national_id IN (SELECT national_id from patients)";
    $sql3 = "SELECT count(national_id), age_group from patients GROUP BY age_group";
    $sql5 = "SELECT count(district_id),district_id FROM city WHERE city_id in (SELECT city_id from patients WHERE national_id in (select national_id from search)) group by district_id";
    sql2($conn,$sql2);
    $result = $conn->query($sql5);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo get_district_name($row["district_id"]) . " " . $row["count(district_id)"]."<br>";
        }
    } else {
        echo "No results!";
    }
}
    /**************************************************************/
elseif ($city_id == NULL) {
    $sql = "SELECT status, national_id FROM diagnosed_with WHERE diagnosed_with.disease_id = '$epidemic_disease_id' and diagnosed_with.national_id IN (SELECT national_id from patients WHERE patients .city_id in (select city_id from city where city.district_id = '$district_id'))";
    $sql2 = "create or replace view search_city as SELECT status, national_id FROM diagnosed_with WHERE diagnosed_with.national_id IN (SELECT national_id from patients WHERE patients.city_id in (select city_id from city where city.district_id = '$district_id'))";
    $sql3 = "SELECT count(national_id), age_group from patients GROUP BY age_group";
    $sql5 = "SELECT count(city_id),city_id FROM patients WHERE national_id in (SELECT national_id FROM search_city) group by city_id";
    sql2($conn,$sql2);
    $result = $conn->query($sql5);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo get_city_name($row["city_id"], $district_id) . " " . $row["count(city_id)"]."<br>";
        }
    } else {
        echo "No results!";
    }
}   /**************************************************************/

/*elseif($epidemic_disease_id == NULL){
    $sql = "SELECT status, national_id FROM diagnosed_with WHERE diagnosed_with.national_id IN (SELECT national_id from patients WHERE patients.city_id = '$city_id' and patients .city_id in (select city_id from city where city.district_id = '$district_id'))";
    $sql2 = "create or replace view search as SELECT status, national_id FROM diagnosed_with WHERE diagnosed_with.national_id IN (SELECT national_id from patients WHERE patients.city_id = '$city_id' and patients.city_id in (select city_id from city where city.district_id = '$district_id'))";
    $sql3 = "SELECT count(national_id), age_group, disease_name from patient,diagnosed_with,epidemic_disease  WHERE patients.national_id=diagnose.national_id and epidemic_diseas.diseas_id=diagnosed_with.diseas_id WITH GROUP BY age_group";

}*/

else{
    $sql = "SELECT status, national_id FROM diagnosed_with WHERE diagnosed_with.disease_id = '$epidemic_disease_id' and diagnosed_with.national_id IN (SELECT national_id from patients WHERE patients.city_id = '$city_id' and patients.city_id in (select city_id from city where city.district_id = '$district_id'))";
    $sql2 = "create or replace view search_all as SELECT status, national_id FROM diagnosed_with WHERE diagnosed_with.disease_id = '$epidemic_disease_id' and diagnosed_with.national_id IN (SELECT national_id from patients WHERE patients.city_id = '$city_id' and patients.city_id in (select city_id from city where city.district_id = '$district_id'))";
    $sql5 = "SELECT count(national_id), age_group_id from patients NATURAL JOIN search_all GROUP BY age_group_id";
    sql2($conn,$sql2);
    $result = $conn->query($sql5);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo $row["age_group_id"] . " " . $row["count(national_id)"]."<br>";
        }
    } else {
        echo "No results!";
    }
}
$sql4 = "SELECT status, national_id, full_name, age_group FROM search natural join patients";






/*
if($query_run=mysql_query($sql5)){
    if(mysql_num_rows($query_run)!=0){
        $query_row = mysql_fetch_assoc($query_run);
        print_r($query_row);
    }
    else{
        echo "Invalid search!";

    }
}
else{
    echo mysql_error();
}
*/


function get_city_id($city_name,$district_id){
    $get_city_id_sql = "SELECT `city_id` FROM `city` WHERE `city_name`='$city_name' and `district_id`='$district_id'";
    if($query_run_city=mysql_query($get_city_id_sql)){
        if(mysql_num_rows($query_run_city)!=0){
            $query_row = mysql_fetch_assoc($query_run_city);
            return ($query_row['city_id']);
        }
        else{
            echo "Invalid city or district name!";
            echo nl2br("\n");
        }
    }
    else{
        echo mysql_error();
        echo nl2br("\n");
    }
    return;
}

function get_district_id($district_name){
    $get_district_id_sql = "SELECT `district_id` FROM `district` WHERE `district_name`='$district_name'";
    if($query_run_district=mysql_query($get_district_id_sql)){
        if(mysql_num_rows($query_run_district)!=0){
            $query_row = mysql_fetch_assoc($query_run_district);
            return ($query_row['district_id']);
        }
        else{
            echo "Invalid district name!";
            echo nl2br("\n");
        }
    }
    else{
        echo mysql_error();
        echo nl2br("\n");
    }
    return;
}


function sql2($conn, $sql2){
    if ($conn->query($sql2) === TRUE) {
        //echo "View creation successful!";
        //echo nl2br("\n");
    } else {
        echo "Error : " . $sql2 . "<br>" . $conn->error;
    }
    return;
}

function get_city_name($city_id,$district_id){
    $get_city_id_sql = "SELECT `city_name` FROM `city` WHERE `city_id`='$city_id' and `district_id`='$district_id'";
    if($query_run_city=mysql_query($get_city_id_sql)){
        if(mysql_num_rows($query_run_city)!=0){
            $query_row = mysql_fetch_assoc($query_run_city);
            return ($query_row['city_name']);
        }
        else{
            echo "Invalid city or district id!";
            echo nl2br("\n");
        }
    }
    else{
        echo mysql_error();
        echo nl2br("\n");
    }
    return;
}



function get_district_name($district_id){
    $get_district_id_sql = "SELECT `district_name` FROM `district` WHERE `district_id`='$district_id'";
    if($query_run_district=mysql_query($get_district_id_sql)){
        if(mysql_num_rows($query_run_district)!=0){
            $query_row = mysql_fetch_assoc($query_run_district);
            return ($query_row['district_name']);
        }
        else{
            echo "Invalid district id!";
            echo nl2br("\n");
        }
    }
    else{
        echo mysql_error();
        echo nl2br("\n");
    }
    return;
}


$conn->close();

?>



