<?php
    namespace DAO;
    
    use Core\DAO;

    class AtividadeDAO extends DAO{
        public function getAll($idturma){
            
        }
        public function getAtividade($idAtividade){
            $data = array();
            $sql = "select * from tbatividade where idatividade = :id;";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(':id', $idAtividade);
            $sql->execute(); 
            if($sql->rowCount() > 0){
                $b = $sql->fetchAll(\PDO::FETCH_ASSOC); 
                $info =$b[0];
                $data = $this->getPerguntas($info['idAtividade']);
                $resp = array('info' =>$info);
                $resp ['data'] = $data;
                return $resp;
            }
            return 'Nenhuma Atividade Encontrada';
        }
        public function insertAtividade($nome, $data){
            $sql = "insert into tbAtividade set nomeAtividade = :nome, dataHoraDeCriacao = :dataatividade,
            dataDeEntrega = :datadeentrega, idComponenteProfessor = :idcomponente";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(':idcomponente', $nome[0]);
            $sql->bindValue(':dataatividade', $nome[1]);
            $sql->bindValue(':datadeentrega', $nome[2]);
            $sql->bindValue(':nome', $nome[3]);
            if($sql->execute()){
                $sql2 = "select last_insert_id();";
                $sql2 = $this->pdo->prepare($sql2);
                if($sql2->execute()){
                    $id = $sql2->fetch();
                    $size = Count($data);
                    for($p = 0; $p < $size; $p++){
                        $q = $data[$p];
                        $this->addPergunta($id[0], $q);
                    }
                }else{
                    return 2;
                }
                
            }else{
                return 1;
            }
        }
        public function addPergunta($id, $data){
            $sql = "insert into tbpergunta set idatividade = :idatividade, pergunta = :pergunta, idtipoPergunta = 1";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(':idatividade', $id);
            $sql->bindValue(':pergunta', $data[0]);
            if($sql->execute()){
                $sql2 = "select last_insert_id();";
                $sql2 = $this->pdo->prepare($sql2);
                if($sql2->execute()){
                    $idpergunta = $sql2->fetch();
                    $size = count($data[1]);
                    for($r = 0; $r <$size; $r++){
                        $this->addResposta($idpergunta[0], $data[1]);
                    }
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }
        public function addResposta($id, $data){
            $size = count($data);
            for($i = 0; $i < $size; $i++){
                $r = $data[$i];
                $sql = "insert into tbresposta set idpergunta = :idpergunta, resposta = :resposta, certa = :certa";
                $sql = $this->pdo->prepare($sql);
                $sql->bindValue(':idpergunta', $id);
                $sql->bindValue(':resposta', $r[0]);
                $sql->bindValue(':certa', $r[1]);
                if($sql->execute()){
                    return '';
                }else{
                    return false;
                }
            }
        }
        public function getPerguntas($id){
            $resp = array();
            $sql = "select * from tbPergunta where idAtividade = :id;";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(':id', $id);
            $sql->execute();
            if($sql->rowCount() > 0){
                $info = $sql->fetchAll(\PDO::FETCH_ASSOC);
                for($i = 0; $i < count($info); $i++){
                    $a = $info[$i];
                    $b = $this->getRespostas($a['idPergunta']);
                    $resp []= [$info[$i], $b];
                }
            }
            return $resp; 
        }
        public function getRespostas($id){
            $resp = array();
            $sql = "select * from tbResposta where idPergunta = :id;";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(':id', $id);
            $sql->execute();
            if($sql ->rowCount() > 0){
                $resp = $sql->fetchAll(\PDO::FETCH_ASSOC);
                return $resp;
            }
            return 'erro';
        }
        
    }