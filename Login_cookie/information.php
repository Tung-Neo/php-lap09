<?php
include_once 'connect.php';
$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_errno)die("Fatal Error");
if (
    isset($_POST['username'])
) {
    $username = $_POST['username'];
//    $query = mysqli_query($conn, "select username from customer where username = '".$username."'");
}
echo "Welcome $username! ^^";
?>