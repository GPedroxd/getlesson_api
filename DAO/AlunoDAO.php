<?php
    namespace DAO;
    
    use Core\DAO;

    class AlunoDAO extends DAO{
        public function getAll($idturma){
            $sql = "select tbusuario.idusuario, tbusuario.nomeusuario, tbusuario.rmusuario, tbusuario.emailusuario from tbmatricula 
                                                                inner join tbusuario on tbmatricula.idusuario = tbusuario.idusuario 
                                                                inner join tbTurma on tbTurma.idturma = tbmatricula.idturma 
                                                                where tbturma.idturma = :id;";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(':id', $idturma);
            $sql->execute();
            if($sql->rowCount() > 0){
                return $sql->fetchAll(\PDO::FETCH_ASSOC);
            }else{
                return false;
            }
            
        }
    }