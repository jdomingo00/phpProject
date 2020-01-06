<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/controller/SessionController.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/controller/MedicosController.php');
    $sessionctrl = new SessionController();
    $medicosctrl = new MedicosController();
    if ($sessionctrl->checkSessionStarted()) {
        if ($_SESSION['type']!='a') {
            header('Location:../../index.php');
            exit();
        }
    } else {
        header('Location:./login.php');
        exit();
    }
    if (!isset($_GET['numcolegiado'])) {
        header('Location:./listadomedicos.php');
        exit();
    }
    if (isset($_POST['asignar'])) {
        if (isset($_POST['fecha'])&&isset($_POST['hora'])&&isset($_POST['paciente'])) {
            $rtnasign = $medicosctrl->insertNewHoraVisita($_POST['fecha'],$_POST['hora'],$_GET['numcolegiado'],$_POST['paciente']);
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
        <span class="title">LISTADO DE MÉDICOS</span>
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
            }
            echo '<a class="button" href="./logout.php">Logout</a>';
        ?>
    </div>
    <div class="body">
        <?php 
            echo '<form action="./detallemedico.php?numcolegiado='.$_GET['numcolegiado'].'" method="post">'
        ?>
            <div>
                <h2>Asignar horas</h2>
                <div class="group form-group">
                    <?php
                        echo '<input class="inputMaterial" type="date" name="fecha" min="'. date('Y-m-d') .'">';
                    ?>
                    <span class="highlight"></span>
                    <span class="bar"></span>
                    <label>Fecha</label>
                </div>
                <div class="group form-group">
                    <input class="inputMaterial" type="time" name="hora" min="08:00" max="14:00">
                    <span class="highlight"></span>
                    <span class="bar"></span>
                    <label>Hora</label>
                </div>
                <div class="group form-group">
                    <input class="inputMaterial" type="text" name="paciente">
                    <span class="highlight"></span>
                    <span class="bar"></span>
                    <label>Paciente</label>
                </div>
                <div class="form-group-buttons">
                <button class="form-button" type="submit" name="asignar">Asignar</button>
            </div>
            </div>
            <ul>
            <?php
                $horas = $medicosctrl->getHorasVisitaByMedico($_GET['numcolegiado']);
                if (count($horas)>0) {
                    foreach ($horas as $hora) {
                        echo '<li>
                                Fecha: '. $hora->getFecha().' 
                                Paciente: '. $hora->getPaciente().'
                                Hora: '. $hora->getHora().' 
                                Estado: '. $hora->getEstado().'';
                        if ($hora->getEstado()!='Cancelada') {
                            echo '<button type="submit" name="cancelar" value="'.$hora->getFecha().' '.$hora->getHora().'">Cancelar hora</button>';
                        }
                        echo '</li>';
                    }
                }
                ?>
            </ul>
        </form>
    </div>
    <div class="footer">
        <span>Hello, I'm a footer!</span>
    </div>
</body>

</html>