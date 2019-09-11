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
                return true;
            }else{
                return false;
            }
        } 
        public function delete($id){
            $sql = "update tbTurma set ativo = 0 where idTurma = :id";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(':id', $id);
            $sql->execute();
            return '';
        }
        public function editTurma($id ,$data){
            $toChange = array();
            if(!empty($data['nomeTurma'])){
                $toChange['nomeTurma'] = $data['nomeTurma'];
            }
            if(!empty($data['semestreTurma'])){
                $toChange['semestreTurma'] = $data['semestreTurma'];
            }
            if(!empty($data['anoTurma'])){
                $toChange['anoTurma'] = $data['anoTurma'];
            }
            if(!empty($data['ultimaDiaTurma'])){
                $toChange['ultimaDiaTurma'] = $data['ultimaDiaTurma'];
            }
            if(!empty($data['idCurso'])){
                $toChange['idCurso'] = $data['idCurso'];
            }
            if(!empty($data['idPeriodo'])){
                $toChange['idPeriodo'] = $data['idPeriodo'];
            }
            if(!empty($data['ativo'])){
                $toChange['ativo'] = $data['ativo'];
            }
            if(count($toChange) > 0){
                $fields  = array();
                foreach($toChange as $k => $v){
                    $fields[] = $k.' = :'.$k;
                }
                $sql = "update tbTurma set ".implode(',',$fields )." where idTurma = :id";
                $sql = $this->pdo->prepare($sql);
                $sql->bindValue(':id', $id);
                foreach($toChange as $k => $v){
                    $sql->bindValue(':'.$k, $v);
                }
                $sql->execute();
                return '';
            }
        }
        public function getAll(){
            $sql = "select * from tbTurma where ativo = 1 ";
            $sql = $this->pdo->prepare($sql);
            $sql->execute();
            if($sql->rowCount() > 0){
                $dados = $sql->fetchAll(\PDO::FETCH_ASSOC);
                return $dados;
            }else {
                return 'Turmas Não encontrados';
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