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
                //MENU ADMINS
                if ($_SESSION['type']=='a') {
                    echo '<div class="menu-content dropdown">
                            <div class="button">Registrar</div>
                            <div class="dropdown-content">
                                <a class="dropdown-button" href="src/view/regpaciente.php">Paciente</a>
                                <a class="dropdown-button" href="src/view/regmedico.php">Médico</a>
                                <a class="dropdown-button" href="src/view/regadmin.php">Administrador</a>
                            </div>
                    </div>';
                    echo '<a class="button" href="src/view/listadomedicos.php">Médicos</a>';
                    echo '<a class="button" href="src/view/listadopacientes.php">Pacientes</a>';
                }
                //MENU PACIENTES
                if ($_SESSION['type']=='p') {
                }
                //MENU MEDICOS
                if ($_SESSION['type']=='m') {
                }
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