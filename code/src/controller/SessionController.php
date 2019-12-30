<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/model/User.php');

    class SessionController {
        
        public function login($uname, $passwd) {
            if(isset($_COOKIE['PHPSESSID'])) return;

            $user = new User();
            if($user->checkLoginData($uname, $passwd)) {
                session_start();

                $_SESSION['uname'] = $user->getUsername();
                $_SESSION['fullname'] = $user->getFullName();
                $_SESSION['type'] = $type;

                return 1;
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

        public function checkSessionStarted() {
            if(isset($_COOKIE['PHPSESSID'])) {
                session_start();
                return true;
            }
            return false;
        }

        public function logout() {
            if(!isset($_COOKIE['PHPSESSID'])) return;

            session_unset();
            session_destroy();
            setcookie('PHPSESSID', '', time() - 60, '/');
        }
    }

?>