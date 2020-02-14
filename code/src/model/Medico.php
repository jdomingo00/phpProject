<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/utils/DBConnection.php');

    class Medico {
        private $uname;
        private $password;
        private $fullname;
        private $signindate;
        private $lastlogin;
        private $lastlogout;
        private $type;
        private $numcolegiado;
        private $departamento;


        public function __construct() {
            $this->uname = '';
            $this->password = '';
            $this->fullname = '';
            $this->signindate = '';
            $this->lastlogin = '';
            $this->lastlogout = '';
            $this->type = '';
            $this->numcolegiado = '';
            $this->departamento = '';
        }
        public function getUsername() {
            return $this->uname;
        }

        public function getFullName() {
            return $this->fullname;
        }
        
        public function getSignInDate() {
            return $this->signindate;
        }

        public function getLastLogin() {
            return $this->lastlogin;
        }

        public function getLastLogout() {
            return $this->lastlogout;
        }

        public function getType() {
            return $this->type;
        }
        public function getNumColegiado() {
            return $this->numcolegiado;
        }
        public function getDepartamento() {
            return $this->departamento;
        }
        private function loadFromDataMap($datamap) {
            $this->uname = $datamap['uname'];
            $this->fullname = $datamap['fullname'];
            $this->signindate = $datamap['signindate'];
            $this->lastlogin = $datamap['lastlogin'];
            $this->lastlogout = $datamap['lastlogout'];
            $this->type = $datamap['type'];
            $this->numcolegiado = $datamap['numcolegiado'];
            $this->departamento = $datamap['departamento'];
        }
        public function getMedicosByDepartamentoId($id) {
            $dbconnection = new DBConnection();

            $condition = array('departamento' => $id);
            $result = $dbconnection->executeSelect('medicos', $condition);

            $medicos = array();
            if($result != null) {
                foreach($result as $medico) {
                    $med = new Medico();
                    $med->loadFromDataMap($medico);
                    array_push($medicos, $med);
                }
            }
            return $medicos;
        }
        public function getNumColegiadoByUname($uname) {
            $dbconnection = new DBConnection();

            $condition = array('uname' => $uname);
            $result = $dbconnection->executeSelect('medicos', $condition);
            $numcolegiado = "";
            $med = new Medico();
            foreach($result as $medico) {
                $med->loadFromDataMap($medico);
                $numcolegiado = $med->getNumColegiado();
            }
            return $numcolegiado;
        }

    }

?>