<?php

session_start();


$message = '';
$message_type = ''; 


if (isset($_SESSION['login_message'])) {
    $message = $_SESSION['login_message'];
    $message_type = isset($_SESSION['message_type']) ? htmlspecialchars($_SESSION['message_type']) : 'error';

    unset($_SESSION['login_message']);
    unset($_SESSION['message_type']);
}

$retained_email = '';
if (isset($_SESSION['retained_email'])) {
    $retained_email = htmlspecialchars($_SESSION['retained_email']);
    unset($_SESSION['retained_email']); 
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login | TM</title>
    <link rel="stylesheet" href="../../asset/css/loginPageStyle.css">
    <link rel="icon" type="image/png" href="../../asset/imgs/icon.png">
    </head>
<body>
    <div class="loginContainer">
        <form id="loginForm" method="post" action="../../controller/loginCheck.php">
            <center><img src="../../asset/imgs/icon.png" width="70px" alt="logo"></center>

            <h2 id="loginTitleTxt">Login</h2>

            <div class="inGrp">
                <label for="email">Email</label>
                <input type="email" id="email" name="email"
                       value="<?php echo $retained_email; ?>"
                       placeholder="yourEmail@gmail.com" required/>
            </div>

            <div class="inGrp">
                <label for="password">Password</label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" value="" required/>
                    <span id="togglePassword">👁</span>
                </div>
            </div>

            <button type="submit" name="submit" value="submit">Login</button>

            <p class="message" id="message">
                <?php
                if (!empty($message)) {
                    echo "<span class='" . $message_type . "'>" . $message . "</span>";
                }
                ?>
            </p>

            <div class="links">
                <a href="../php/forgotPasswordPage.php" target="_self">Forgot Password?</a><br>
                <a href="../php/signupPage.php">Don't have an account? Sign up</a>
            </div>

        </form>
    </div>

    <script src="../../asset/js/login.js"></script>
    </body>
</html>