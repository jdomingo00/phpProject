<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/controller/SessionController.php');
    $sessionctrl = new SessionController();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/css.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>
    <div class="header">
        <span class="title">INICIO</span>
    </div>
    <div class="header2">
        <a class="button" href="#">Inicio</a>
        <?php 
            if ($sessionctrl->checkSessionStarted()) {
                echo '<a class="button" href="src/view/logout.php">Logout</a>';
            } else {
                echo '<a class="button" href="src/view/login.php">Login</a>';
            }
        ?>
        
    </div>

    <div class="footer">
        <span>Hello, I'm a footer!</span>
    </div>
</body>

</html>