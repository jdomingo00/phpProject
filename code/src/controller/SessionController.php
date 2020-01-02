<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/model/User.php');

    class SessionController {
        
        public function login($uname, $passwd) {
            if(isset($_COOKIE['PHPSESSID'])) return;

            $user = new User();
            if($user->checkLoginData($uname, $passwd)) {
                $rtn = $user->updateLoginDate($uname);
                if ($rtn) {
                    session_start();
                    $_SESSION['uname'] = $user->getUsername();
                    $_SESSION['fullname'] = $user->getFullName();
                    $_SESSION['type'] = $user->getType();
                    return 1;
                }
                return 2;
            }
            return 0;
        }

        // public function register($uname, $passwd, $name, $surname1, $surname2, $dni, $address, $city, $postalCode) {
        //     $result = Client::registerClient($uname, $passwd, $name, $surname1, $surname2, $dni, $address, $city, $postalCode);
        //     if($result) {
        //         session_start();
        //         $_SESSION['name'] = $name . ' ' . $surname1;
        //         if($surname2 != '') $_SESSION['name'] = $_SESSION['name'] . ' ' . $surname2;
        //         $client = Client::createClientFromUname($uname);
        //         $_SESSION['image'] = $client->getImage();
        //         $_SESSION['uname'] = $uname;
        //         $_SESSION['cart'] = array();
        //     }
        //     return $result;
        // }
        public function registerP($uname, $password, $fullname, $dni, $fecNacimiento, $mutua) {
            $result = User::registerP($uname, $password, $fullname, $dni, $fecNacimiento, $mutua);
            return $result;
        }
        public function checkSessionStarted() {
            if(isset($_COOKIE['PHPSESSID'])) {
                session_start();
                return true;
            }
            return false;
        }

        public function logout() {
            if(!isset($_COOKIE['PHPSESSID'])) return;
            $user = new User();
            $rtn = $user->updateLogoutDate($_SESSION['uname']);
            session_unset();
            session_destroy();
            setcookie('PHPSESSID', '', time() - 60, '/');
        }
    }

?>