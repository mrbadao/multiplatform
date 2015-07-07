<?php

class ModuleManageUrlRule extends CBaseUrlRule {

    public function createUrl($manager, $route, $params, $ampersand) {
        $paths = explode('/', rtrim($route, '/'));

        if(!isset($paths[0]) || $paths['0'] != "modulemanage") return false;

            if(isset($paths[1]) && $paths[1] == "default"){
            if(!isset($paths[2])) return "modulemanage/";

            switch($paths['2']){
                case "index":
                    $url = "modulemanage/";
                    if(isset($params)){
                        $url .= "index.php?";
                        foreach($params as $k => $v){
                            if(is_array($v)){
                                foreach($v as $key => $val){
                                    $url.= sprintf("%s[%s]=%s%s", $k, $key, $val, $ampersand);
                                }
                            }else
                                $url .= sprintf("%s=%s%s", $k, $v, $ampersand);
                        }
                        $url = substr($url, 0, strlen($url) - 1);
                    }
                    return $url;

                case "view":
                    if(isset($params)){
                        $url = "modulemanage/view.php?";
                        foreach($params as $k => $v){
                            $url .= sprintf("%s=%s%s", $k, $v, $ampersand);
                        }
                        $url = substr($url, 0, strlen($url) - 1);
                        return $url;
                    }
                    break;

                case "delete":
                    if(isset($params)){
                        $url = "modulemanage/delete.php?";
                        foreach($params as $k => $v){
                            $url .= sprintf("%s=%s%s", $k, $v, $ampersand);
                        }
                        $url = substr($url, 0, strlen($url) - 1);
                        return $url;
                    }
                    break;

                case "edit":
                    $url = "modulemanage/edit.php";
                    if(isset($params)){
                        $url .= "?";
                        foreach($params as $k => $v){
                            $url .= sprintf("%s=%s%s", $k, $v, $ampersand);
                        }
                        $url = substr($url, 0, strlen($url) - 1);
                    }
                    return $url;

                default: return "modulemanage/";
            }

        }

        return false;
    }

    public function parseUrl($manager, $request, $pathInfo, $rawPathInfo) {
        $paths = explode('/', rtrim($pathInfo, '/'));

        if(!isset($paths[0]) || strtolower($paths[0]) != 'modulemanage'){
            return FALSE;
        }

        if(!isset($paths[1]) || $paths[1]=='index.php') return '/modulemanage/default/index';

        if($paths[1]=='view.php' && isset($_GET['id']) && is_numeric($_GET['id'])) {
            return '/modulemanage/default/view';
        }

        if($paths[1]=='delete.php' && isset($_GET['id']) && is_numeric($_GET['id'])) {
            return '/modulemanage/default/delete';
        }

        if($paths[1]=='edit.php') {
            return '/modulemanage/default/edit';
        }

        return FALSE;
    }

}
