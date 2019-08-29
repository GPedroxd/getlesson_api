<?php
    namespace DAO;

    use Core\DAO;
    use Model\Turma;

    class TurmaDAO extends DAO{
        private $turma;
        public function register($nomeTurma, $semestreTurma, $anoTurma
                                    , $fimTurma, $curso, $periodo){
            $sql = "insert into tbTurma set nomeTurma = :turma,
                    semestreTurma = :semestreTurma, 
                    anoTurma = :anoTurma,
                    ultimoDiaTurma = :fimTurma,
                    idCurso = :curso, idPeriodo = :periodo;
                    ";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":turma", $nomeTurma);
            $sql->bindValue(":semestreTurma", $semestreTurma);
            $sql->bindValue(":anoTurma", $anoTurma);
            $sql->bindValue(":fimTurma", $fimTurma);
            $sql->bindValue(":curso", $curso);
            $sql->bindValue(":periodo", $periodo);
            $sql->execute();

            if($sql->rowCount() > 0){
                $this->turma = new Turma($data['idTurma']);
                return  $data;
            }else{
                false;
            }
        } 
        public function getTurma(){
                return $this->turma;
        }
        public function setTurma($turma){
                $this->turma = $turma;

                return $this;
        }
    }