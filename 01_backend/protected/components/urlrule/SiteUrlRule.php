<?php

class SiteUrlRule extends CBaseUrlRule {

    public $connectionID = 'db';

    public function createUrl($manager, $route, $params, $ampersand) {
        $paths = explode('/', rtrim($route, '/'));

        if(!isset($paths[0]) || $paths['0'] != "archivesite") return false;

        if(isset($paths[1]) && $paths[1] == "default"){
            if(!isset($paths[2])) return false;
            switch($paths['2']){
                case "index": return "archivesite/";
                default: return "archivesite/";
            }
        }

        return false;
    }

    public function parseUrl($manager, $request, $pathInfo, $rawPathInfo) {
        $paths = explode('/', rtrim($pathInfo, '/'));

        if(!isset($paths[0])) return "/site/index";

        switch($paths[0]){
            case 'admin':
                if(isset($paths[1]) && $paths[1] == 'login.html') return "site/AdminLogin";
            break;

            case 'logout.html':
                return "site/logout";
        }

        return FALSE;
    }

}
