<?php
    namespace Controller;

    use Core\Controller;
    use DAO\TurmaDAO;
    use DAO\UserDAO;
    class TurmaController extends Controller{
        private $daoU;
        private $daoT;
        public function __construct(){
            $this->daoT = new TurmaDAO();
            $this->daoU = new UserDAO();
        }
        public function register(){
            $array = array('error'=>'');
            $method = $this->getMethod();
            $data = $this->getRequestData();
            if($method =='POST'){
                if(!empty($data['jwt']) && $this->daoU->validate_jwt($data['jwt'])){
                    if(!empty($data['nomeTurma']) && !empty($data['semestreTurma'])
                        && !empty($data['anoTurma']) && !empty($data['ultimoDiaTurma'])
                        && !empty($data['idCurso']) && !empty($data['idPeriodo'])
                        ){
                        $turma = $this->daoT->register(
                            $data['nomeTurma'],
                            $data['semestreTurma'],
                            $data['anoTurma'],
                            $data['ultimoDiaTurma'],
                            $data['idCurso'],
                            $data['idPeriodo']
                        );
                        if($turma){
                            
                        }else{
                            $array['error'] = 'Falha ao cadastrar';
                        }
                    }else{
                        $array['error'] = 'preencha todos os campos';
                    }
                }else{
                    $array['error'] = 'acesso neagado';
                }
            }else{
                $array['error'] = 'Método de requisição inconpativel';
            }
            $this->returnJson($array);
        }
        public function editTurma($id){
            $array = array();
            $method = $this->getMethod();
            $data = $this->getRequestData();
            if(!empty($data['jwt']) && $this->daoU->validate_jwt($data['jwt'])){
                switch ($method){
                    case 'DELETE':
                        $array['error'] = $this->daoT->delete($id);
                        break;
                    case 'PUT':
                        $array['error'] = $this->daoT->editTurma($id, $data);
                        break;
                }
            }else{
                $array['error'] =  'Acesso nagado'; 
            }
            $this->returnJson($array);
        }
        public function getAll(){
            $array = array('error' => '');
            $method = $this->getMethod();
            $data = $this->getRequestData();
            if($method == 'GET'){
                if(!empty($data['jwt']) && $this->daoU->validate_jwt($data['jwt'])){
                        $array['data'] = $this->daoT->getAll();
                }else{
                    $array['error'] = 'Acesso Inválido';
                }
            }else{
                $array['error'] = 'Método de requisição Inválido';
            }
            $this->returnJson($array);
        }
    }