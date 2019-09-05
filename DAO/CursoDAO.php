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
        public function delete($id){
            $sql = "update tbCurso set ativo = 0 where idCurso = :id";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(':id', $id);
            $sql->execute();
            return '';
        }
        public function editCurso($id, $data){
            $toChange = array();
            if(!empty($data['nomeCurso'])){
                $toChange['nomeCurso'] = $data['nomeCurso'];
            }
            if(!empty($data['ativo'])){
                $toChange['ativo'] = $data['ativo'];
            }
            if(count($toChange) > 0){
                $fields  = array();
                foreach($toChange as $k => $v){
                    $fields[] = $k.' = :'.$k;
                }
                $sql = "update tbCurso set ".implode(',',$fields )." where idCurso = :id";
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
            $sql = "select * from tbCurso ";
            $sql = $this->pdo->prepare($sql);
            $sql->execute();
            if($sql->rowCount() > 0){
                $dados = $sql->fetchAll(\PDO::FETCH_ASSOC);
                return $dados;
            }else {
                return 'Cursos Não encontrados';
            }
        }
    }