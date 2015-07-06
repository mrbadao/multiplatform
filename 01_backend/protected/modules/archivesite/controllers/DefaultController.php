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
}