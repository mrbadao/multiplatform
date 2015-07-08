<?php

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $this->setTitle('Manage Modules');
        $page = isset($_GET['page']) ? $_GET['page'] : '1';
        $search = isset($_GET['search']) ? $_GET['search'] : array();

        $criteria = new CDbCriteria();
        $criteria->together = true;
        $criteria->order = 't.idx ASC';

        foreach ($search as $k => $v) {
            if (!isset($v) || $v === '') {
                continue;
            }
            switch ($k) {
                case 'module_name':
                    $criteria->compare($k, $v, true, 'AND');
                    break;
                case 'module_abbr_cd':
                    $criteria->compare('module_abbr_cd', $v, true, 'AND');
                    break;
                case 'version':
                    $criteria->compare('version', $v, true, 'AND');
                    break;
            }
        }

        $itemCount = AdministratorModules::model()->count($criteria);

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

    public function actionEdit()
    {
        $module = null;

        if (isset($_GET['id'])) {
            $module = AdministratorModules::model()->findByAttributes(array('id' => $_GET['id']));
            if (!$module) throw new CHttpException("404", "Page not found.");
        }

        if ($module == null) $module = new AdministratorModules();

        if (isset($_POST['Module'])) {
            $module->object = isset($_FILES['Module']) ? $_FILES['Module'] : '';
            $module->attributes = $_POST['Module'];

            if ($module->validate()) {
                if (!$_FILES['Module']['name']['object']) $module->save(false);
                $this->redirect($this->createUrl('/modulemanage/default/view', array(
                        'id' => $module->id,
                        'message' => 'success',
                        'action' => $module->isNewRecord ? 'add' : 'edit',
                    )
                ));
            }
        }
        $this->render('edit', compact('module'));
    }

    public function actionView()
    {
        $id = $_GET['id'];
        $message = isset($_GET['message']) ? $_GET['message'] : '';
        $action = isset($_GET['action']) ? $_GET['action'] : '';
        $moduleaction = isset($_GET['moduleaction']) ? $_GET['moduleaction'] : '';

        $module = AdministratorModules::model()->findByAttributes(array('id' => $id));

        if (!$module) throw new CHttpException("404", "Page not found.");
        //get Actions
        $page = isset($_GET['page']) ? $_GET['page'] : '1';

        $criteria = new CDbCriteria();
        $criteria->addCondition("module_id=$id", "AND" );
        $criteria->together = true;
        $criteria->order = 't.controller ASC';

        $actionCount = AdministratorModuleActions::model()->count($criteria);

        $criteria->limit = Yii::app()->params['pageCountItems'];
        $criteria->offset = $criteria->limit * ($page - 1);

        $moduleActions = AdministratorModuleActions::model()->findAll($criteria);

        $pages = new CPagination($actionCount);
        $pages->pageSize = $criteria->limit;
        $pages->applyLimit($criteria);

        //edit/view  Action
        $contentAction ='';

        if(isset($_GET['actionid']) && $_GET['actionid'] == 'new'){
            $contentAction = new AdministratorModuleActions();
        }
        if((isset($_GET['actionid']) && is_numeric($_GET['actionid']) && $_GET['actionid'])){
            $contentAction = AdministratorModuleActions::model()->findByPk($_GET['actionid']);
        }

        if(isset($_POST['ContentAction']))
        {
            $id = isset($_POST['ContentAction']['id']) ? $_POST['ContentAction']['id'] :'';
            $contentAction = AdministratorModuleActions::model()->findByPk($id);
            $contentAction = !$contentAction ? new AdministratorModuleActions() : $contentAction;
            $contentAction->attributes = $_POST['ContentAction'];

            if($contentAction->validate()){
                $contentAction->save(false);

                $superAdminAccess = AdministratorModuleAccess::model()->findByAttributes(array(
                    'administrator_id' => isset(Yii::app()->params['super_id']) ? Yii::app()->params['super_id'] : '1',
                    'module_id' => $module->id,
                    'muodule_action_id' => $contentAction->id,
                ));

                $superAdminAccess = !$superAdminAccess ? new AdministratorModuleAccess() : $superAdminAccess;
                $superAdminAccess->attributes = array(
                    'administrator_id' => isset(Yii::app()->params['super_id']) ? Yii::app()->params['super_id'] : '1',
                    'module_id' => $module->id,
                    'muodule_action_id' => $contentAction->id,
                );
                $superAdminAccess->save(false);

                $message = 'success';
                $this->redirect($this->createUrl('/modulemanage/default/view', array(
                        'id' => $module->id,
                        'message' => $message,
                        'moduleaction' => $module->isNewRecord ? 'add' : 'edit',
                    )
                ));

            }
        }

        $this->render("view", compact('module', 'message', 'action', 'moduleActions', 'actionCount', 'pages', 'contentAction', 'moduleaction'));
    }

}