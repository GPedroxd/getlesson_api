<?php   
    global $routers;
    $routers = array();
    $routers['/sing-in'] = '/user/sing_in';
    $routers['/sing-up'] = '/user/sing_up';
    $routers['/user/{id}'] ='/user/view/:id';
    $routers['/user'] = '/user/getAll';
    $routers['/curso/register'] = '/Curso/register';
    $routers['/curso/{id}'] = '/curso/editCurso/:id';
    $routers['/curso'] = '/curso/getAll';
    $routers['/turma/register'] = '/Turma/register';
    $routers['/turma/{id}'] = '/Turma/editTurma/:id';
    $routers['/turma'] = '/Turma/getAll';
    $routers['/componente/register'] = '/componente/register';
    $routers['/componente/{id}'] = '/componente/editComponente/:id';
    $routers['/componente'] = '/componente/getAll';