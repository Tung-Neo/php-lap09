<?php
require_once 'connect.php';
$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_errno)die("Fatal Error");
if (
    isset($_POST['username'])
    && isset($_POST['password'])
    && isset($_POST['fullname'])
    && isset($_POST['email'])
    && isset($_POST['phone'])
    && isset($_POST['address'])
)
{
    $username = get_post($conn, 'username');
    $password = get_post($conn, 'password');
    $fullname = get_post($conn, 'fullname');
    $email = get_post($conn, 'email');
    $phone = get_post($conn, 'phone');
    $address = get_post($conn, 'address');
    $query = "insert into customer(username, password, fullname, email, phone, address)
            values ('$username', '$password', '$fullname', '$email', '$phone', '$address')";
    if (mysqli_num_rows(mysqli_query($conn, "select username from customer where username = '". $username."'")) > 0 ) {
        echo "Account already exists! <a href='javascript: history.go(-1)'>Back</a>";
        exit();
    }
    $resutl = $conn->query($query);
    header('Location: login.php');
}
echo <<<_END
<form action="register.php" method="post">
<pre>
User Name <input type="text" name="username" required>
Password <input type="text" name="password" required>
Fullname <input type="text" name="fullname" required>
Email <input type="text" name="email">
Phone <input type="text" name="phone">
Address <input type="text" name="address" required>
<input type="submit" value="SignUp"> or <a href="login.php">LogIn</a>
</pre>
</form>
_END;
$conn->close();
function get_post($conn, $var)
{
    return $conn->real_escape_string($_POST[$var]);
}
?>