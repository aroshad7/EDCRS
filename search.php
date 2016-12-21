<?php
include_once 'dbconnect.php';

$epidemic_disease_id = $_POST["disease"];
$district = $_POST["district"];
$city = $_POST["city"];

if($epidemic_disease_id == NULL){
    $sql = "SELECT status, national_id FROM diagnose_with WHERE diagnose_with.national_id IN (SELECT national_id form patients WHERE patients.city_id = `$city_id` and patients .city_id in (select city_id from city where city.district_id = `$district_id`))";
    $sql2 = "create view search as SELECT status, national_id FROM diagnose_with WHERE diagnose_with.national_id IN (SELECT national_id form patients WHERE patients.city_id = `$city_id` and patients.city_id in (select city_id from city where city.district_id = `$district_id`))";
    $sql3 = "SELECT count(national_id), age_group from patient GROUP BY age_group";

}elseif($epidemic_disease_id == NULL && $city == NULL){
    $sql = "SELECT status, national_id FROM diagnose_with WHERE diagnose_with.national_id IN (SELECT national_id form patients WHERE patients .city_id in (select city_id from city where city.district_id = `$district_id`))";
    $sql2 = "create view search as SELECT status, national_id FROM diagnose_with WHERE diagnose_with.national_id IN (SELECT national_id form patients patients.city_id in (select city_id from city where city.district_id = `$district_id`))";
    $sql3 = "SELECT count(national_id), age_group from patient GROUP BY age_group";

}elseif ($city == NULL){
    $sql = "SELECT status, national_id FROM diagnose_with WHERE diagnose_with.disease_id = `$epidemic_disease_id` and diagnose_with.national_id IN (SELECT national_id form patients WHERE patients .city_id in (select city_id from city where city.district_id = `$district_id`))";
    $sql2 = "create view search as SELECT status, national_id FROM diagnose_with WHERE diagnose_with.national_id IN (SELECT national_id form patients WHERE patients.city_id = `$city_id` and patients.city_id in (select city_id from city where city.district_id = `$district_id`))";
    $sql3 = "SELECT count(national_id), age_group from patient GROUP BY age_group";

}elseif($city == NULL && $district == NULL){
    $sql = "SELECT status, national_id FROM diagnose_with WHERE diagnose_with.disease_id = `$epidemic_disease_id` and diagnose_with.national_id IN (SELECT national_id form patients)";
    $sql2 = "create view search as SELECT status, national_id FROM diagnose_with WHERE diagnose_with.disease_id = `$epidemic_disease_id` and diagnose_with.national_id IN (SELECT national_id form patients)";
    $sql3 = "SELECT count(national_id), age_group from patient GROUP BY age_group";

} else{
    $sql = "SELECT status, national_id FROM diagnose_with WHERE diagnose_with.disease_id = `$epidemic_disease_id` and diagnose_with.national_id IN (SELECT national_id form patients WHERE patients.city_id = `$city` and patients .city_id in (select city_id from city where city.district_id = `$district_id`))";
    $sql2 = "create view search as SELECT status, national_id FROM diagnose_with WHERE diagnose_with.disease_id = `$epidemic_disease_id` and diagnose_with.national_id IN (SELECT national_id form patients WHERE patients.city_id = `$city` and patients .city_id in (select city_id from city where city.district_id = `$district_id`))";
    $sql3 = "SELECT count(national_id), age_group from patient GROUP BY age_group";

}
$sql4 = "SELECT status, national_id, full_name, age_group FROM search natural join patients";
?>



