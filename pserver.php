<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "icle";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if (isset($_POST['reg_p'])) {
  // receive all input values from the form
  $pname = mysqli_real_escape_string($conn,$_POST['pname']);
  $price = mysqli_real_escape_string($conn,$_POST['price']);
  $pcat = mysqli_real_escape_string($conn,$_POST['pcat']);
  $pdetails = mysqli_real_escape_string($conn,$_POST['pdetails']);
  $sdetails = mysqli_real_escape_string($conn,$_POST['sdetails']);
  $pqty = mysqli_real_escape_string($conn,$_POST['pqty']);
    

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "INSERT INTO product (p_title,p_price,p_category_id,p_description, desc , p_quantity )
VALUES ('$pname', '$price', '$pcat','$pdetails','$sdetails','$pqty')";



if ($conn->query($sql) === TRUE) {
    echo "alert('New record created successfully')";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
}

$conn->close();
?>