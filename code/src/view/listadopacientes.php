<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/controller/SessionController.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/controller/PacientesController.php');
    $sessionctrl = new SessionController();
    $pacientesctrl = new PacientesController();
    if ($sessionctrl->checkSessionStarted()) {
        if ($_SESSION['type']!='a' && $_SESSION['type']!='m') {
            header('Location:../../index.php');
            exit();
        }
    } else {
        header('Location:./login.php');
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
        <span class="title">LISTADO DE PACIENTES</span>
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
                            <a class="dropdown-button" href="./regadmin.php">Administrador</a>
                        </div>
                </div>';
                echo '<a class="button" href="listadomedicos.php">Médicos</a>';
                echo '<a class="button" href="#">Pacientes</a>';
            }
            //MENU MEDICOS
            if ($_SESSION['type']=='m') {
                echo '<a class="button" href="visitasmedico.php">Visitas</a>
                <a class="button" href="#">Pacientes</a>';
            }
            echo '<a class="button" href="./logout.php">Logout</a>';
        ?>
    </div>
    <div class="detall-container">
        <?php
            $pacientes = $pacientesctrl->getAll();
            foreach ($pacientes as $paciente) {
                 if ($_SESSION['type']=='a') {
                    echo '<a href="./detallepaciente.php?dni='.$paciente->getDni().'">';
                 } else if ($_SESSION['type']=='m') {
                    echo '<a href="./historialpaciente.php?dni='.$paciente->getDni().'">';
                 }
                echo '<div style="padding:2%;background-color: lightgrey; color: black;">
                            <div style="width:48%;float:left;">'.
                            $paciente->getFullName().
                            '</div>
                            <div style="width:48%; float:left;">
                                DNI: '.$paciente->getDni().
                            '</div>
                            <div style="clear:both;"></div>
                        </div>
                    </a>';
            }
            ?>
    </div>
    <div class="footer">
        <span>Hello, I'm a footer!</span>
    </div>
</body>

</html>