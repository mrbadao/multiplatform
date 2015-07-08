<?php

class DefaultController extends Controller
{
	public function actionCmsMainConfig()
	{
        Yii::app()->CodeMirror->import();
        $message = '';

        $configFilePath = sprintf("%s/main.php",Yii::getPathOfAlias('application.config'));
        $fileContent = file_exists($configFilePath) ? file_get_contents($configFilePath) :'';

        if(isset($_POST['FileContent']) && $_POST['FileContent']){
            file_put_contents($configFilePath, $_POST['FileContent']);
            $fileContent = $_POST['FileContent'];
            $message ='success';
        }

		$this->render('cmsmainconfig', compact('fileContent', 'message'));
	}
}