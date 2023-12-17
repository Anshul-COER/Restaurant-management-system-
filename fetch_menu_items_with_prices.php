<?php
// Include your database connection code here
$db_hostname = "127.0.0.1";
$db_username = "root";
$db_password="";
$db_name="restauran";

$conn = mysqli_connect($db_hostname,$db_username,$db_password,$db_name);
if(!$conn){
    echo "Connection failed: ".mysqli_connect_error();
    exit;

}
// Query to retrieve menu items
$query = "SELECT  name, price FROM menu_items";
$result = mysqli_query($conn, $query);

$menuItems = array();

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $menuItems[] = $row;
    }
}

// Close the database connection
mysqli_close($conn);

// Return menu items as JSON
echo json_encode($menuItems);
?>
