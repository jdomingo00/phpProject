<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/controller/SessionController.php');

    $sessionctrl = new SessionController();
    if($sessionctrl->checkSessionStarted()) {
        header('Location:../../index.php');
        exit();
    }

    $lcorrect = 1;
    $rcorrect = true;
    if(isset($_POST['login'])) {
        $lcorrect = $sessionctrl->login($_POST['uname'], $_POST['password']);
        if($lcorrect == 1) {
            header('Location:../../index.php');
            exit();
        }
    }
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../../css/css.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>
    <div class="header">
        <span class="title">LOGIN</span>
    </div>
    <div class="header2">
        <a class="button" href="../../index.php">Inicio</a>
    </div>
    <div class="box">
        <div id="header">
            <div id="cont-lock"><i class="material-icons lock">lock</i></div>
            <div id="bottom-head">
                <h1 id="logintoregister">Login</h1>
            </div>
        </div>
        <form action="./login.php" method="post">
            <div class="group">
                <input class="inputMaterial" type="text" name="uname" required>
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>Username</label>
            </div>
            <div class="group">
                <input class="inputMaterial" type="password" name="password" required>
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>Password</label>
            </div>
            <button id="buttonlogintoregister" name="login" type="submit">Login</button>
        </form>
        <div id="footer-box">

        </div>
    </div>
    <div class="footer">
        <span>Hello, I'm a footer!</span>
    </div>
</body>

</html>