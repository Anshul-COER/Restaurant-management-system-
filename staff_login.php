<?php

$db_hostname = "127.0.0.1";
$db_username = "root";
$db_password="";
$db_name="restauran";

$conn = mysqli_connect($db_hostname,$db_username,$db_password,$db_name);
if(!$conn){
    echo "Connection failed: ".mysqli_connect_error();
    exit;

}
$name = $_POST['username'];
$pass = $_POST['password'];

$sql = "SELECT * FROM staff_info WHERE username='$name' AND password='$pass'";

    $result = mysqli_query($conn, $sql);
    if (!$result) {
        echo "Error: " . mysqli_error($conn);
        exit;
    }

    $row = mysqli_fetch_assoc($result);
    if ($row) {
        include("staff_dashboard.html");
    } else {
        
        include("staff_login.html");
    }

    mysqli_close($conn);

?>