<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/controller/SessionController.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/controller/PacientesController.php');
    $sessionctrl = new SessionController();
    $pacientesctrl = new PacientesController();
    if ($sessionctrl->checkSessionStarted()) {
        if ($_SESSION['type']!='a') {
            header('Location:../../index.php');
            exit();
        }
    } else {
        header('Location:./login.php');
        exit();
    }
    if (!isset($_GET['dni'])) {
        header('Location:./listadopacientes.php');
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
        <span class="title">PACIENTE Nº <?php echo $_GET['dni']?></span>
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
        <div class="visitas-container">
            <ul>
                <?php
                    $horas = $pacientesctrl->getHorasVisitaByPaciente($_GET['dni']);
                    if (count($horas)>0) {
                        foreach ($horas as $hora) {
                            echo '<li>
                                Fecha: '. $hora->getFecha().' 
                                Paciente: '. $hora->getMedico().'
                                Hora: '. $hora->getHora().' 
                                Estado: '. $hora->getEstado().'';
                        if ($hora->getEstado()!='Cancelada') {
                            echo '<button type="submit" name="cancelar" value="'.$hora->getFecha().' '.$hora->getHora().'">Cancelar</button>';
                        }
                        echo '</li>';
                    }
                }
                ?>
            </ul>
        </div>
    </div>
    <div class="footer">
        <span>Hello, I'm a footer!</span>
    </div>
</body>

</html>