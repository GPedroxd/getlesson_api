<?php
    namespace Controller;

    use Core\Controller;
    use DAO\UserDAO;
    use DAO\AlunoDAO;
    use Model\Jwt;

    class UserController extends Controller{
        private $dao;
        public function __construct(){
            $this->dao = new UserDAO();
        }

        //Controller Professores
        public function sing_in(){
            $array = array('error'=>'');
            $method = $this->getMethod();
            $data = $this->getRequestData();
            if($method == 'POST'){
                if(!empty($_POST['emailUsuario']) && !empty($_POST['senhaUsuario'])){
                    $user = $this->dao->login($data['emailUsuario'], $data['senhaUsuario']);
                    if($user){
                        $array ['jwt'] = $this->dao->createJwt($user);
                        $array ['idUsuario'] = $user->getIdusuario();
                    }else{
                        $array['error']= 'accesso negado';
                    }
                }else{
                    $array['error'] = 'campos vazios e/ou invalidos';
                }
            }else{
                $array ['error'] = 'Método de requisição incompativel';
            }
            $this->returnJson($array);
        }
        public function sing_up(){
            $array = array('error' =>'');
            $method = $this->getMethod();
            $data = $this->getRequestData();
            if($method == 'POST'){
                if(!empty($data['nomeUsuario']) && !empty($data['emailUsuario']) &&
                    !empty($data['senhaUsuario']) && !empty($data['rmUsuario'])
                    && !empty($data['nivel'])){
                    if(filter_var($data['emailUsuario'], FILTER_VALIDATE_EMAIL)){
                        $user =$this->dao->sing_in(
                            $data['nomeUsuario'],
                            $data['rmUsuario'],
                            $data['emailUsuario'],
                            $data['senhaUsuario'],
                            $data['nivel']
                        );
                        if($user){

                        }else{
                            $array ['error'] = 'E-mail já existente';
                        }
                    }else{
                        $array ['error'] = 'E-mail Invalido';
                    }
                }else{
                    $array['error'] = 'preencha todos os campos';
                }
            }else{
                $array ['error'] = 'Método de envio incompativel';
            }
            $this->returnJson($array);
        }
        public function view($id){
            $array = array('error'=>'', );
            $method = $this->getMethod();
            $data = $this->getRequestData();
            if(!empty($data['jwt']) && $this->dao->validate_jwt($data['jwt'])){
                    switch($method){
                        case 'PUT':
                            $array['error'] = $this->dao->editUser($id, $data);
                            break;
                        case 'DELETE':
                            $array ['error'] = $this->dao->delete($id);
                            break;
                        default:
                            $array['error'] = 'Método '.$method.' não disponivel';
                            break;
                    }
            }else{
                $array['error']= 'acesso negado';
            }
            $this->returnJson($array);
        }
        public function getAll(){
            $array = array('error' => '');
            $method = $this->getMethod();
            $data = $this->getRequestData();
            if(!empty($data['jwt']) && $this->dao->validate_jwt($data['jwt'])){
                $array['data'] = $this->dao->getAll();
            }else{
                $array ['error'] = 'acesso negado';
            }
            return $this->returnJson($array);
        }
        //controller Alunos


    }