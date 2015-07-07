<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{
        $this->setTitle('Manage Site');
        $page = isset($_GET['page']) ? $_GET['page'] : '1';
        $search = isset($_GET['search']) ? $_GET['search'] : array('use_single_domain' => '');

        $criteria = new CDbCriteria();
        $criteria->together = true;
        $criteria->order = 't.id DESC';

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

        $itemCount =  ArchiveSite::model()->count($criteria);

        $criteria->limit = 1;
        $criteria->offset = $criteria->limit * ($page - 1);

        $archiveSite = ArchiveSite::model()->findAll($criteria);

        $pages = new CPagination($itemCount);
        $pages->pageSize = $criteria->limit;
        $pages->applyLimit($criteria);

        $name = isset($_GET['name']) ? $_GET['name'] : '';
        $message = isset($_GET['message']) ? $_GET['message'] : '';
        $action = isset($_GET['action']) ? $_GET['action'] : '';

		$this->render('index', compact('archiveSite', 'itemCount', 'name', 'message', 'action', 'search', 'pages'));
	}

    public function actionView(){
        $id = $_GET['id'];
        $message = isset($_GET['message']) ? $_GET['message'] : '';
        $action = isset($_GET['action']) ? $_GET['action'] : '';
        $archiveSite = ArchiveSite::model()->findByAttributes(array('id' => $id));
        if(!$archiveSite) throw new CHttpException("404", "Page not found.");
        $this->render("view", compact('archiveSite', 'message', 'action'));
    }

    public function actionEdit(){
        $archiveSite = null;

        if(isset($_GET['id'])) {
            $archiveSite = ArchiveSite::model()->findByAttributes(array('id' => $_GET['id']));
            if(!$archiveSite) throw new CHttpException("404", "Page not found.");
        }

        $staffs = Staff::model()->findAll();

        if($archiveSite == null) $archiveSite = new ArchiveSite();

        if(isset($_POST['ArchiveSite'])){
            $_POST['ArchiveSite']['use_single_domain'] = isset($_POST['ArchiveSite']['use_single_domain']) ?$_POST['ArchiveSite']['use_single_domain'] : 0;
            $archiveSite->attributes = $_POST['ArchiveSite'];
            if($archiveSite->validate()){
                $archiveSite->save(false);
                $this->redirect($this->createUrl('/archivesite/default/view', array(
                    'id' => $archiveSite->id,
                    'message' => 'success',
                    'action' => $archiveSite->isNewRecord ? 'add' : 'edit',
                )));
            }
        }
        $this->render('edit', compact('archiveSite', 'staffs'));
    }

    public function actionDelete(){
        $siteName='';
        $archiveSite='';
        $id = isset($_GET['id']) ? $_GET['id'] : '';

        $citeria = new CDbCriteria();
        $citeria->addCondition("id=$id", 'AND');
        $archiveSite = ArchiveSite::model()->find($citeria);

        if($archiveSite) {
            $siteName = $archiveSite->site_name;
            $archiveSite->delete();
        }

        $this->redirect($this->createUrl('/archivesite/default/index', array(
            'name ' => $siteName,
            'message' => 'success',
            'action' => "delete",
        )));
    }
}