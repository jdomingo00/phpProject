<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/utils/DBConnection.php');

    class User {
        private $uname;
        private $password;
        private $fullname;
        private $signindate;
        private $lastlogin;
        private $lastlogout;
        private $type;


        public function __construct() {
            $this->uname = '';
            $this->password = '';
            $this->fullname = '';
            $this->signindate = '';
            $this->lastlogin = '';
            $this->lastlogout = '';
            $this->type = '';
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

        public function checkLoginData($uname, $passwd) {
            $dbconnection = new DBConnection();

            $condition = array('uname' => $uname);
            $result = $dbconnection->executeSelect('users', $condition);

            if($result != null && $result[0]['password'] == $passwd) {
                $this->loadFromDataMap($result[0]);
                return true;
            }
            return false;
        }
        private function loadFromDataMap($datamap) {
            $this->uname = $datamap['uname'];
            $this->fullname = $datamap['fullname'];
            $this->signindate = $datamap['signindate'];
            $this->lastlogin = $datamap['lastlogin'];
            $this->lastlogout = $datamap['lastlogout'];
            $this->type = $datamap['type'];
        }
        public function updateLoginDate($uname) {
            $dbconnection = new DBConnection();

            $query = "UPDATE users SET lastlogin='". date('Y-m-d') . "' WHERE uname='" . $uname . "';";
            $result = $dbconnection->executeQuery($query);
            $this->lastlogin = date('Y-m-d');
            return $result;
        }
        public function updateLogoutDate($uname) {
            $dbconnection = new DBConnection();

            $query = "UPDATE users SET lastlogout='". date('Y-m-d') . "' WHERE uname='" . $uname . "';";
            $result = $dbconnection->executeQuery($query);
            $this->lastlogout = date('Y-m-d');
            return $result;
        }
        public static function registerP($uname, $password, $fullname, $dni, $fecNacimiento, $mutua) {
            $dbconnection = new DBConnection();
            $values = array(
                'uname' => $uname,
                'password' => $password,
                'fullname' => $fullname,
                'signindate' => date('Y-m-d'),
                'lastlogin' => '',
                'lastlogout' => '',
                'type' => 'p',
                'dni' => $dni,
                'fecnacimiento' => $fecNacimiento,
                'mutua' => $mutua
            );
            return $dbconnection->executeInsert('pacientes', $values);
        }
        public static function registerM($uname, $password, $fullname, $numcolegiado, $departamento) {
            $dbconnection = new DBConnection();
            $values = array(
                'uname' => $uname,
                'password' => $password,
                'fullname' => $fullname,
                'signindate' => date('Y-m-d'),
                'lastlogin' => '',
                'lastlogout' => '',
                'type' => 'm',
                'numcolegiado' => $numcolegiado,
                'departamento' => $departamento
            );
            return $dbconnection->executeInsert('medicos', $values);
        }
        public static function registerA($uname, $password, $fullname, $dni, $horaInicio, $horaFinal) {
            $dbconnection = new DBConnection();
            $values = array(
                'uname' => $uname,
                'password' => $password,
                'fullname' => $fullname,
                'signindate' => date('Y-m-d'),
                'lastlogin' => '',
                'lastlogout' => '',
                'type' => 'a',
                'dni' => $dni,
                'horainicio' => $horaInicio,
                'horafinal' => $horaFinal
            );
            return $dbconnection->executeInsert('administradores', $values);
        }
        // public static function registerClient($uname, $passwd, $name, $surname1, $surname2, $dni, $address, $city, $postalCode) {
        //     $dbconnection = new DBConnection();
        //     $rand = rand ( 1 , 4 );
        //     $values = array(
        //         'uname' => $uname,
        //         'passwd' => $passwd,
        //         'name' => $name,
        //         'surname1' => $surname1,
        //         'surname2' => $surname2,
        //         'image' => 'dog'.$rand.'.jpg',
        //         'dni' => $dni,
        //         'address' => $address,
        //         'city' => $city,
        //         'postalcode' => $postalCode
        //     );
        //     return $dbconnection->executeInsert('client', $values);
        // }

        // public static function createClientFromUname($uname) {
        //     $dbconnection = new DBConnection();

        //     $condition = array('uname' => $uname);
        //     $result = $dbconnection->executeSelect('client', $condition);

        //     if($result != null) {
        //         $client = new Client();
        //         $client->loadFromDataMap($result[0]);

        //         return $client;
        //     }
        //     return null;
        // }

       

        // public function deleteUser($uname) {
        //     $dbconnection = new DBConnection();
        //     $condition = array('uname' => $uname);
        //     error_log($condition);
        //     $result = $dbconnection->deleteUser('client', $condition);
        //     return $result;
        // }

    }

?>