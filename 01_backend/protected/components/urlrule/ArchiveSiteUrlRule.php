<?php

class ArchiveSiteUrlRule extends CBaseUrlRule {

    public $connectionID = 'db';

    public function createUrl($manager, $route, $params, $ampersand) {
        $paths = explode('/', rtrim($route, '/'));

        if(!isset($paths[0]) || $paths['0'] != "archivesite") return false;

        if(isset($paths[1]) && $paths[1] == "default"){
            if(!isset($paths[2])) return false;

            switch($paths['2']){
                case "index": return "archivesite/";
                case "view":
                    if(isset($params['id'])) return "archivesite/view.php?id=".$params['id'];
                    break;
                case "edit":
                    if(isset($params['id'])) return "archivesite/edit.php?id=".$params['id'];
                    else return "archivesite/edit.php";
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

        if(!isset($paths[1])) return '/archivesite/default/index';

        if($paths[1]=='view.php' && isset($_GET['id']) && is_numeric($_GET['id'])) {
            return '/archivesite/default/view';
        }

        if($paths[1]=='edit.php') {
            return '/archivesite/default/edit';
        }

        return FALSE;
    }

}
