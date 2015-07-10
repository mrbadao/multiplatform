<?php

class SystemUsersUrlRule extends CBaseUrlRule
{
    public function createUrl($manager, $route, $params, $ampersand) {
        $paths = explode('/', rtrim($route, '/'));

        if(!isset($paths[0]) || $paths['0'] != "systemusers") return false;

            if(isset($paths[1]) && $paths[1] == "default"){
            if(!isset($paths[2])) return "systemusers/";

            switch($paths['2']){
                case "index":
                    $url = "systemusers/inex.php";
                    if(isset($params)){
                        $url .= "?";
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

                case "edit":
                    $url = "systemusers/edit.php";
                    if(isset($params)){
                        $url .= "?";
                        foreach($params as $k => $v){
                            $url .= sprintf("%s=%s%s", $k, $v, $ampersand);
                        }
                        $url = substr($url, 0, strlen($url) - 1);
                    }
                    return $url;
                    break;

                case "view":
                    $url = "systemusers/view.php";

                    if(isset($params)){
                        $url .= "?";
                        foreach($params as $k => $v){
                            $url .= sprintf("%s=%s%s", $k, $v, $ampersand);
                        }
                        $url = substr($url, 0, strlen($url) - 1);
                    }
                    return $url;
                    break;

                case "setpermissions":
                    $url = "systemusers/setpermissions.php";

                    if(isset($params)){
                        $url .= "?";
                        foreach($params as $k => $v){
                            $url .= sprintf("%s=%s%s", $k, $v, $ampersand);
                        }
                        $url = substr($url, 0, strlen($url) - 1);
                    }
                    return $url;
                    break;

                case "delete":
                    $url = "systemusers/delete.php";
                    if(isset($params)){
                        $url .= "?";
                        foreach($params as $k => $v){
                            $url .= sprintf("%s=%s%s", $k, $v, $ampersand);
                        }
                        $url = substr($url, 0, strlen($url) - 1);
                    }
                    return $url;
            }

        }

        return false;
    }

    public function parseUrl($manager, $request, $pathInfo, $rawPathInfo) {
        $paths = explode('/', rtrim($pathInfo, '/'));

        if(!isset($paths[0]) || strtolower($paths[0]) != 'systemusers'){
            return FALSE;
        }

        if(!isset($paths[1]) || $paths[1] == 'inex.php')  return '/systemusers/default/index';

        switch($paths[1]){
            case 'edit.php':
                return '/systemusers/default/edit';
            case 'setpermissions.php':
                return '/systemusers/default/setpermissions';
            case 'view.php':
                if(!isset($_GET['id']) || !is_numeric($_GET['id'])) return false;
                return '/systemusers/default/view';
            case 'edit.php':
                return '/systemusers/default/restoredb';
            case 'delete.php':
                if(!isset($_GET['id']) || !is_numeric($_GET['id'])) return false;
                return '/systemusers/default/delete';
            default: return false;
        }

    }

}
