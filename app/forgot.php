<?php
$title = "Password recovery";
$haveLogin = false;
$loginBD = 'tut';
$is_error = false;

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $login = $_POST['login']?? '';
    require "db1.php";
    @$username = mysqli_real_escape_string($db1,$_POST['login']);
    $requestId = "SELECT `id` FROM `users` WHERE `login`='".mysqli_real_escape_string($db1,$_POST['login'])."' LIMIT 1";
    $sqlId = mysqli_query($db1, $requestId) or die(mysqli_error($db1));
    if(mysqli_num_rows($sqlId) == 1){
        $simv = ["92", "83", "1", "0", "7", "1", "a", "b", "w", "l", "o"];
        for ($k = 0; $k<8; $k++){
            shuffle($simv);
            @$newPassword = $newPassword.$simv[1];
        }
        $requestPassword = ("UPDATE users SET password = '$newPassword' WHERE login= '$username'");
        $sqlPassword = mysqli_query($db1, $requestPassword) or die(mysqli_error($db1));
        $requestEmail = "SELECT email FROM users WHERE login='{$username}'";
        $sqlLogin = mysqli_query($db1, $requestEmail) or die(mysqli_error($db1));
        $requestEmailSql = mysqli_fetch_assoc($sqlLogin);
        $email = $requestEmailSql['email'];
        mail($email, "Request for password recovery", "Hello, $username. Your new password: $");
    }
    if($login && $login == $loginBD){
        $haveLogin = true;
        header('Refresh: 2; URL = http://localhost:8001/login.php');
    } else {
//        $is_error = true;
    }

}

require_once "header.php";
?>
<div class="forgot">
    <h2>Enter login to reset your password</h2>
    <form action="forgot.php" method="post">
        <p>Login</p><input type="text" name="login" placeholder="Enter Login">
        <?php
        if ($is_error){
            echo '<div style="color: red">Wrong login</div>';
        }
        if ($haveLogin){
            echo '<div style="color: green">Send message</div>';
        }
        ?>
        <input id="buttonSubmit" type="submit" name="submit" value="Send">
    </form>

    <a href="login.php">Log in</a>

</div>
<?php
require_once "footer.php";
?>
