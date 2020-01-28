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
        $rcorrect = $sessionctrl->registerA($_POST['uname'], $_POST['password'], $_POST['fullName'], $_POST['dni'], $_POST['horaInicio'], $_POST['horaFinal']);
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
        <span class="title">REGISTRAR ADMINISTRADOR</span>
    </div>
    <div class="header2">
        <a class="button" href="../../index.php">Inicio</a>
        <?php 
            //MENU ADMINS
            if ($_SESSION['type']=='a') {
                echo '<div class="menu-content dropdown">
                        <div class="button">Registrar</div>
                        <div class="dropdown-content">
                            <a class="dropdown-button" href="./regpaciente.php">Paciente</a>
                            <a class="dropdown-button" href="./regmedico.php">Médico</a>
                            <a class="dropdown-button" href="#">Administrador</a>
                        </div>
                </div>';
                echo '<a class="button" href="listadomedicos.php">Médicos</a>';
                echo '<a class="button" href="listadopacientes.php">Pacientes</a>';
            }
            echo '<a class="button" href="./logout.php">Logout</a>';
        ?>
    </div>
    <div class="body">
        <form action="./regadmin.php" method="post">
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
                <input class="inputMaterial" type="time" name="horaInicio" required min="00:00" max="23:59">
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>Hora de inicio</label>
            </div>
            <div class="group form-group">
                <input class="inputMaterial" type="time" name="horaFinal" required min="00:00" max="23:59">
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>Hora de final</label>
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