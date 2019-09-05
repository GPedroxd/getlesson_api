<?php
    namespace Controller;

    use Core\Controller;
    use DAO\CursoDAO;
    use DAO\UserDAO;

    class CursoController extends Controller{
        private $dao;
        private $daoU;
        public function __construct(){
            $this->dao = new CursoDAO();
            $this->daoU = new UserDAO();
        }
        public function register(){
            $array = array('error'=>'');
            $method = $this->getMethod();
            $data = $this->getRequestData();
            if($method =='POST'){
                if(!empty($data['jwt']) && $this->daoU->validate_jwt($data['jwt'])){
                    if(!empty($data['nomeCurso'])){
                        $curso = $this->dao->register($data['nomeCurso']);
                        if($curso){
                            
                        }else{
                            $array['error'] = 'Curso já cadastrado';
                        }
                    }
                }else{
                    $array['error'] = 'acesso negado';
                }
            }else{
                $array['error'] = 'Método de requisição incompativel';
            }
            $this->returnJson($array);
        }
        public function editCurso($id){
            $array = array('error' => '');
            $method = $this->getMethod();
            $data = $this->getRequestData();
            if(!empty($data['jwt']) && $this->daoU->validate_jwt($data['jwt'])){
                switch ($method){
                    case 'DELETE':
                        $array['error'] = $this->dao->delete($id);
                        break;
                    case 'PUT':
                        $array['error'] =$this->dao->editCurso($id, $data);
                        break;
                }
            }else{
                $array['error'] = 'Acesso Nagado';
            }
            $this->returnJson($array);
        }
        public function getAll(){
            $array = array('error' => '');
            $method = $this->getMethod();
            $data = $this->getRequestData();
            if($method == 'GET'){
                if(!empty($data['jwt']) && $this->daoU->validate_jwt($data['jwt'])){
                        $array['data'] = $this->dao->getAll();
                }else{
                    $array['error'] = 'Acesso Inválido';
                }
            }else{
                $array['error'] = 'Método de requisição Inválido';
            }
            $this->returnJson($array);
        }
    }