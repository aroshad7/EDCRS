
<?php
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

$id = $_POST["id"];
$full_name = $_POST["full_name"];
$password = $_POST["password"];
$email = $_POST["email"];
$national_id = $_POST["national_id"];

if(true){
//$query="SELECT `password` FROM `doctor` WHERE `user_id`='$user_id'";
    $sql = "INSERT INTO doctor"."(doc_id,full_name,password,email,national_id)"."VALUES('$id','$full_name','md5($password)','$email','$national_id')";
}
else{
//$query="SELECT `password` FROM `health_officer` WHERE `officer_id`='$officer_id'";
    $sql = "INSERT INTO health_officer"."(officer_id,full_name,password,email,national_id)"."VALUES('$id','$full_name','md5($password)','$email','$national_id')";
}

if ($conn->query($sql) === TRUE) {
    echo "Registration successful";
} else {
    echo "Error : " . $sql . "<br>" . $conn->error;
}

$conn->close();

?>
