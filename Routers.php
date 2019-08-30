<?php   
    global $routers;
    $routers = array();
    $routers['/sing-in'] = '/user/sing_in';
    $routers['/sing-up'] = '/user/sing_up';
    $routers['/user/{id}'] ='/user/view/:id';
    $routers['/curso/register'] = '/Curso/register';
    $routers['/turma/register'] = '/Turma/register';
    $routers['/componente/register'] = '/componente/register';
    $routers['/componente/all'] = '/componente/getAll';