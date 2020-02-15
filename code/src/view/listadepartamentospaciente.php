<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/controller/SessionController.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/controller/PacientesController.php');
    $sessionctrl = new SessionController();
    $pacientesctrl = new PacientesController();
    if ($sessionctrl->checkSessionStarted()) {
        if ($_SESSION['type']!='p') {
            header('Location:../../index.php');
            exit();
        }
    } else {
        header('Location:./login.php');
        exit();
    }
    $dni = $pacientesctrl->getDNIbyUname($_SESSION['uname']);
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
        <span class="title">HISTORIAL MÉDICO - SELECCIÓN DE DEPARTAMENTO</span>
    </div>
    <div class="header2">
        <a class="button" href="../../index.php">Inicio</a>
        <?php
            //MENU PACIENTES
            if ($_SESSION['type']=='p') {
                echo '<a class="button" href="./detallepaciente.php?dni='.$dni.'">Visitas</a>
                    <a class="button" href="#">Historial</a>';
            }
            echo '<a class="button" href="./logout.php">Logout</a>';
        ?>
    </div>
    <div class="detall-container">
        <?php
            $deps = $sessionctrl->getDepartamentosList();
            $q = count($deps)/2;
            for ($i = 0; $i<$q; $i++) {
                echo '<a href="./historialpacientep.php?departamento='.$deps['nombre'.$i.''].'" style="text-decoration: none;">
                    <div style="padding:2%;background-color: lightgrey; color: black;">
                        '.$deps['nombre'.$i.''].'
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