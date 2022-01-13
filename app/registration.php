<?php
$title = "Registration";

$is_error = false;
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $data = $_POST?? '';
    $login = $_POST['login']?? '';
    $email = $_POST['email']?? '';
    $password = $_POST['password']?? '';
    $confirmPassword = $_POST['confirmPassword']?? '';

    function registration($login, $email, $password, $confirmPassword){
            if(empty($login) || empty($email) || empty($password) || empty($confirmPassword) || ($password != $confirmPassword)){
                return false;
            }
            return true;
    }
    require "db1.php";
    if(registration($login, $email, $password, $confirmPassword)){
        $sql = "INSERT INTO users (login, email, password) VALUES ('$login', '$email', '$password')";
        if(mysqli_query($db1, $sql)) {
            header('Location: login.php');
            exit();
        } else {
            $is_error = true;
        }
    } else {
        $is_error = true;
    }
}

require_once "header.php";
?>
    <div class="registration">
        <h1>Registration</h1>
        <form action="registration.php" method="post">
            <p>Login</p><input type="text" name="login" placeholder="Enter Login" value="<?php echo @$login?>">
            <p>Email</p><input type="email" name="email" placeholder="Enter Email" value="<?php echo @$email?>">
            <p>Password</p><input type="password" name="password" placeholder="Password">
            <p>Confirm password</p><input type="password" name="confirmPassword" placeholder="Confirm Password">
            <?php
            if ($is_error) {
                echo '<div style="color: red" class="alert-danger" role="alert">Check data in fields</div>';
            }
            ?>
            <input id="buttonSubmit" type="submit" name="submit" value="Registration">
        </form>
        <div>
            <a href="login.php">Log in</a>
        </div>
    </div>

<?php
require_once "footer.php";
?>