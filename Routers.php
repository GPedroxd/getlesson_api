<?php   
    global $routers;
    $routers = array();
    $routers['/login'] = '/user/login';
    $routers['/sing-in'] = '/user/sing_in';
    $routers['/user/{id}'] ='/user/view/:id';
    $routers['/curso/register'] = '/Curso/register';
    $routers['/turma/register'] = '/Turma/register';