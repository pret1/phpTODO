<?php
session_start();
$title = "Login";

$is_error = false;

if(@$_SESSION["login"]){
    header('Location: index.php');
    exit();
}
else {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $login = $_POST['login'] ?? '';
        $password = $_POST['password'] ?? '';

        function login($login, $password)
        {
            if (empty($login) || empty($password)) {
                return false;
            }
            return true;
        }
        require "db1.php";
        if (login($login, $password)) {
            $resultSQL = "SELECT login, password FROM users WHERE login='" . mysqli_real_escape_string($db1, $_POST['login']) . "' LIMIT 1";
            $query = mysqli_query($db1, $resultSQL);
            $row = mysqli_fetch_array($query);
            if (is_array($row)) {
                $_SESSION["login"] = $row['login'];
            }
            if (isset($_SESSION["login"])) {
                if ($row['password'] === ($_POST['password'])) {
                header("Location: login.php");
                    exit();
                } else {
                    $is_error = true;
                }
            }
        }
    }
}
require_once "header.php";
?>
<div class="login">
    <h1>Log in</h1>
    <form action="login.php" method="post">
        <p>Login</p><input value="<?php echo @$login ?>" type="text" name="login" placeholder="Enter Login">
        <p>Password</p><input type="password" name="password" placeholder="Enter Password">
        <?php
        if ($is_error) {
            echo '<div style="color: red" class="alert-danger" role="alert">Login or password are incorrect</div>';
        }
        ?>
        <input id="buttonSubmit" type="submit" name="submit" value="Log in">
    </form>

    <a href="registration.php">Registration</a>
    <a href="forgot.php">You forgot a password?</a>
</div>
<?php
require_once "footer.php";
?>

