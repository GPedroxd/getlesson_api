<?php
    namespace Controller;

    use Core\Controller;
    use DAO\ComponenteDAO;
    use DAO\UserDAO;

    class ComponenteController extends Controller{
        public function register(){
            $array = array('error'=> '');
            $method = $this->getMethod();
            $data = $this->getRequestData();
            $user = new UserDAO();
            if($method == 'POST'){
                if(!empty($data['jwt']) && $user->validate_jwt($data['jwt'])){
                    if(!empty($data['nomeComponente']) && !empty($data['sigla'])){
                        $daoC = new ComponenteDAO();
                        if($daoC->register($data['nomeComponente'], $data['sigla'])){
                            $array['success'] = true;
                        }else{
                            $array['success'] = false;
                        }
                    }
                }else{
                    $array['error'] = 'acesso negado';
                }
            }else{
                $array['error'] = 'Método de requisição invalido';
            }
            $this->returnJson($array);
        }
        public function getAll(){
            $array = array('error'=> '');
            $method = $this->getMethod();
            $data = $this->getRequestData();
            $user = new UserDAO();
            if($method == 'POST'){
                if(!empty($data['jwt']) && $user->validate_jwt($data['jwt'])){
                        $daoC = new ComponenteDAO();
                        $dados = $daoC->getAll();
                        if($dados){
                            $array['data'] = $dados;
                        }else{
                            $array['data'] = 'Nenhum Componente Existente' ;
                        }
                }else{
                    $array['error'] = 'acesso negado';
                }
            }else{
                $array['error'] = 'Método de requisição invalido';
            }
            $this->returnJson($array);
        }
    }