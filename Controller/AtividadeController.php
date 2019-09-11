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
                    if(!empty($data['data'])){
                        $perguntas = $data['data'];
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

        }
    }