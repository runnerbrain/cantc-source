<?php 
$servername = "localhost";
$username = "";
$password = "";
$dbname = "cantcr";

$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully\n";

$db_selected = mysqli_select_db($conn,$dbname);
if($db_selected)
    echo "DB selected successfully\n";
else{
        echo "No DB selected\n";
        exit(1);
    }
    
?>
