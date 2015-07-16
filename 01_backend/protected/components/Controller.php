<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();
    public $nav = array();
    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();
    public $title = 'CMS';
    private $currentModule = '';

    public function init()
    {
        if (!Yii::app()->user->isGuest) {
            $userId = Yii::app()->user->getId();
            $role = Yii::app()->user->role;

            if (!$userId) Yii::app()->end();

            switch ($role) {
                case '1':
                    $administrator = Administrator::model()->findByPk($userId);
                    $this->menu = self::_getHTMLMenu($administrator->getMenuData(Yii::app()->params['CMS_DOMAIN']));
            }
        }

        $this->currentModule = $this->getModule($this->route);

        $this->breadcrumbs = array(
            array('title' => 'Home', 'link' => Yii::app()->homeUrl),
        );

        $this->nav = self::_getNav();
    }

    public function filters()
    {
        return array('accessControl');
    }

    public function accessRules()
    {
        return self::_getModuleAccessRules();
    }

    public function beforeAction()
    {
        $controller = $this->getId();
        $action = $this->getAction()->getId();

        if ($this->currentModule) {

            $this->currentModule = AdministratorModules::model()->findByAttributes(array('module_abbr_cd' => $this->currentModule->getId()));
            if ($this->currentModule) array_push($this->breadcrumbs, array('title' => $this->currentModule->module_name, 'link' => $action == 'index' ? '' : $this->createUrl("/" . $this->route)));
            else throw new CHttpException("404", "Page not found.");
        }

        if ($action != 'index') {
            $criteria = new CDbCriteria();
            $criteria->addCondition("controller = '$controller'", "AND");
            $criteria->addCondition("action_abbr_cd = '$action'", "AND");

            if ($this->currentModule) {
                $id = $this->currentModule->id;
                $criteria->addCondition("module_id = '$id'", "AND");

                $currentAction = AdministratorModuleActions::model()->find($criteria);
                if ($currentAction)
                    array_push($this->breadcrumbs, array('title' => $action == 'edit' && isset($_GET['id']) ? 'Edit' : $currentAction->action_name, 'link' => ''));
                else throw new CHttpException("404", "Page not found.");
            }
        }
        $this->breadcrumbs = self::_getBreadcrumbs($this->breadcrumbs);

        return true;
    }

    private function _getHTMLMenu($data)
    {
        return $this->renderFile(Yii::app()->getTheme()->getBasePath() . DIRECTORY_SEPARATOR . 'views/components/menu.html', compact('data'), true);
    }

    private function _getNav()
    {
        return $this->renderFile(Yii::app()->getTheme()->getBasePath() . DIRECTORY_SEPARATOR . 'views/components/nav.html', compact('data'), true);
    }

    public function _getModuleAccessRules()
    {
        $module_abbr_cd = $this->getModule($this->route) ? $this->getModule($this->route)->getId() : '';

        if (!$module_abbr_cd) return array(
            array(
                'allow',
                'users' => array('@'),
                'message'=>'Access Denied.',
            ),
        );

        $rule = array();
        $trace = array();

        $moduleActions = AdministratorModuleActions::model()->with("module")->findAll(
            "module.module_abbr_cd = :module_abbr_cd ",
            array(':module_abbr_cd' => $module_abbr_cd)
        );

        for ($i = 0; $i < count($moduleActions); $i++) {
            array_push($rule, array(
                'allow',
                'actions' => array($moduleActions[$i]->action_abbr_cd),
                'users' => array(),
//                'deniedCallback' => $this->redirect('/'),
                'message'=>'Access Denied.',
            ));
            $trace[] = array('idx' => $i, 'id' => $moduleActions[$i]->id);
        }

        $DataAccessRule = AdministratorModuleAccess::model()->with("module")->findAll(
            "module.module_abbr_cd = :module_abbr_cd",
            array(':module_abbr_cd' => $module_abbr_cd)
        );

        foreach ($DataAccessRule as $accessRule) {
            $idx = self::_accessRuleTraceArraySearch($trace, 'id', $accessRule->muodule_action_id);
            if ($idx > -1)
                $rule[$idx]['users'][] = $accessRule->account->login_id;
        }

        $rule[] = array('deny');
        return $rule;
    }

    private function _accessRuleTraceArraySearch($trace, $key, $need)
    {
        foreach ($trace as $val) {
            if ($val[$key] == $need) return $val['idx'];
        }
        return -1;
    }

    public function setTitle($subTitle)
    {
        $this->title .= " | $subTitle";
    }

    private function _getBreadcrumbs($breadcrumbs)
    {
        return $this->renderFile(Yii::app()->getTheme()->getBasePath() . DIRECTORY_SEPARATOR . 'views/components/breadcrumbs.html', compact('breadcrumbs'), true);
    }
}