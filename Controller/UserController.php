<?php
    namespace Controller;

    use Core\Controller;
    use DAO\UserDAO;
    use Model\Jwt;

class UserController extends Controller{
        public function login(){
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
        public function sing_in(){
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
                }
            }else{
                $array ['error'] = 'Método de envio incompativel';
            }
            $this->returnJson($array);
        }
    }