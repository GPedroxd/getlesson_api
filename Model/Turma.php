<?php
    namespace Model;
    
    class Turma{
        private $id;
        public function __construct($id){
            $this->setId($id);
        }
        public function getId(){
                return $this->id;
        }
        public function setId($id){
                $this->id = $id;
                return $this;
        }
    }