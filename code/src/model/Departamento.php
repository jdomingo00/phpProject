<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/code/src/utils/DBConnection.php');

    class Departamento {
        private $id;
        private $nombre;

        public function __construct() {
            $this->id = '';
            $this->nombre = '';
        }

        public function getId() {
            return $this->id;
        }

        public function getNombre() {
            return $this->nombre;
        }
        
        public function getAll() {
            $dbconnection = new DBConnection();
            $query = 'SELECT * FROM departamentos;';
            $result = $dbconnection->executeAndReturnQuery($query);
            if($result != null) {
                $q = $dbconnection->getResultNumRow($result);
                $return = array();
                for ($i = 0; $i < $q; $i++) {
                    $dep = $dbconnection->getResultAsArray($result, $i);
                    $return += ['id'.$i.''=> $dep['id']];
                    $return += ['nombre'.$i.''=>$dep['nombre']];
                }
                return $return;
            }
            return array();
        }
        // public function getDepartamento($row) {
        //     $dbconnection = new DBConnection();
        //     $query = 'SELECT * FROM departamentos';
        //     $result = $dbconnection->executeAndReturnQuery($query);
        //     if($result != null) {
        //         return $dbconnection->getResultAsArray($result, $row);
        //     }
        //     return array();
        // }
        // public function getQuantity() {
        //     $dbconnection = new DBConnection();
        //     $query = 'SELECT * FROM departamentos';
        //     $result = $dbconnection->executeAndReturnQuery($query);
        //     if($result != null) {
        //         return $dbconnection->getResultNumRow($result);
        //     }
        //     return 0;
        // }

        public function getDepName($depid) {
             $dbconnection = new DBConnection();
            $condition = array('id' => $depid);
            $result = $dbconnection->executeSelect('departamentos', $condition);
            $depname = "";
            $dep = new Departamento();
            foreach($result as $medico) {
                $dep->loadFromDataMap($medico);
                $depname = $dep->getNombre();
            }
            return $depname;
        }

        private function loadFromDataMap($datamap) {
            $this->id = $datamap['id'];
            $this->nombre = $datamap['nombre'];
        }

    }

?>