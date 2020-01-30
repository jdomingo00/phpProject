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
        if (isset($_POST['asignahora'])&&isset($_POST['paciente'])) {
            $sp = explode('?', $_POST['asignahora']);
            $rtnasign = $medicosctrl->insertNewHoraVisita($sp[0],$sp[1],$_GET['numcolegiado'],$_POST['paciente']);
        }
    }
    if (isset($_POST['cancelar'])) {
        $sep = explode(' ', $_POST['cancelar']);
        $rtncancel = $medicosctrl->cancelHoraVisita($sep[0], $sep[1], $_GET['numcolegiado']);
    }
    if (isset($_POST['update'])) {
        if (isset($_POST['newfecha']) && isset($_POST['newhora']) && isset($_POST['newpaciente'])) {
            $sep = explode(' ', $_POST['update']);
            $rtnupdate = $medicosctrl->modificarHoraVisita($sep[0], $sep[1], $_GET['numcolegiado'], $_POST['newfecha'], $_POST['newhora'], $_POST['newpaciente']);
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
        <span class="title">MÉDICO Nº <?php echo $_GET['numcolegiado']?></span>
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
        <?php 
            echo '<form action="./detallemedico.php?numcolegiado='.$_GET['numcolegiado'].'" method="post">'
        ?>
            <div>
                <h2>Asignar horas</h2>
                <div class="group form-group">
                    <?php 
                        $horas = $medicosctrl->getHorasVisitaByMedico($_GET['numcolegiado']);
                        $diaactual = date("Y-m-d");
                        $diast = $medicosctrl->getDiasVisitaByMedico($_GET['numcolegiado']);
                        for ($i = 1; $i<=30; $i++) {
                            $dia = date("Y-m-d",strtotime($diaactual."+ ".$i." days"));
                            $ndia = $medicosctrl->comprobarDia($dia);
                                foreach ($diast as $diat) {
                                    if ($diat == $ndia) {
                                        echo $ndia.', '.$dia.'        ';
                                        $horast = $medicosctrl->getHorarioByMedicoAndDia($_GET['numcolegiado'], $ndia);
                                        foreach($horast as $horat) {
                                            //
                                            // Aqui pongo lo de filtrar las horas que ya tiene asignadas para que sea disabled y tal
                                            //
                                            //
                                            echo ' '.$horat.' <input type="radio" name="asignahora" value="'.$dia.'?'.$horat.'">';
                                        }
                                        echo "<br/>";
                                    }
                                }
                           
                        }
                    ?>
                </div>

                <div class="group form-group">
                    <select class="inputMaterialDropdown inputMaterial" name="paciente">
                        <option value=""></option>
                        <?php
                            $pacientes = $medicosctrl->getPacientesDNIList();
                            foreach ($pacientes as $paciente) {
                                 echo '<option value="'.$paciente->getDNI().'">'.$paciente->getDNI().'</option>';
                            }
                        ?>
                    </select>
                    <span class="highlight"></span>
                    <span class="bar"></span>
                    <label>Paciente</label>
                </div>

                <div class="form-group-buttons button-asignar">
                    <button class="form-button" type="submit" name="asignar">Asignar</button>
                </div>
            </div>
            <div class="visitas-container">
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
                                echo '<button type="submit" name="modificar" value="'.$hora->getFecha().' '.$hora->getHora().'">Modificar</button>';
                            if ($hora->getEstado()!='Cancelada') {
                                echo '<button type="submit" name="cancelar" value="'.$hora->getFecha().' '.$hora->getHora().'">Cancelar</button>';
                            }
                            echo '</li>';
                            if (isset($_POST['modificar'])) {
                                if ($_POST['modificar'] == $hora->getFecha().' '.$hora->getHora()) {
                                    $sep = explode(' ', $_POST['modificar']);
                                    echo '<div>
                                            Fecha: <input type="date" name="newfecha" value="'.$sep[0].'" min="'. date('Y-m-d') .'">
                                            Hora: <input type="time" name="newhora" value="'.$sep[1].'" min="08:00" max="14:00">
                                            Paciente: <select name="newpaciente" value="'.$hora->getPaciente().'">';
                                                foreach ($pacientes as $paciente) {
                                                    echo '<option value="'.$paciente->getDNI().'">'.$paciente->getDNI().'</option>';
                                                }
                                            echo '
                                            </select>
                                            <button type="submit" name="update" value="'.$_POST['modificar'].'">Aceptar</button>
                                        </div>';  
                                }   
                            }
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