<?php

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $this->setTitle('Manage User');
        $page = isset($_GET['page']) ? $_GET['page'] : '1';
        $search = isset($_GET['search']) ? $_GET['search'] : array('role' => '');

        $criteria = new CDbCriteria();
        $criteria->together = true;
        $criteria->order = 't.id ASC';

        foreach($search as $k => $v)
        {
            if(!isset($v) || $v === '')
            {
                continue;
            }
            switch($k)
            {
                case 'login_id':
                    $criteria->compare($k, $v, true,'AND');
                    break;
                case 'role':
                    $criteria->compare('role', $v, false,'AND');
                    break;
                default:
                    $criteria->compare($k, $v, true,'AND');
                    break;
            }
        }

        $itemCount =  Administrator::model()->count($criteria);

        $criteria->limit = Yii::app()->params['pageCountItems'];
        $criteria->offset = $criteria->limit * ($page - 1);

        $administrators = Administrator::model()->findAll($criteria);

        $pages = new CPagination($itemCount);
        $pages->pageSize = $criteria->limit;
        $pages->applyLimit($criteria);

        $name = isset($_GET['name']) ? $_GET['name'] : '';
        $message = isset($_GET['message']) ? $_GET['message'] : '';
        $action = isset($_GET['action']) ? $_GET['action'] : '';

        $this->render('index', compact('administrators', 'itemCount', 'name', 'message', 'action', 'search', 'pages'));
    }

    public function actionEdit(){

        $administrator = null;
        if(isset($_GET['id'])) {
            $administrator = Administrator::model()->findByAttributes(array('id' => $_GET['id']));
            if(!$administrator) throw new CHttpException("404", "Page not found.");
        }

        if($administrator == null) $administrator = new Administrator();

        if(isset($_POST['Administrator'])){
            $administrator->attributes = $_POST['Administrator'];
            $administrator->indentifyInfomation = $_POST['IndentifyInfomation'];

            if($administrator->validate()){
                $administrator->save(false);
                $this->redirect($this->createUrl('/systemusers/default/view', array(
                    'id' => $administrator->id,
                    'message' => 'success',
                    'action' => $administrator->isNewRecord ? 'add' : 'edit',
                )));
            }
        }

        $this->render('edit', compact('administrator'));
    }

    public function actionView(){
        $id = $_GET['id'];
        $message = isset($_GET['message']) ? $_GET['message'] : '';
        $action = isset($_GET['action']) ? $_GET['action'] : '';
        $administrator = Administrator::model()->findByAttributes(array('id' => $id));

        if(!$administrator) throw new CHttpException("404", "Page not found.");

        $customFields = AdministratorCustomFileds::model()->findAll(
            "administrator_id=:administrator_id AND filed_name <> 'full_name' AND filed_name <> 'phone' AND filed_name <> 'email'",
            array(
                ':administrator_id' => $id,
            )
        );

        $this->render("view", compact('administrator', 'message', 'action', 'customFields'));
    }

    public function actionDelete(){


        $this->redirect($this->createUrl('/archivesite/default/index', array(
            'name ' => '',
            'message' => 'success',
            'action' => "delete",
        )));
    }

}