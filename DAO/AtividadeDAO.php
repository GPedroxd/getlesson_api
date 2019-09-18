<?php
    namespace DAO;
    
    use Core\DAO;

    class AtividadeDAO extends DAO{
        public function getAll($idturma){
            
        }
        //INSERT DE ELEMENTOS DA ATIVIDADE;
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
                    return '';
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
                    $this->addResposta($idpergunta[0], $data[1]);
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
        //PEGANDO ELEMENTOS DA ATIVIDADE;
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
        //FAZER ATIVIDADE;
        public function fazerAtividade($data){
            $info = $data[0];
            $datas = $data[1];
            $sql = "insert into tbAlunoAtividade set idAluno = :idAluno, idAtividade = :idAtividade, dataHora = :data, idMenca = 5;";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(':idAluno', $info[1]);
            $sql->bindValue(':idAtividade', $info[2]);
            $sql->bindValue(':dataHora',$info[0]);
            if($sql->execute()){
                $sql = "select last_insert_id();";
                $sql = $this->pdo->prepare($sql);
                if($sql->execute()){
                    $a = $sql->fetch();
                    $this->submeterRespostas($a[0], $datas);
                    $this->calcularMenca($a[0], $info[2]);
                }else{
                    return 'AD';
                }
            }else{
                return 'AD';
            }
            return '';
        }
        public function submeterRespostas($idAtividade, $data){
            for($c = 0; $c < count($data); $c++){
                $quest = $data[$c];
                $certa = $this->validarResposta($quest[1], $quest[0]);
                $sql = "insert into tbalunoResposta set resposta = :resposta, idPergunta = :idPergunta, idalunoAtividade = :idAluno, acerto = :certa;";
                $sql = $this->pdo->prepare($sql);
                $sql->bindValue(':certa', $certa);
                $sql->bindValue(':resposta', $quest[0]);
                $sql->bindValue(':idPergunta', $quest[1]);
                $sql->bindValue(':idAluno', $idAtividade);
                if($sql->execute()){

                }else{
                        return 'AD';
                }
            }
        }
        private function validarResposta($idpergunta, $resposta){
            $sql = "select certa from tbResposta where idPergunta = :id and resposta = :resposta;";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(':id', $idpergunta);
            $sql->bindValue(':resposta', $resposta);
            if($sql->execute()){
                if($sql->rowCount() > 0){
                    $r = $sql->fetch();
                    return $r[0];
                }else{
                    return 0;
                }
            }else{

            }
        }
        private function calcularMenca($id, $idAtividade){
            $ref = 0 ;
            $sql1 = "select count(idPergunta) from tbPergunta where idAtividade = :id;";
            $sql1 = $this->pdo->prepare($sql1);
            $sql1->bindValue(':id', $idAtividade);
            if($sql1->execute()){
                $a = $sql1->fetch();
                $ref = $a[0];
            }
            $i = $ref/2;
            $r  = $i + ($ref/3);
            $b = $i + ($ref/3);
            $mb  = $b + ($ref/3);
            $sql = "select count(acerto) from tbAlunoRespota where idAlunoAtividade = :id;";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(':id', $id);
            if($sql->execute()){
                $r = $sql->fetch();
                $a = $r[0];
                if($a < $i){
                    return 1;
                }else if($a < $r){
                    return 2;
                }else if($a < $b){
                    return 3;
                }else{
                    return 4;
                }
            }
        }
    }