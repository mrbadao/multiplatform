<?php

class GlobalNavigationMenu extends CLinkPager {
    public $menu_abbr_cd;
    public $view;
    private $_site_id;
    private $_global_menu;
    const SITEID_KEY = 'session_site_id';

    public function init() {
        $session = Yii::app()->session;
        $this->_site_id = $session->contains(self::SITEID_KEY) ? $session[self::SITEID_KEY] : '';

        $criteria = new CDbCriteria();
        $criteria->condition = "t.site_id =:site_id AND t.menu_abbr_cd=:menu_abbr_cd";
        $criteria->params = array(':site_id' => $this->_site_id, ':menu_abbr_cd' => $this->menu_abbr_cd);
        $criteria->limit = 1;
        $this->_global_menu = ArchiveMenu::model()->find($criteria);
    }

    /**
     * Executes the widget.
     * This overrides the parent implementation by displaying the generated page buttons.
     */
    public function run()
    {
        $title = $this->_global_menu ? $this->_global_menu->menu_name : '';
        $menuItems = $this->_global_menu ? $this->_global_menu->archiveMenuItem : '';
        $route = Yii::app()->controller->getRoute();
       $this->render($this->view, compact('menuItems', 'route', 'title'));
    }
}
