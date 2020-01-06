<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/controller/SessionController.php');
    $sessionctrl = new SessionController();
    if ($sessionctrl->checkSessionStarted()) {
        if ($_SESSION['type']!='a') {
            header('Location:../../index.php');
            exit();
        }
    } else {
        header('Location:./login.php');
        exit();
    }
    $rcorrect = true;
    if (isset($_POST['registrar'])) {
        $rcorrect = $sessionctrl->registerM($_POST['uname'], $_POST['password'], $_POST['fullName'], $_POST['numcolegiado'], $_POST['departamento'], $_POST['tlunes'], $_POST['tmartes'], $_POST['tmiercoles'], $_POST['tjueves'], $_POST['tviernes'], $_POST['tsabado'], $_POST['tdomingo'],);
        if($rcorrect) {
            header('Location:../../index.php');
            exit();
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
        <span class="title">REGISTRAR PACIENTE</span>
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
                            <a class="dropdown-button" href="#">Médico</a>
                            <a class="dropdown-button" href="./regadmin.php">Administrador</a>
                        </div>
                </div>';
                echo '<a class="button" href="listadomedicos.php">Médicos</a>';
            }
            echo '<a class="button" href="./logout.php">Logout</a>';
        ?>
    </div>
    <div class="body">
        <form action="./regmedico.php" method="post">
            <div class="group form-group">
                <input class="inputMaterial" type="text" name="uname" required>
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>Username</label>
            </div>
            <div class="group form-group">
                <input class="inputMaterial" type="password" name="password" required>
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>Contraseña</label>
            </div>
            <div class="group form-group">
                <input class="inputMaterial" type="text" name="fullName" required>
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>Nombre completo</label>
            </div>
            <div class="group form-group">
                <input class="inputMaterial" type="text" name="numcolegiado" required>
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>Número de colegiado</label>
            </div>
            <div class="group form-group">
                <select class="inputMaterial" name="departamento" required>
                    <option value=""></option>
                    <?php
                        $departamentos = $sessionctrl->getDepartamentosList();
                        $q = count($departamentos)/2;
                        for ($i = 0; $i<$q; $i++) {
                            echo '<option value="'.$departamentos['id'.$i.''].'">'.$departamentos['nombre'.$i.''].'</option>';
                        }
                    ?>
                </select>
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>Departamento</label>
            </div>
            <div class="group form-group"></div>
            <div class="group form-group"></div>
            <div class="group form-group">
                Días que trabaja
            </div>
            <div class="group form-group"></div>
            <div class="group form-group">
                <input class="inputMaterial" type="checkbox" name="tlunes">
                <label>Lunes</label>
            </div>
            <div class="group form-group">
                <input class="inputMaterial" type="checkbox" name="tmartes">
                <label>Martes</label>
            </div>
            <div class="group form-group">
                <input class="inputMaterial" type="checkbox" name="tmiercoles">
                <label>Miércoles</label>
            </div>
            <div class="group form-group">
                <input class="inputMaterial" type="checkbox" name="tjueves">
                <label>Jueves</label>
            </div>
            <div class="group form-group">
                <input class="inputMaterial" type="checkbox" name="tviernes">
                <label>Viernes</label>
            </div>
            <div class="group form-group">
                <input class="inputMaterial" type="checkbox" name="tsabado">
                <label>Sábado</label>
            </div>
            <div class="group form-group">
                <input class="inputMaterial" type="checkbox" name="tdomingo">
                <label>Domingo</label>
            </div>
            <div class="form-group-buttons">
                <button class="form-button" type="submit" name="registrar">Registrar</button>
            </div>
        </form>
    </div>
    <div class="footer">
        <span>Hello, I'm a footer!</span>
    </div>
</body>

</html>