<?php
    namespace Controller;

    use Core\Controller;
    use DAO\TurmaDAO;
    use DAO\UserDAO;
    class TurmaController extends Controller{
        public function register(){
            $array = array('error'=>'');
            $method = $this->getMethod();
            $data = $this->getRequestData();
            $daoU = new UserDAO();
            if($method =='POST'){
                if(!empty($data['jwt']) && $daoU->validate_jwt($data['jwt'])){
                    if(!empty($data['nomeTurma']) && !empty($data['semestreTurma'])
                        && !empty($data['anoTurma']) && !empty($data['fimTurma'])
                        && !empty($data['cursoTurma']) && !empty($data['periodoTurma'])
                        ){
                        $daoT = new TurmaDAO();
                        $turma = $daoT->register(
                            $data['nomeTurma'],
                            $data['semestreTurma'],
                            $data['anoTurma'],
                            $data['fimTurma'],
                            $data['cursoTurma'],
                            $data['periodoTurma']
                        );
                        if($turma){
                            return $turma;
                        }else{
                            $array['error'] = 'Falha ao cadastrar';
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