<?php
    namespace Controller;

    use Core\Controller;
    use DAO\ComponenteDAO;
    use DAO\UserDAO;

    class ComponenteController extends Controller{
        private $daoU;
        private $daoC;
        public function __construct(){
            $this->daoU = new UserDAO();
            $this->daoC = new ComponenteDAO();
        }
        public function register(){
            $array = array('error'=> '');
            $method = $this->getMethod();
            $data = $this->getRequestData();
            if($method == 'POST'){
                if(!empty($data['jwt']) && $this->daoU->validate_jwt($data['jwt'])){
                    if(!empty($data['nomeComponente']) && !empty($data['siglaComponente']) && !empty($data['idUsuario']) && !empty($data['idTurma'])){
                        if($this->daoC->register($data['nomeComponente'], $data['siglaComponente'], $data['idUsuario'], $data['idTurma'])){

                        }else{
                            $array['error'] = 'falha ao cadastrar';
                        }
                    }else{
                        $array['error'] = 'campos vazios e/ou invalidos';
                    }
                }else{
                    $array['error'] = 'acesso negado';
                }
            }else{
                $array['error'] = 'Método de requisição invalido';
            }
            $this->returnJson($array);
        }
        public function editComponente($id){
            $array = array('error' => '');
            $method = $this->getMethod();
            $data = $this->getRequestData();
            if(!empty($data['jwt']) && $this->daoU->validate_jwt($data['jwt'])){
                switch ($method){
                    case 'DELETE':
                        $array['error'] = $this->daoC->delete($id);
                        break;
                    case 'PUT':
                        $array['error'] =$this->daoC->editComponente($id, $data);
                        break;
                }
            }else{
                $array['error'] = 'Acesso Nagado';
            }
            $this->returnJson($array);
        }
        public function getAll(){
            $array = array('error'=> '');
            $method = $this->getMethod();
            $data = $this->getRequestData();
            if($method == 'GET'){
                if(!empty($data['jwt']) && $this->daoU->validate_jwt($data['jwt'])){
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
        public function getByUsuario($id){
            $array = array('error'=>'');
            $data = $this->getRequestData();
            $method = $this->getMethod();
            if($method == 'GET'){
                if(!empty($data['jwt']) && $this->daoU->validate_jwt($data['jwt'])){
                    $array['error'] = $this->daoC->getByUsuario($id);                    
                }else{
                    $array['error'] = 'acesso negado';
                }
            }else{
                $array['error'] = 'Metodo invalido';
            }
            return $this->returnJson($array);
        }
        public function getByTurma($id){

        }
    }