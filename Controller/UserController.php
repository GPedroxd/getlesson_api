<?php
    namespace Controller;

    use Core\Controller;
    use DAO\UserDAO;
    use Model\Jwt;

class UserController extends Controller{
        public function sing_in(){
            $array = array('error'=>'');
            $method = $this->getMethod();
            $data = $this->getRequestData();
            if($method == 'POST'){
                if(!empty($_POST['email']) && !empty($_POST['pass'])){
                    $dao = new UserDAO();
                    $user = $dao->login($data['email'], $data['pass']);
                    if($user){
                        $array ['jwt'] = $dao->createJwt($user);
                    }else{
                        $array['error']= 'accesso negado';
                    }
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
                if(!empty($data['name']) && !empty($data['email']) &&
                    !empty($data['pass']) && !empty($data['rm'])
                    && !empty($data['nivel'])){
                    if(filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
                        $dao = new UserDAO();
                        $user =$dao->sing_in(
                            $data['name'],
                            $data['rm'],
                            $data['email'],
                            $data['pass'],
                            $data['nivel']
                        );
                        if($user){
                            $array['jwt'] = $dao->createJwt($user);
                        }else{
                            $array ['error'] = 'E-mail já existente';
                        }
                    }else{
                        $array ['error'] = 'E-mail Invalido';
                    }
                }else{
                    $array['error'] = 'tudo vazio';
                }
            }else{
                $array ['error'] = 'Método de envio incompativel';
            }
            $this->returnJson($array);
        }
        public function view($id){
            $array = array('error'=>'', 'logged'=>false);
            $method = $this->getMethod();
            $data = $this->getRequestData();
            $dao = new UserDAO();
            if(!empty($data['jwt']) && $dao->validate_jwt($data['jwt'])){
                $array['logged'] = true;
                $array['is_me'] = false;
                if($id == $dao->getId()){
                    $array['is_me'] = true;
                }
                switch($method){
                    case 'GET':
                        
                        break;
                    case 'PUT':
                    
                        break;
                    case 'DELETE':

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
    }