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
                    $this->menu = self::_getHTMLMenu($administrator->getMenuData(Yii::app()->params['site_domain']));
            }
        }

        $this->currentModule = $this->getModule($this->route);

        $this->breadcrumbs = array(
            array('title' => 'Home', 'link' => Yii::app()->homeUrl),
        );

        $this->nav = self::_getNav();
    }

    private function _getHTMLMenu($data)
    {
        return $this->renderFile(Yii::app()->getTheme()->getBasePath() . DIRECTORY_SEPARATOR . 'views/components/menu.html', compact('data'), true);
    }

    private function _getNav()
    {
        return $this->renderFile(Yii::app()->getTheme()->getBasePath() . DIRECTORY_SEPARATOR . 'views/components/nav.html', compact('data'), true);
    }

    public function setTitle($subTitle)
    {
        $this->title .= " | $subTitle";
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

    private function _getBreadcrumbs($breadcrumbs)
    {
        return $this->renderFile(Yii::app()->getTheme()->getBasePath() . DIRECTORY_SEPARATOR . 'views/components/breadcrumbs.html', compact('breadcrumbs'), true);
    }
}