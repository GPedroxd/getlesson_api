<?php
    namespace Controller;

    use Core\Controller;
    use DAO\CursoDAO;
    use DAO\UserDAO;

    class CursoController extends Controller{
        public function register(){
            $array = array('error'=>'');
            $method = $this->getMethod();
            $data = $this->getRequestData();
            $daoU = new UserDAO();
            if($method =='POST'){
                if(!empty($data['jwt']) && $daoU->validate_jwt($data['jwt'])){
                    if(!empty($data['curso'])){
                        $dauC = new CursoDAO();
                        $curso = $dauC->register($data['curso']);
                        if($curso){
                            $array['jwt'] = $data['jwt'];
                            $array['data'] = array('nome'=>$data['curso']);
                        }else{
                            $array['error'] = 'Curso já cadastrado';
                        }
                    }
                }else{
                    $array['error'] = 'acesso neagado';
                }
            }else{
                $array['error'] = 'Método de requisição inconpativel';
            }
            $this->returnJson($array);
        }
    }