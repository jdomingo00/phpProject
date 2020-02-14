<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/model/User.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/model/Medico.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/model/Horario.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/model/HoraAsignada.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/model/Departamento.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/model/Paciente.php');

    class FileController {
        public function getFileContent($dni, $dep) {
            return User::getFileContent($dni, $dep);
        }
        public function addFileContent($dni, $dep, $filecontent) {
            User::addFileContent($dni, $dep, $filecontent);
        }
    }

?>