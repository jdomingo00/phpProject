<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/utils/DBConnection.php');

    class Horario {
        private $medico;
        private $dia;
        private $hora;

        public function __construct() {
            $this->medico = '';
            $this->dia = '';
            $this->hora = '';
        }
        public function getMedico() {
            return $this->medico;
        }

        public function getDia() {
            return $this->dia;
        }
        
        public function getHora() {
            return $this->hora;
        }

        private function loadFromDataMap($datamap) {
            $this->medico = $datamap['medico'];
            $this->dia = $datamap['dia'];
            $this->hora = $datamap['hora'];
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
                    array_push($horarios, $horario['hora']);
                }
            }
            return $horarios;

        }
        public function getDiasVisitaByMedico($medico) {
            $dbconnection = new DBConnection();
            $result = $dbconnection->executeAndReturnQuery("select distinct(dia) from horario where medico='".$medico."';");
            $horario = array();
            if($result != null) {
                $q = $dbconnection->getResultNumRow($result);
                for ($i = 0; $i < $q; $i++) {
                    $dia = $dbconnection->getResultAsArray($result, $i);
                    array_push($horario, $dia['dia']);
                }
            }
            return $horario;

        }



    }

?>