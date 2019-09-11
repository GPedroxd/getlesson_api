<?php  
    namespace DAO;

    use Core\DAO;
    use Model\User;
    use Model\Jwt;

    class UserDAO extends DAO{
        private $user;
        public function login(string $email, string $pass){
            $query = "select * from tbusuario where emailusuario like
                        :email and senhausuario like :pass";
            $query = $this->pdo->prepare($query);
            $query->bindValue(':email', $email);
            $query->bindValue('pass', md5($pass));
            $query->execute();
            if($query->rowCount() > 0){
                $data = $query->fetch();
                $user = new User(
                    $data['idUsuario']
                );
                $this->user = $user;
                return $user;
            }else{
                return false;
            }
        }
        public function sing_in($nome, $rm,$email, $pass, $nivel){
             if(!$this->emailExists($email)){
                $query = "insert into tbusuario set nomeUsuario = :nome,
                                                    rmUsuario = :rm,
                                                    emailUsuario = :email,
                                                    senhaUsuario = :pass,
                                                    nivel = :nivel";
                $query = $this->pdo->prepare($query);
                $query->bindValue(':nome', $nome);
                $query->bindValue(':rm', $rm);
                $query->bindValue(':email', $email);
                $query->bindValue(':pass', md5($pass));
                $query->bindValue(':nivel', $nivel);
                $query->execute();
                if($query->rowCount() > 0){
                    $user = new User($this->getId($email));
                    $this->user = $user;
                    return $user;
                }else{
                    return false;
                }
             }else{
                 return false;
             }
        }   
        public function createJwt(User $user){
            $jwt = new Jwt();
            return $jwt->create(array('idUsuario'=> $user->getIdusuario()
                                    ));
        }
        public function validate_jwt($token){
            $jwt = new Jwt();
            $info = $jwt->validate($token);
            if(!empty($info)){
                $this->user = new User($info->idUsuario);
                return true;
            }else{
                return false;
            }
        }   
        private function emailExists($email){
            $query = "select idusuario from tbUsuario where emailUsuario like :email";
            $query = $this->pdo->prepare($query);
            $query->bindValue(':email', $email);
            $query->execute();
            if($query->rowCount() > 0){
                return true;
            }else{
                return false;
            }
        }
        public function getId($email){
            $sql = "select id from tbUsuario where emailUsuario = :email";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":email", $email);
            $sql->execute();
            if($sql->rowCount() > 0){
                $id = $sql->fetch();
                $id = $id['idUsuario'];
                return $id;
            }else{
                return null;
            }
        }
        public function getIdUsuario(){
            return $this->user->getIdUsuario();
        }
        public function editUser($id, $data){
                $toChange = array();
                if(!empty($data['nomeUsuario'])){
                    $toChange['nomeUsuario'] = $data['nomeUsuario'];
                }
                if(!empty($data['emailUsuario'])){
                    if(filter_var($data['emailUsuario'], FILTER_VALIDATE_EMAIL)){
                        if(!$this->emailExists($data['emailUsuario'])){
                            $toChange['emailUsuario'] = $data['emailUsuario'];
                        }else{
                            return "Email já existente";
                        }
                    }else{
                        return "Email Inválido";
                    }
                }
                if(!empty($data['senhaUsuario'])){
                    $toChange['senhaUsuario'] = md5($data['senhaUsuario']);
                }
                if(count($toChange) > 0){
                    $fields  = array();
                    foreach($toChange as $k => $v){
                        $fields[] = $k.' = :'.$k;
                    }
                    $sql = "update tbusuario set ".implode(',',$fields )." where idUsuario = :id";
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
                $sql = "select * from tbUsuario where ativo != 0 and nivel = 2";
                $sql = $this->pdo->prepare($sql);
                $sql->execute();
                if($sql->rowCount() > 0){
                    return $sql->fetchAll(\PDO::FETCH_ASSOC);
                }else{
                    return 'nenhum usuário encontrado';
                }
        }
        public function delete($id){
                $sql = "update tbUsuario set ativo = 0 where idUsuario = :id";
                $sql = $this->pdo->prepare($sql);
                $sql->bindValue(':id', $id);
                $sql->execute();
                return '';
        }
    }