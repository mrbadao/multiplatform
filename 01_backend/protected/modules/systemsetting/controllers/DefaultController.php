<?php

class DefaultController extends Controller
{
    public function actionCmsMainConfig()
    {
        Yii::app()->CodeMirror->import();
        $message = '';

        $configFilePath = sprintf("%s/main.php", Yii::getPathOfAlias('application.config'));
        $fileContent = file_exists($configFilePath) ? file_get_contents($configFilePath) : '';

        if (isset($_POST['FileContent']) && $_POST['FileContent']) {
            file_put_contents($configFilePath, $_POST['FileContent']);
            $fileContent = $_POST['FileContent'];
            $message = 'success';
        }

        $this->render('cmsmainconfig', compact('fileContent', 'message'));
    }

    public function actionBackupDb()
    {
        Yii::import('ext.SDatabaseDumper');
        $message = '';

        $databaseList = array(
            'Admin' => Yii::app()->db,
            'Archive' => Yii::app()->db_archive,
            'Staff' => Yii::app()->db_staff,
        );

        if (isset($_POST['Database'])) {
            foreach ($_POST['Database'] as $name => $database) {
                $dumper = new SDatabaseDumper($database);
                $file = Yii::getPathOfAlias(Yii::app()->params['DbBackupPath']) . DIRECTORY_SEPARATOR . 'dump_' . $name . '_' . date('Y-m-d_H_i_s') . '.sql';
                if (function_exists('gzencode'))
                    file_put_contents($file . '.gz', gzencode($dumper->getDump()));
                else
                    file_put_contents($file, $dumper->getDump());
            }
        }


        $this->render('backupdb', compact('databaseList', 'message'));
    }
}