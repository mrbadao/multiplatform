<?php

class SiteUrlRule extends CBaseUrlRule
{
    public $connectionID = 'db';
    const SITEID_KEY = 'session_site_id';

    public function createUrl($manager, $route, $params, $ampersand)
    {
        switch($route){
            case 'site/index':
                return '';
                break;
            case 'site/contact';
                return 'contact.html';
                break;
            case 'site/AdminLogin';
                if ($_SERVER['SERVER_NAME'] == Yii::app()->params['CMS_DOMAIN']) return 'login.php';
                break;
        }

        return false;
    }

    public function parseUrl($manager, $request, $pathInfo, $rawPathInfo)
    {
        self::_checkDomain(Yii::app()->request->hostInfo);

        $paths = explode('/', rtrim($pathInfo, '/'));

        if (!isset($paths[0]) || $paths[0] == 'index.html') return "/site/index";

        switch ($paths[0]) {
            case 'index.php':
                if ($_SERVER['SERVER_NAME'] == Yii::app()->params['CP_DOMAIN']) return "site/MemberLogin";
                if ($_SERVER['SERVER_NAME'] == Yii::app()->params['CMS_DOMAIN']) return "site/AdminLogin";
                break;

            case 'logout.php':
                return "site/logout";
                break;
        }

        return FALSE;
    }

    private function _checkDomain($url){
        preg_match('/^(https?:\/\/)([a-zA-Z0-9]*)\.'.Yii::app()->params['FRONT_DOMAIN'].'/', $url, $domain);

        $criteria = new CDbCriteria();
        $criteria->select='*';
        $criteria->limit = 1;

        if($domain && isset($domain[2])) {
            $criteria->condition = "site_abbr_cd =:site_abbr_cd";
            $criteria->params = array(':site_abbr_cd' => $domain[2]);
        }else{
            $criteria->condition = "use_single_domain = 1 AND site_domain =:site_domain";
            $criteria->params = array(':site_domain' => $url);
        }

        $archiveSite = ArchiveSite::model()->find($criteria);
        if($archiveSite){
            $session = Yii::app()->session;
            if($session->contains(self::SITEID_KEY))
                $session->remove(self::SITEID_KEY);
            $session->add(self::SITEID_KEY, $archiveSite->id);

            return true;
        }

        return false;
    }
}
