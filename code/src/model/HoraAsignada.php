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
            return $dbconnection->executeInsert('horasasignadas', $values);
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
    }
?>