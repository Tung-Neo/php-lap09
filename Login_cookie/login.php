<?php
require_once 'connect.php';
$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_errno)die("Fatal Error");
if (
    isset($_POST['username'])
    && isset($_POST['password'])
)
{
    $username = $_POST['username'];
    $password = $_POST['password'];
    $query = mysqli_query($conn, "select username, password from customer where username = '".$username."' and password = '".$password."'");
    if (mysqli_num_rows($query) == 0)
    {
//        if ($username == null || $password == null){
//            echo "Please enter username and password! <a href='javascript: history.go(-1)'>Back</a>";
//            exit();
//        }
        echo "Username or password is incorrect, please try again! <a href='javascript: history.go(-1)'>Back</a>";
        exit();
    }
    $_SESSION['username'] = $username;
    $_SESSION['password'] = $password;
    header("Location: information.php");
    exit();
}
if (empty($_SESSION['username'])){
    if (isset($cookie_name)){
        if (isset($_COOKIE[$cookie_name])){
            parse_str($_COOKIE[$cookie_name]);
            $sql = "select * from customer where username = '".$username."' and password = '".$password."'";
            $result = mysqli_query($sql, $conn);
            if ($result)
            {
                header('Location: information.php');
            }
        }
    }
}
else
{
    header('Location: information.php');
    exit();
}
if (isset($_POST['submit']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];
    $check = ((isset($_POST['remember']) != 0) ? 1 : "");
    if ($username == null || $password == null){
        echo "Please enter username and password! <a href='javascript: history.go(-1)'>Back</a>";
        exit();
    }
    else{
        $sql = "select * from customer where username = '".$username."' and password = '".$password."'";
        echo $sql;
        $result = mysqli_query($sql, $conn);
        if (!$result)die("Fatal Error");
    }
    $row = mysqli_fetch_array($result);
    $user = $row['username'];
    $pass = $row['password'];
    if ($user = $username && $pass == $password)
    {
        $_SESSION['username'] = $user;
        $_SESSION['password'] = $pass;
        if ($check == 1)
        {
            setcookie($cookie_name, 'username = '.$user.'&password = '.$pass, time() + $cookie_time);
        }
        header('Location: information.php');
        exit();
    }
}
echo <<<_END
<form action="login.php" method="post">
<pre>
User Name <input type="text" name="username">
Password <input type="text" name="password">
<input type="checkbox" name="remember" value="yes">Remember
<input type="submit" value="LogIn">
</pre>
</form>
_END;

?>