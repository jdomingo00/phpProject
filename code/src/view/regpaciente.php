<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/controller/SessionController.php');
    $sessionctrl = new SessionController();
    if ($sessionctrl->checkSessionStarted()) {
        if ($_SESSION['type']!='a') {
            header('Location:../../index.php');
            exit();
        }
    } else {
        header('Location:./login.php');
        exit();
    }
    $rcorrect = true;
    if (isset($_POST['registrar'])) {
        $rcorrect = $sessionctrl->registerP($_POST['uname'], $_POST['password'], $_POST['fullName'], $_POST['dni'], $_POST['fecNacimiento'], $_POST['mutua']);
        if($rcorrect) {
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
        <span class="title">REGISTRAR PACIENTE</span>
    </div>
    <div class="header2">
        <a class="button" href="../../index.php">Inicio</a>
        <?php 
            //MENU ADMINS
            if ($_SESSION['type']=='a') {
                echo '<div class="menu-content dropdown">
                        <div class="button">Registrar</div>
                        <div class="dropdown-content">
                            <a class="dropdown-button" href="#">Paciente</a>
                            <a class="dropdown-button" href="./regmedico.php">Médico</a>
                        </div>
                </div>';
            }
            echo '<a class="button" href="./logout.php">Logout</a>';
        ?>
    </div>
    <div class="body">
        <form action="./regpaciente.php" method="post">
            <div class="group form-group">
                <input class="inputMaterial" type="text" name="uname" required>
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>Username</label>
            </div>
            <div class="group form-group">
                <input class="inputMaterial" type="password" name="password" required>
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>Contraseña</label>
            </div>
            <div class="group form-group">
                <input class="inputMaterial" type="text" name="fullName" required>
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>Nombre completo</label>
            </div>
            <div class="group form-group">
                <input class="inputMaterial" type="text" name="dni" required>
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>DNI</label>
            </div>
            <div class="group form-group">
                <?php
                    echo '<input class="inputMaterial" type="date" name="fecNacimiento" required min="1900-01-01" max="'. date('Y-m-d') .'">'
                ?>
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>Fecha de nacimiento</label>
            </div>
            <div class="group form-group">
                <input class="inputMaterial" type="text" name="mutua" required>
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>Mutua</label>
            </div>
            <div class="form-group-buttons">
                <button class="form-button" type="submit" name="registrar">Registrar</button>
            </div>
        </form>
    </div>
    <div class="footer">
        <span>Hello, I'm a footer!</span>
    </div>
</body>

</html>