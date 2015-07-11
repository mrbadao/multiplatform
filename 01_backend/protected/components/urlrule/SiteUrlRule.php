<?php

class SiteUrlRule extends CBaseUrlRule
{

    public $connectionID = 'db';

    public function createUrl($manager, $route, $params, $ampersand)
    {


        return false;
    }

    public function parseUrl($manager, $request, $pathInfo, $rawPathInfo)
    {
        $paths = explode('/', rtrim($pathInfo, '/'));

        if (!isset($paths[0])) return "/site/index";

        switch ($paths[0]) {
            case 'login.php':
                if ($_SERVER['SERVER_NAME'] == Yii::app()->params['CP_DOMAIN']) return "site/MemberLogin";
                if ($_SERVER['SERVER_NAME'] == Yii::app()->params['CMS_DOMAIN']) return "site/AdminLogin";
                break;

            case 'logout.php':
                return "site/logout";
                break;
        }

        return FALSE;
    }

}
