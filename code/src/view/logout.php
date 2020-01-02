<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/controller/SessionController.php');

    $sessionctrl = new SessionController();
    if(!$sessionctrl->checkSessionStarted()) {
        header('Location:../../index.php');
        exit();
    }

    if(isset($_POST['response'])) {
        if($_POST['response'] == 'si') {
            $sessionctrl->logout();
        }
        header('Location:../../index.php');
        exit();
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
        <span class="title">LOGOUT</span>
    </div>
    <div class="header2">
        <a class="button" href="../../index.php">Inicio</a>
    </div>
    <div class="box">
        <div id="header">
            <div id="cont-lock"><i class="material-icons lock">lock</i></div>
            <div id="bottom-head">
                <h1 id="logintoregister">Logout</h1>
            </div>
        </div>
        <div class="group">
            Cerrar la sesión?
        </div>
        <form action="./logout.php" method="post">
            <button id="buttonlogintoregister" name="response" value="si" type="submit">Si</button>
            <button id="buttonlogintoregister" name="response" value="no" type="submit">No</button>
        </form>
    </div>
    <div class="footer">
        <span>Hello, I'm a footer!</span>
    </div>
</body>

</html>