<?php

class SystemSettingUrlRule extends CBaseUrlRule {

    public $connectionID = 'db';

    public function createUrl($manager, $route, $params, $ampersand) {
        $paths = explode('/', rtrim($route, '/'));

        if(!isset($paths[0]) || $paths['0'] != "systemsetting") return false;

            if(isset($paths[1]) && $paths[1] == "default"){
            if(!isset($paths[2])) return "systemsetting/";

            switch($paths['2']){
                case "cmsmainconfig":
                    $url = "systemsetting/app-config.php";
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

                case "backupdb":
                    $url = "systemsetting/database-backup.php";
                    if(isset($params)){
                        $url .= "?";
                        foreach($params as $k => $v){
                            $url .= sprintf("%s=%s%s", $k, $v, $ampersand);
                        }
                        $url = substr($url, 0, strlen($url) - 1);
                    }
                    return $url;
                    break;

                case "restoredb":
                    $url = "systemsetting/database-restore.php";

                    if(isset($params)){
                        $url .= "?";
                        foreach($params as $k => $v){
                            $url .= sprintf("%s=%s%s", $k, $v, $ampersand);
                        }
                        $url = substr($url, 0, strlen($url) - 1);
                    }
                    return $url;
                    break;

                case "downloaddatabase":
                    $url = "systemsetting/download.php";
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

        if(!isset($paths[0]) || strtolower($paths[0]) != 'systemsetting'){
            return FALSE;
        }

        if(!isset($paths[1])) return false;

        switch($paths[1]){
            case 'app-config.php':
                return '/systemsetting/default/cmsmainconfig';
            case 'database-backup.php':
                return '/systemsetting/default/backupdb';
            case 'database-restore.php':
                return '/systemsetting/default/restoredb';
            case 'download.php':
                return '/systemsetting/default/downloaddatabase';
            default: return false;
        }

    }

}
