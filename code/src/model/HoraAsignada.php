<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/utils/DBConnection.php');

    class HoraAsignada {
        private $fecha;
        private $hora;
        private $medico;
        private $paciente;
        private $estado;

        public function __construct() {
            $this->fecha = '';
            $this->hora = '';
            $this->medico = '';
            $this->paciente = '';
            $this->estado = '';
        }
        public function getFecha() {
            return $this->fecha;
        }

        public function getHora() {
            return $this->hora;
        }
        
        public function getMedico() {
            return $this->medico;
        }

        public function getPaciente() {
            return $this->paciente;
        }
        public function getEstado() {
            return $this->estado;
        }

        private function loadFromDataMap($datamap) {
            $this->fecha = $datamap['fecha'];
            $this->hora = $datamap['hora'];
            $this->medico = $datamap['medico'];
            $this->paciente = $datamap['paciente'];
            $this->estado = $datamap['estado'];
        }
        public function insertHoraAsignada($fecha, $hora, $medico, $paciente) {
            $dbconnection = new DBConnection();
            $values = array(
                'fecha' => $fecha,
                'hora' => $hora,
                'medico' => $medico,
                'paciente' => $paciente,
                'estado' => 'Asignada'
            );
            $dbconnection->executeQuery('BEGIN;');
            $dbconnection->executeQuery('LOCK TABLE horasasignadas;');
            $rtn = $dbconnection->executeInsert('horasasignadas', $values);
            $dbconnection->executeQuery('COMMIT;');
            return $rtn;
        }
        public function getHorasVisita($medico) {
            $dbconnection = new DBConnection();

            $condition = array('medico' => $medico);
            $result = $dbconnection->executeSelect('horasasignadas', $condition);

            $horas = array();
            if($result != null) {
                foreach($result as $hora) {
                    $h = new HoraAsignada();
                    $h->loadFromDataMap($hora);
                    array_push($horas, $h);
                }
            }
            return $horas;
        }
        public function cancelHoraVisita($fecha, $hora, $medico) {
            $dbconnection = new DBConnection();
            $condition = array(
                'fecha' => $fecha,
                'hora' => $hora,
                'medico' => $medico
            );
            $result = $dbconnection->executeDelete('horasasignadas', $condition);
            return $result;
        }
        public function finalizarHoraVisita($fecha, $hora, $medico) {
            $dbconnection = new DBConnection();
            $query = "UPDATE horasasignadas SET estado='Finalizada' WHERE fecha='".$fecha."' AND hora='".$hora."' AND medico='".$medico."';";
            error_log($query);
            $result = $dbconnection->executeQuery($query);
            return $result;
        }
        public function getHorasVisitaByPaciente($dni) {
            $dbconnection = new DBConnection();

            $condition = array('paciente' => $dni);
            $result = $dbconnection->executeSelect('horasasignadas', $condition);

            $horas = array();
            if($result != null) {
                foreach($result as $hora) {
                    $h = new HoraAsignada();
                    $h->loadFromDataMap($hora);
                    array_push($horas, $h);
                }
            }
            return $horas;
        }
        public function modificarHoraVisita($fecha, $hora, $medico, $newfecha, $newhora, $newpaciente) {
            $dbconnection = new DBConnection();
            $condition = array(
                'fecha' => $fecha,
                'hora' => $hora,
                'medico' => $medico
            );
            $values = array(
                'fecha' => $newfecha,
                'hora' => $newhora,
                'paciente' => $newpaciente
            );
            $result = $dbconnection->executeUpdate('horasasignadas', $condition, $values);
            return $result;
        }
    }
?>