<?php
    namespace Core;

    class Core{
        public function run(){
            $params = array();
            $url='/';
            if(isset($_GET['url'] )){
                $url.=$_GET['url'];
            }
            $url = $this->checkRouter($url);
            if(!empty($url) && $url!='/'){
                $url = explode('/',$url);
                array_shift($url);
                $currentController = $url[0].'Controller';
                array_shift($url);
                if(isset($url[0]) && !empty($url[0])){
                    $currentAction = $url[0];
                    array_shift($url);
                } else{
                    $currentAction = 'index';
                }
                if(count($url) > 0){
                    $params = $url;
                }
            }else{
                $currentController = 'HomeController';
                $currentAction = 'index';
            }
            $prefix = '\Controller\\';
            $currentController = ucfirst($currentController);
            if(!file_exists('Controller/'.$currentController.'.php')
                ||  !method_exists($prefix.$currentController,$currentAction)){
                    $currentController = 'NotfoundController';
                    $currentAction = 'index';
            }
            
            $newController = $prefix.$currentController;
            $controller = new $newController();
            call_user_func_array(array($controller, $currentAction), $params);
        }
        public function checkRouter($url){
            global $routers;
            foreach ($routers as $ul => $newUrl){
                $pattern = preg_replace('(\{[a-z0-9]{1,}\})','([a-z0-9-]{1,})',
                                        $ul);  
                if(preg_match('#^('.$pattern.')*$#i', $url, $matchs) === 1){
                    array_shift($matchs);
                    array_shift($matchs);
                    $itens = array();
                    if(preg_match_all('(\{[a-z0-9]{1,}\})', $ul, $m)){
                        $itens = preg_replace('(\{|\})', '', $m[0]);
                    }
                    $arg = array();
                    foreach($matchs as $key =>$match){
                        $arg[$itens[$key]] = $match;
                    }
                    foreach($arg as $argkey => $argvalue){
                        $newUrl = str_replace(':'.$argkey, $argvalue, $newUrl);
                    }
                    $url = $newUrl;
                    break;
                }
            }
            return $url;
        }
    }