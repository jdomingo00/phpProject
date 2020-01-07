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
            $departamentos = $sessionctrl->getDepartamentosList();
            $q = count($departamentos)/2;
            for ($i = 0; $i<$q; $i++) {
                $medicos = $medicosctrl->getMedicosByDepartamentoId($departamentos['id'.$i.'']);
                if (count($medicos)>0) {
                    echo '<h2>'.$departamentos['nombre'.$i.''].'</h2>';
                    foreach ($medicos as $medico) {
                        echo '<a href="./detallemedico.php?numcolegiado='.$medico->getNumColegiado().'">
                                <div style="padding:2%;background-color: lightgrey; color: black;">
                                    <div style="width:48%;float:left;">'.
                                    $medico->getFullName().
                                    '</div>
                                    <div style="width:48%; float:left;">
                                        Número de colegiado: '.$medico->getNumColegiado().
                                    '</div>
                                    <div style="clear:both;"></div>
                                </div>
                            </a>';
                    }
                }
            }
            ?>
    </div>
    <div class="footer">
        <span>Hello, I'm a footer!</span>
    </div>
</body>

</html>