<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/controller/SessionController.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/controller/PacientesController.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/controller/MedicosController.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/controller/FileController.php');
    $sessionctrl = new SessionController();
    $medicosctrl = new MedicosController();
    $pacientesctrl = new PacientesController();
    $filectrl = new FileController();
    if ($sessionctrl->checkSessionStarted()) {
        if ($_SESSION['type']!='p') {
            header('Location:../../index.php');
            exit();
        }
    } else {
        header('Location:./login.php');
        exit();
    }
    if (!isset($_GET['departamento'])) {
        header('Location:./listadepartamentospaciente.php');
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
        <span class="title">PACIENTE Nº <?php echo $dni.' - '.$_GET['departamento'];?></span>
    </div>
    <div class="header2">
        <a class="button" href="../../index.php">Inicio</a>
        <?php 
            //MENU PACIENTES
                if ($_SESSION['type']=='p') {
                     echo '<a class="button" href="detallepaciente.php?dni='.$dni.'">Visitas</a>
                    <a class="button" href="listadepartamentospaciente.php">Historial</a>';
                }
            echo '<a class="button" href="./logout.php">Logout</a>';
        ?>
    </div>
    <div class="body">
            <div style="width: 90%; margin-left:5%; min-height: 100px; border: solid black 1px; border-radius: 5px;">
                <?php
                    $file=$filectrl->getFileContent($dni, $_GET['departamento']);
                    foreach ($file as $counter => $line){
                        echo $line . '<br/>';
                    }
                ?>
            </div>
    </div>
    <div class="footer">
        <span>Hello, I'm a footer!</span>
    </div>
</body>

</html>