<?php
    class DBConnection {
        private $dbconnection = null;

        public function __construct() {
            $this->dbconnection = pg_connect("host=localhost dbname=gestionhospital user=proyecto1user password=1234");
            if($this->dbconnection == false) {
                error_log("DB connection error: " . pg_last_error());
                $this->dbconnection = null;
            }
        }

        public function __destruct() {
            if(!pg_close($this->dbconnection)) {
                error_log("DB closing error: " . pg_last_error());
            }
            $this->dbconnection = null;
        }

        public function executeSelect($table, $conditions) {
            $result = pg_select($this->dbconnection, $table, $conditions);
            if(!$result) {
                error_log("DB select error: " + pg_last_error());
                return null;
            } else {
                return $result;
            }
        }

        public function executeInsert($table, $values) {
            $result = pg_insert($this->dbconnection, $table, $values);
            if(!$result) {
                error_log("DB insert error: " + pg_last_error());
                return false;
            }
            return true;
        }
        public function deleteUser($table, $values) {
            $result = pg_delete($this->dbconnection, $table, $values);
             if(!$result) {
                error_log("DB insert error: " + pg_last_error());
                return false;
            }
            return true;
        }
    }
?>