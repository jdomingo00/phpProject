<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/utils/DBConnection.php');

    class Paciente {
        private $uname;
        private $password;
        private $fullname;
        private $signindate;
        private $lastlogin;
        private $lastlogout;
        private $type;
        private $dni;
        private $fecnacimiento;
        private $mutua;


        public function __construct() {
            $this->uname = '';
            $this->password = '';
            $this->fullname = '';
            $this->signindate = '';
            $this->lastlogin = '';
            $this->lastlogout = '';
            $this->type = '';
            $this->dni = '';
            $this->fecnacimiento = '';
            $this->mutua = '';
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
        public function getDNI() {
            return $this->dni;
        }
        public function getFecNacimiento() {
            return $this->fecnacimiento;
        }
        public function getMutua() {
            return $this->mutua;
        }
        private function loadFromDataMap($datamap) {
            $this->uname = $datamap['uname'];
            $this->fullname = $datamap['fullname'];
            $this->signindate = $datamap['signindate'];
            $this->lastlogin = $datamap['lastlogin'];
            $this->lastlogout = $datamap['lastlogout'];
            $this->type = $datamap['type'];
            $this->dni = $datamap['dni'];
            $this->fecnacimiento = $datamap['fecnacimiento'];
            $this->mutua = $datamap['mutua'];
        }
       public function getAll() {
            $dbconnection = new DBConnection();
            $query = 'SELECT dni FROM pacientes';
            $result = $dbconnection->executeAndReturnQuery($query);
            
            if($result != null) {
                $return = array();
                $p = array();
                for ($i=0;$i<$dbconnection->getResultNumRow($result);$i++) {
                    array_push($p, $dbconnection->getResultAsArray($result, $i));
                }
                foreach($p as $paciente) {
                        $pac = new Paciente;
                        $pac->loadFromDataMap($paciente);
                        array_push($return, $pac);
                    }
               return $return;
            }
            return array();
        }

    }

?>