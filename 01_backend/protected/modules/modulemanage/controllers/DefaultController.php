<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{
        $this->setTitle('Manage Modules');
        $page = isset($_GET['page']) ? $_GET['page'] : '1';
        $search = isset($_GET['search']) ? $_GET['search'] : array('use_single_domain' => '');

        $criteria = new CDbCriteria();
        $criteria->together = true;
        $criteria->order = 't.idx ASC';

        foreach($search as $k => $v)
        {
            if(!isset($v) || $v === '')
            {
                continue;
            }
            switch($k)
            {
                case 'site_name':
                    $criteria->compare($k, $v, true,'AND');
                    break;
                case 'use_single_domain':
                    $criteria->compare('use_single_domain', $v, false,'AND');
                    break;
                case 'site_domain':
                    if(isset($search['use_single_domain']) && $search['use_single_domain'] == '1')
                        $criteria->compare($k, $v, true,'AND');
                    else  $criteria->compare('site_abbr_cd', $v, true,'AND');
                    break;
            }
        }

        $itemCount =  AdministratorModules::model()->count($criteria);

        $criteria->limit = Yii::app()->params['pageCountItems'];
        $criteria->offset = $criteria->limit * ($page - 1);

        $moduleList = AdministratorModules::model()->findAll($criteria);

        $pages = new CPagination($itemCount);
        $pages->pageSize = $criteria->limit;
        $pages->applyLimit($criteria);

        $name = isset($_GET['name']) ? $_GET['name'] : '';
        $message = isset($_GET['message']) ? $_GET['message'] : '';
        $action = isset($_GET['action']) ? $_GET['action'] : '';

        $this->render('index', compact('moduleList', 'itemCount', 'name', 'message', 'action', 'search', 'pages'));
	}

    public function actionEdit(){
        $module = null;

        if(isset($_GET['id'])) {
            $module = AdministratorModules::model()->findByAttributes(array('id' => $_GET['id']));
            if(!$module) throw new CHttpException("404", "Page not found.");
        }

        if($module == null) $module = new AdministratorModules();

        if(isset($_POST['Module'])){
            $module->object = isset($_FILES['Module']) ? $_FILES['Module'] : '';
            $module->attributes = $_POST['Module'];
            if($module->validate()){
                if(!isset($_FILES['Module'])) $module->save(false);
                $this->redirect($this->createUrl('/modulemanage/default/index'
//                    , array(
//                    'id' => $module->id,
//                    'message' => 'success',
//                    'action' => $archiveSite->isNewRecord ? 'add' : 'edit',)
                ));
            }
        }
        $this->render('edit', compact('module'));
    }
}