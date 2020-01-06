<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/model/User.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/model/Medico.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/model/Departamento.php');

    class MedicosController {
        public function getMedicosByDepartamentoId($id) {
            $result = Medico::getMedicosByDepartamentoId($id);
            return $result;
        }
    }

?>