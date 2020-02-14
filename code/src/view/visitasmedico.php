<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/controller/SessionController.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/controller/MedicosController.php');
    $sessionctrl = new SessionController();
    $medicosctrl = new MedicosController();
    if ($sessionctrl->checkSessionStarted()) {
        if ($_SESSION['type']!='m') {
            header('Location:../../index.php');
            exit();
        }
    } else {
        header('Location:./login.php');
        exit();
    }
    $medico = $medicosctrl->getNumColegiadoByUname($_SESSION['uname']);
    if (isset($_POST['finalizar'])) {
        $sep = explode(' ', $_POST['finalizar']);
        $rtncancel = $medicosctrl->finalizarHoraVisita($sep[0], $sep[1], $medico);
        error_log($rtncancel . ' AQUI ESCRUIBITRE TODO ESTO PaRA SABER SI ESTOY ENTRANDO A ESTE IF PERO NO TIENE NINNGUNA IMPORTANCIA EN EL PROGRAM,A VAYA');
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
        <span class="title">Visitas</span>
    </div>
    <div class="header2">
        <a class="button" href="../../index.php">Inicio</a>
        <?php 
            if ($_SESSION['type']=='m') {
                echo '<a class="button" href="#">Visitas</a>';
            }
            echo '<a class="button" href="./logout.php">Logout</a>';
        ?>
    </div>
    <div class="body">
        <form action="./visitasmedico.php" method="post">
            <div class="visitas-container">
                <ul>
                <?php
                    $horas = $medicosctrl->getHorasVisitaByMedico($medico);
                    if (count($horas)>0) {
                        foreach ($horas as $hora) {
                            echo '<li>
                                    Fecha: '. $hora->getFecha().' 
                                    Paciente: '. $hora->getPaciente().'
                                    Hora: '. $hora->getHora().' 
                                    Estado: '. $hora->getEstado().'';
                            if ($hora->getEstado()!='Finalizada') {
                                echo '<button type="submit" name="finalizar" value="'.$hora->getFecha().' '.$hora->getHora().'">Finalizar</button>';
                            }
                            echo '</li>';
                        }
                    }
                    ?>
                </ul>
            </div>
        </form>
    </div>
    <div class="footer">
        <span>Hello, I'm a footer!</span>
    </div>
</body>

</html>