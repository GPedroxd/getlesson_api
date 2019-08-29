<?php   
    namespace Model;

    class User{
        private $idusuario;

        public function __construct($id){
                $this->setIdusuario($id);
        }       
        public function getIdusuario(){
                return $this->idusuario;
        } 
        public function setIdusuario($idusuario){
                $this->idusuario = $idusuario;
                return $this;
        }
    }