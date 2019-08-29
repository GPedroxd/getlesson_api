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
        public function getAll(){
            $sql = "select * from tbComponente";
            $sql = $this->pdo->prepare($sql);
            $sql->execute();
            if($sql->rowCount() > 0){
                $dados = $sql->fetchAll(\PDO::FETCH_ASSOC);
                
                return $dados;
            }else{
                return false;
            }
        }
    }