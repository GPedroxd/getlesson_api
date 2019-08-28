<?php   
    namespace Model;

    use Core\Controller;

    class User{
        private $idusuario;
        private $nomeusuario;
        private $rmusuario;
        private $emailusuario;
        private $senhausuario;
        private $nivel;

        public function __construct($id, $nome, $rm, $email, $senha, $nivel){
                $this->setIdusuario($id);
                $this->setNomeusuario($nome);
                $this->setRmusuario($rm);
                $this->setSenhausuario($senha);
                $this->setEmailusuario($email);
                $this->setNivel($nivel);
        }        
        public function getIdusuario(){
                return $this->idusuario;
        } 
        public function setIdusuario($idusuario){
                $this->idusuario = $idusuario;
                return $this;
        }
        public function getNomeusuario(){
                return $this->nomeusuario;
        }
        public function setNomeusuario($nomeusuario){
                $this->nomeusuario = $nomeusuario;
                return $this;
        }
        public function getRmusuario(){
                return $this->rmusuario;
        }
        public function setRmusuario($rmusuario){
                $this->rmusuario = $rmusuario;
                return $this;
        }
        public function getEmailusuario(){
                return $this->emailusuario;
        } 
        public function setEmailusuario($emailusuario){
                $this->emailusuario = $emailusuario;
                return $this;
        }
        public function getSenhausuario(){
                return $this->senhausuario;
        }
        public function setSenhausuario($senhausuario){
                $this->senhausuario = $senhausuario;
                return $this;
        }
        public function getNivel(){
                return $this->nivel;
        }
        public function setNivel($nivel){
                $this->nivel = $nivel;
                return $this;
        }
    }