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
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

    public $title='CMS';

    public function init()
    {
        $administrator = Administrator::model()->findByPk(1);
        $this->menu = self::_getHTMLMenu($administrator->getMenuData(Yii::app()->params['site_domain'])) ;
    }

    private function _getHTMLMenu($data){
        return $this->renderPartial('../components/menu', compact('data'), true);
    }
}