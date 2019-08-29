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
                    $data = $query->fetch();
                    $user = new User(
                        $data['idUsuario']
                    );
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
        public function getId(){
            return $this->user->getIdUsuario();
        }
    }