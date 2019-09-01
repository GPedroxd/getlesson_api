<?php
    namespace DAO;

    use Core\DAO;
use Model\Curso;

class CursoDAO extends DAO{
        private $curso;

        public function register($curso){
            if(!$this->validateCurso($curso)){
                $sql = "insert into tbCurso set nomeCurso = :curso";
                $sql = $this->pdo->prepare($sql);
                $sql->bindValue(':curso', $curso);
                $sql->execute();
                if($sql->rowCount() > 0){
                    return true;
                }else{
                    return false;
                }
            }
        }
        public function validateCurso($curso){
            $sql = "select idCurso  from tbCurso where nomeCurso = :curso";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(':curso', $curso);
            $sql->execute();
            if($sql->rowCount() > 0){
                return true;
            }else{
                return false;
            }
        }
        public function getCurso(){
            return $this->curso;
        }
        public function setCurso($curso){
            $this->curso = $curso;
            return $this;
        }
    }