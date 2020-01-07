<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/model/User.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/model/Medico.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/model/Horario.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/model/HoraAsignada.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/model/Departamento.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/model/Paciente.php');

    class MedicosController {
        public function getMedicosByDepartamentoId($id) {
            $result = Medico::getMedicosByDepartamentoId($id);
            return $result;
        }
        public function insertNewHoraVisita($fecha, $hora, $medico, $paciente) {
            $dias = array('','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
            $dia = $dias[date('N', strtotime($fecha))];
            $horarios = Horario::getHorarioByMedicoAndDia($medico, $dia);
            if (count($horarios)<1){
                return false;
            }
            $result = HoraAsignada::insertHoraAsignada($fecha, $hora, $medico, $paciente);
            return $result;
        }
        public function getHorasVisitaByMedico($medico) {
            $horas = HoraAsignada::getHorasVisita($medico);
            return $horas;
        }
        public function getPacientesDNIList() {
            $pacientes = Paciente::getAll();
            return $pacientes;
        }
        public function cancelHoraVisita($fecha, $hora, $medico) {
            $horas = HoraAsignada::cancelHoraVisita($fecha, $hora, $medico);
            return $horas;
        }
        public function modificarHoraVisita($fecha, $hora, $medico, $newfecha, $newhora, $newpaciente) {
            $dias = array('','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
            $dia = $dias[date('N', strtotime($newfecha))];
            $horarios = Horario::getHorarioByMedicoAndDia($medico, $dia);
            if (count($horarios)<1){
                return false;
            }
             $horas = HoraAsignada::modificarHoraVisita($fecha, $hora, $medico, $newfecha, $newhora, $newpaciente);
             return $horas;
        }
    }

?>