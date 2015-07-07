<?php

class ArchiveSiteUrlRule extends CBaseUrlRule {

    public $connectionID = 'db';

    public function createUrl($manager, $route, $params, $ampersand) {
        $paths = explode('/', rtrim($route, '/'));

        if(!isset($paths[0]) || $paths['0'] != "archivesite") return false;

            if(isset($paths[1]) && $paths[1] == "default"){
            if(!isset($paths[2])) return "archivesite/";

            switch($paths['2']){
                case "index":
                    $url = "archivesite/";
                    if(isset($params)){
                        $url .= "index.php?";
                        foreach($params as $k => $v){
                            $url .= sprintf("%s=%s%s", $k, $v, $ampersand);
                        }
                        $url = substr($url, 0, strlen($url) - 1);
                    }
                    return $url;

                case "view":
                    if(isset($params)){
                        $url = "archivesite/view.php?";
                        foreach($params as $k => $v){
                            $url .= sprintf("%s=%s%s", $k, $v, $ampersand);
                        }
                        $url = substr($url, 0, strlen($url) - 1);
                        return $url;
                    }
                    break;

                case "delete":
                    if(isset($params)){
                        $url = "archivesite/delete.php?";
                        foreach($params as $k => $v){
                            $url .= sprintf("%s=%s%s", $k, $v, $ampersand);
                        }
                        $url = substr($url, 0, strlen($url) - 1);
                        return $url;
                    }
                    break;

                case "edit":
                    $url = "archivesite/edit.php";
                    if(isset($params)){
                        $url .= "?";
                        foreach($params as $k => $v){
                            $url .= sprintf("%s=%s%s", $k, $v, $ampersand);
                        }
                        $url = substr($url, 0, strlen($url) - 1);
                    }
                    return $url;

                default: return "archivesite/";
            }

        }

        return false;
    }

    public function parseUrl($manager, $request, $pathInfo, $rawPathInfo) {
        $paths = explode('/', rtrim($pathInfo, '/'));

        if(!strtolower($paths[0]) == 'archivesite'){
            return FALSE;
        }

        if(!isset($paths[1]) || $paths[1]=='index.php') return '/archivesite/default/index';

        if($paths[1]=='view.php' && isset($_GET['id']) && is_numeric($_GET['id'])) {
            return '/archivesite/default/view';
        }

        if($paths[1]=='delete.php' && isset($_GET['id']) && is_numeric($_GET['id'])) {
            return '/archivesite/default/delete';
        }

        if($paths[1]=='edit.php') {
            return '/archivesite/default/edit';
        }

        return FALSE;
    }

}
