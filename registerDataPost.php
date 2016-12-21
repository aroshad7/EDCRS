
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
$password = md5($password);
$email = $_POST["email"];
$national_id = $_POST["national_id"];
$type = $_POST["type"];

if($type==1){
//$query="SELECT `password` FROM `doctor` WHERE `user_id`='$user_id'";
    $sql = "INSERT INTO doctor"."(doc_id,full_name,password,email,national_id)"."VALUES('$id','$full_name','$password','$email','$national_id')";
}
elseif($type==2){
//$query="SELECT `password` FROM `health_officer` WHERE `officer_id`='$officer_id'";
    $sql = "INSERT INTO health_officer"."(officer_id,full_name,password,email,national_id)"."VALUES('$id','$full_name','$password','$email','$national_id')";
}

if ($conn->query($sql) === TRUE) {
    echo "Registration successful";
} else {
    echo "Error : " . $sql . "<br>" . $conn->error;
}

$conn->close();

?>
