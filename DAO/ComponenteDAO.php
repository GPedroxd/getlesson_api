<?php   
    namespace DAO;

    use Core\DAO;
    use Model\Componente;

    class ComponenteDAO extends DAO{
        public function register($nome, $sigla, $idusuario, $idTurma){
            $idcomponente = $this->insertComponente($nome, $sigla);
            if($idcomponente != 0){
                $id = $this->addProfessor($idusuario, $idcomponente, $idTurma);
                if($id!= 0){
                    return $id;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }
        public function addProfessor($idusuario, $idcomponente, $idTurma){
            $sql = "insert into tbComponenteProfessor set idTurma = :idturma, idusuario = :idusuario, idComponente = :idComponente;";
                $sql = $this->pdo->prepare($sql);
                $sql->bindValue(':idturma', $idTurma);
                $sql->bindValue(':idusuario', $idusuario);
                $sql->bindValue(':idComponente', $idcomponente[0]);
                $sql->execute();
                $sql2 ="select last_insert_id();";
                $sql2 = $this->pdo->prepare($sql2);
                $sql2->execute();
                if($sql2->rowCount() > 0){
                    return $sql2->fetch();
                } else{
                    return 0;
                }
        }
        private function insertComponente($nome, $sigla){
            $sql = "insert into tbComponente set nomeComponente = :nome, siglaComponente = :sigla; ";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":nome", $nome);
            $sql->bindValue(":sigla", $sigla);
            $sql->execute();
            $sql2 ="select last_insert_id();";
            $sql2 = $this->pdo->prepare($sql2);
            $sql2 ->execute();
            if($sql2->rowCount() > 0){
                $a = $sql2->fetch();
                return $a[0];
            } else{
                return 0;
            }
        }
        public function delete($id){
            $sql = "update tbComponente set ativo = 0 where idComponente = :id;"; 
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(':id', $id);
            $sql->execute();
            return '';
        }
        public function editComponente($id, $data){
            $toChange = array();
            if(!empty($data['siglaComponente'])){
                $toChange['siglaComponente'] = $data['siglaComponente'];
            }
            if(!empty($data['nomeComponente'])){
                $toChange['nomeComponente'] = $data['nomeComponente'];
            }
            if(!empty($data['idTurma'])){
                $toChange['idTurma'] = $data['idTurma'];
            }
            if(!empty($data['idUsuario'])){
                $toChange['idUsuario'] = $data['idUsuario'];
            }
            if(!empty($data['ativo'])){
                $toChange['ativo'] = $data['ativo'];
            }
            if(count($toChange) > 0){
                $fields  = array();
                foreach($toChange as $k => $v){
                    $fields[] = $k.' = :'.$k;
                }
                $sql = "update tbcomponenteprofessor set ".implode(',',$fields )." where idcomponenteprofessor = :id;";
                $sql = $this->pdo->prepare($sql);
                $sql->bindValue(':id', $id);
                foreach($toChange as $k => $v){
                    $sql->bindValue(':'.$k, $v);
                }
                
                return $sql->execute();
            }
        }
        public function getAll(){
            $array = array();
            $sql = "select tbcomponente.nomeComponente, tbcomponente.siglaComponente, tbcomponenteprofessor.idComponenteProfessor,
            tbcomponenteprofessor.idTurma, tbcomponenteprofessor.idUsuario, tbcomponente.idcomponente from tbcomponenteprofessor
            inner join tbusuario on tbusuario.idUsuario = tbcomponenteprofessor.idUsuario inner join
            tbturma on tbturma.idTurma = tbcomponenteprofessor.idTurma inner join 
            tbcomponente on tbcomponente.idComponente = tbcomponenteprofessor.idComponente where tbcomponente.ativo = 1;";
            $sql = $this->pdo->prepare($sql);
            $sql->execute();
            if($sql->rowCount() > 0){
                $array = $sql->fetchAll(\PDO::FETCH_ASSOC);  
            }
            return $array;
        }
        public function getByUsuario($id){
            $array = '';
            $sql = "select tbcomponente.nomeComponente, tbcomponente.siglaComponente, tbcomponenteprofessor.idComponenteProfessor,
            tbcomponenteprofessor.idTurma, tbcomponenteprofessor.idUsuario, tbcomponente.idcomponente from tbcomponenteprofessor
            inner join tbusuario on tbusuario.idUsuario = tbcomponenteprofessor.idUsuario inner join
            tbturma on tbturma.idTurma = tbcomponenteprofessor.idTurma inner join 
            tbcomponente on tbcomponente.idComponente = tbcomponenteprofessor.idComponente where tbcomponente.ativo = 1 and tbComponenteProfessor.idUsuario = :id";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(':id', $id);
            $sql->execute();
            if($sql->rowCount() > 0){
                $array = $sql->fetchAll(\PDO::FETCH_ASSOC);  
            }
            return $array;
        }
    }