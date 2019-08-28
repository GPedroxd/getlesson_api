<?php
    namespace Core;

    class DAO {
        protected $pdo;
        protected $info;
        public function __construct(){
            global $pdo;
            global $info;
            $this->pdo = $pdo;
            $this->$info = $info;

        }
    }