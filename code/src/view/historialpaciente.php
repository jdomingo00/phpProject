<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/controller/SessionController.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/controller/PacientesController.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/controller/MedicosController.php');
    $sessionctrl = new SessionController();
    $medicosctrl = new MedicosController();
    $pacientesctrl = new PacientesController();
    if ($sessionctrl->checkSessionStarted()) {
        if ($_SESSION['type']!='m') {
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
            if ($_SESSION['type']=='m') {
                echo '<a class="button" href="visitasmedico.php">Visitas</a>
                <a class="button" href="#">Pacientes</a>';
            }
            echo '<a class="button" href="./logout.php">Logout</a>';
        ?>
    </div>
    <div class="body">
        <?php echo '<form action="./detallepaciente.php?dni='.$_GET['dni'].'" method="post">' ?>
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
                                    Estado: '. $hora->getEstado().'
                                    <button type="submit" name="modificar" value="'.$hora->getFecha().' '.$hora->getHora(). ' ' . $hora->getMedico().'">Modificar historial</button>';
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