<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{
        $this->setTitle('Manage Site');

        $criteria = new CDbCriteria();
        $itemCount =  ArchiveSite::model()->count($criteria);

        $criteria->limit = Yii::app()->params['pageCountItems'];
        $criteria->offset = $criteria->limit * (0);

        $archiveSite = ArchiveSite::model()->findAll($criteria);
		$this->render('index', compact('archiveSite', 'itemCount'));
	}

    public function actionView(){
        $id = $_GET['id'];
        $archiveSite = ArchiveSite::model()->findByAttributes(array('id' => $id));
        if(!$archiveSite) throw new CHttpException("404", "Page not found.");
        $this->render("view", compact('archiveSite'));
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
            var_dump($_POST['ArchiveSite']);
        }

        $this->render('edit', compact('archiveSite', 'staffs'));
    }
}