<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/model/User.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/model/Medico.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/model/Horario.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/model/HoraAsignada.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/model/Departamento.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/model/Paciente.php');

    class PacientesController {
        public function getAll() {
            $result = Paciente::getAll();
            return $result;
        }
    }
?>