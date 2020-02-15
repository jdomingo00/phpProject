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
    if (isset($_POST['add'])) {
        $filectrl->addFileContent($_GET['dni'], $_POST['add'], $_POST['filecontent']);
    }
    $medico = $medicosctrl->getNumColegiadoByUname($_SESSION['uname']);
    $currdep = $medicosctrl->getDepName($medicosctrl->getDepartamentoByMedico($medico));
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
        <span class="title">PACIENTE Nº <?php echo $_GET['dni'].' - '.$currdep;?></span>
    </div>
    <div class="header2">
        <a class="button" href="../../index.php">Inicio</a>
        <?php 
            if ($_SESSION['type']=='m') {
                echo '<a class="button" href="visitasmedico.php">Visitas</a>
                <a class="button" href="listadopacientes.php">Pacientes</a>';
            }
            echo '<a class="button" href="./logout.php">Logout</a>';
        ?>
    </div>
    <div class="body">
        <?php echo '<form action="./historialpaciente.php?dni='.$_GET['dni'].'" method="post">' ?>
                <?php
                    $file=$filectrl->getFileContent($_GET['dni'], $currdep);
                    $filecontent = '';
                    foreach ($file as $counter => $line){
                        $filecontent = $filecontent . $line;
                    }
                    echo '<textarea name="filecontent" placeholder="Texto aqui..." rows="10" style="margin-left:10%;width:80%;margin-top:20px;border: solid 1px black;">'.$filecontent.'</textarea>'
                ?>
                
                <div class="form-group-buttons">
                    <?php
                        echo '<button type="submit" name="add" value="'.$currdep.'" class="form-button" style="margin-left:37.5%;margin-top:30px;">Guardar fichero</button>';
                    ?>
                </div>
        </form>
    </div>
    <div class="footer">
        <span>Hello, I'm a footer!</span>
    </div>
</body>

</html>