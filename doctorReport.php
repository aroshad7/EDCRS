<html>
<title>Registration Page</title>
<body>

Log in to your account!<br><br>

<form action="doctorReportDataPost.php" method="POST">
    <label for="doc_id">Doctor Id : </label><input type="text" name="doc_id"><br>
    <label for="full_name">Full Name : </label><input type="text" name="full_name"><br>
    <label for="national_id">National Id : </label><input type="text" name="national_id"><br>
    <label for="city_name">City Name : </label><input type="text" name="city_name"><br>
    <label for="district_name">District Name : </label><input type="text" name="district_name"><br>
    <label for="postal_code">Postal Code : </label><input type="text" name="postal_code"><br>
    <label for="age">Age : </label><input type="text" name="age"><br>
    <label for="disease_name">Disease Name : </label><input type="text" name="disease_name"><br>
    <label for="disease_type">Disease Type : </label><input type="text" name="disease_type"><br>
    <label for="disease_description">Disease Description : </label><input type="text" name="disease_description"><br>
    <input type="submit" name="submit" value="Report">
</form>

</body>
</html>