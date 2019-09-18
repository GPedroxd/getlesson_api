<?php
    namespace Controller;

    use Core\Controller;
    use DAO\AtividadeDAO;
    use DAO\UserDAO;
    class AtividadeController extends Controller{
        private $daoA;
        private $daoU;
        public function __construct(){
            $this->daoU = new UserDAO();
            $this->daoA = new AtividadeDAO();
        }
        public function insertAtividade(){
            $array = array('error' => '');
            $method = $this->getMethod();
            $data = $this->getRequestData();
            if(!empty($data['jwt']) && $this->daoU->validate_jwt($data['jwt'])){
                if($method == 'POST'){
                    if(!empty($data['data']) && !empty($data['info'])){
                        $array['error'] = $this->daoA->insertAtividade($data['info'], $data['data']);
                    }else{
                        $array['error'] = 'campos vazios e/ou invalidos';
                    }
                }else{
                    $array['error'] = 'metodo de requisicao invalido';
                }
            }else{
                $array['error'] = 'acesso negado';
            }
            return $this->returnJson($array);
        }
        public function getAll($idTurma){

        }
        public function getAtividade($idAtividade){
            $array = array('error' => '');
            $method = $this->getMethod();
            $data = $this->getRequestData();
            if($method == 'GET'){
                if(!empty($data['jwt']) && $this->daoU->validate_jwt($data['jwt'])){
                    $array['data'] = $this->daoA->getAtividade($idAtividade);
                }else{
                    $array['error'] = 'acesso negado';
                }
            }else{
                $array['error'] = 'Metodo de requisição indisponivel';
            }
            return $this->returnJson($array);
        }

        public function fazerAtividade(){
            $array = array('error' => '', 'info'=>'');
            $method = $this->getMethod();
            $data = $this->getRequestData();
            if(!empty($data['jwt']) && $this->daoU->validate_jwt($data['jwt'])){
                if(!empty($data['data'])){
                    $array['data'] = $this->daoA->fazerAtividade($data['data']);
                }else{
                    $array['error'] = 'nenhuma informação enviada';
                }
            }else{
                $array['error'] = 'acesso negado';
            }
            return $this->returnJson($array);
        }
    }