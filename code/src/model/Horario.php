<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/utils/DBConnection.php');

    class Horario {
        private $medico;
        private $dia;
        private $horaentrada;
        private $horasalida;

        public function __construct() {
            $this->medico = '';
            $this->dia = '';
            $this->horaentrada = '';
            $this->horasalida = '';
        }
        public function getMedico() {
            return $this->medico;
        }

        public function getDia() {
            return $this->dia;
        }
        
        public function getHoraEntrada() {
            return $this->horaentrada;
        }

        public function getHoraSalida() {
            return $this->horasalida;
        }

        private function loadFromDataMap($datamap) {
            $this->medico = $datamap['medico'];
            $this->dia = $datamap['dia'];
            $this->horaentrada = $datamap['horaentrada'];
            $this->horasalida = $datamap['horasalida'];
        }

        public function getHorarioByMedicoAndDia($medico, $dia) {
            $dbconnection = new DBConnection();

            $condition = array(
                'medico' => $medico, 
                'dia' => $dia
            );
            $result = $dbconnection->executeSelect('horario', $condition);

            $horarios = array();
            if($result != null) {
                foreach($result as $horario) {
                    $h = new Horario();
                    $h->loadFromDataMap($horario);
                    array_push($horarios, $h);
                }
            }
            return $horarios;

        }



    }

?>