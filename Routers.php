<?php   
    global $routers;
    $routers = array();
    $routers['/sing-in'] = '/user/sing_in';
    $routers['/sing-up'] = '/user/sing_up';
    $routers['/user/{id}'] ='/user/view/:id';
    $routers['/user'] = '/user/getAll';
    $routers['/curso/add'] = '/Curso/register';
    $routers['/curso/{id}'] = '/curso/editCurso/:id';
    $routers['/curso'] = '/curso/getAll';
    $routers['/turma/add'] = '/Turma/register';
    $routers['/turma/{id}'] = '/Turma/editTurma/:id';
    $routers['/turma'] = '/Turma/getAll';
    $routers['/componente/add'] = '/componente/register';
    $routers['/componente/{id}'] = '/componente/editComponente/:id';
    $routers['/componente'] = '/componente/getAll';
    $routers['/atividade/add'] = '/atividade/insertAtividade';
    $routers['/atividade/get/{id}'] = '/atividade/getAtividade/:id';