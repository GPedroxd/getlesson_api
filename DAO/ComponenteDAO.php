<?php   
    namespace DAO;

    use Core\DAO;
    use Model\Componente;

    class ComponenteDAO extends DAO{
        public function register($nome, $sigla){
            $sql = "insert into tbComponente set nomeComponente = :nome,
                                                                        siglaComponente = :sigla";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":nome", $nome);
            $sql->bindValue(":sigla", $sigla);
            $sql->execute();
            if($sql->rowCount() > 0){
                return true;
            }else{
                return false;
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
            if(!empty($data['ativo'])){
                $toChange['ativo'] = $data['ativo'];
            }
            if(count($toChange) > 0){
                $fields  = array();
                foreach($toChange as $k => $v){
                    $fields[] = $k.' = :'.$k;
                }
                $sql = "update tbComponente set ".implode(',',$fields )." where idComponente = :id";
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
            $array = array();
            $sql = "select * from tbComponente";
            $sql = $this->pdo->prepare($sql);
            $sql->execute();
            if($sql->rowCount() > 0){
                $array = $sql->fetchAll(\PDO::FETCH_ASSOC);  
            }
            return $array;
        }
    }