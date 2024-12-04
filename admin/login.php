<?php
    include '../classes/adminlogin.php'
?>
<?php
    $class = new adminlogin();
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $adminUser = $_POST['adminUser'];
        $adminPass = $_POST['adminPass'];

        $login_check = $class->login_admin($adminUser,$adminPass);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="icon" type="image/png" href="img/admin_favicon.png">
</head>
<body>
    <div class="container">
        <section id="content">
            <form action="login.php" method="post">
                <h1>Admin Login</h1>
                <span>
                    <?php
                        if(isset($login_check)){
                            echo $login_check;
                        }
                    ?>
                </span>
                <div class="input-group">
                    <input type="text" placeholder="Username" required="" name="adminUser">
                </div>
                <div class="input-group">
                    <input type="password" placeholder="Password" required="" name="adminPass">
                </div>
                <div class="input-group">
                    <input type="submit" value="Log in">
                </div>
            </form>
            <div class="button">
                <a href="#">Quên mật khẩu</a>
            </div>
        </section>
    </div>
</body>
</html>

