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

    public function actionRestoreDb()
    {
        Yii::import('ext.SDatabaseDumper');
        $message = '';
        $items = array();

        $filesBackup = $files = CFileHelper::findFiles(
            Yii::getPathOfAlias(Yii::app()->params['DbBackupPath']),
            array(
                'fileTypes' => array('sql'),
            )
        );

        foreach($filesBackup as $flie){
            $filename = pathinfo($flie, PATHINFO_BASENAME );
            $fileExt = pathinfo($flie, PATHINFO_EXTENSION );
            $date = explode('_', $filename);
            $date = DateTime::createFromFormat('Y-m-d-H-i-s', $date[0]);
            $link = $this->createUrl("/systemsetting/default/downloaddatabase", array("filename" => $filename));
            $items[] = array(
                'filename'=> $filename,
                'extension'=> $fileExt,
                'date' => date_format($date,"Y/m/d H:i:s"),
                'link' => $link,
            );
        }

        $this->render('restoredb', compact('items', 'message', 'filetype', 'filesBackup'));
    }

    public function actionBackupDb()
    {
        Yii::import('ext.SDatabaseDumper');
        $filesBackup = array();
        $backupOption = isset($_POST['BackupOption']) ? $_POST['BackupOption'] : array();
        $message = '';

        $databaseList = array(
            'Admin' => Yii::app()->db,
            'Archive' => Yii::app()->db_archive,
            'Staff' => Yii::app()->db_staff,
        );

        $filetype = array(
            'sql' => 'sql',
            'zip' => 'zip',
            'gz' => 'gz',
        );

        $backupPath = Yii::getPathOfAlias(Yii::app()->params['DbBackupPath']);
        if(!file_exists($backupPath)){
            @mkdir($backupPath, 0755, true);
        }

        if (isset($_POST['Database']) && isset($_POST['FileType'])) {
            foreach ($_POST['Database'] as $name => $database) {
                $dumper = new SDatabaseDumper($databaseList[$name], $backupOption);
                $filename = date('Y-m-d-H-i-s').'_dump_' . $name . '.sql';
                $file = $backupPath . DIRECTORY_SEPARATOR . $filename;

                switch($_POST['FileType']){
                    case $filetype['gz']:
                        if (function_exists('gzencode'))
                            file_put_contents($file . '.gz', gzencode($dumper->getDump()));
                        else
                            file_put_contents($file, $dumper->getDump());

                        $filesBackup[$name] = array('filename' => $filename.'.gz', 'link' => $this->createUrl("/systemsetting/default/downloaddatabase", array("filename" => $filename.'.gz')));
                        break;

                    case $filetype['zip']:
                        $zip = new ZipArchive;

                        if ($zip->open($file.'.zip', ZipArchive::CREATE)) {
                            $zip->addFromString($filename, $dumper->getDump());

                            $filesBackup[$name] = array('filename' => $filename.'.zip', 'link' => $this->createUrl("/systemsetting/default/downloaddatabase", array("filename" => $filename.'.zip')));
                        }

                        $zip->close();
                        break;

                    default:
                        file_put_contents($file, $dumper->getDump());

                        $filesBackup[$name] = array('filename' => $filename, 'link' =>$this->createUrl("/systemsetting/default/downloaddatabase", array("filename" => $filename)));
                        break;

                }
            }
            $message = count($filesBackup) == count($_POST['Database']) ? 'success' : $message;
        }

        $this->render('backupdb', compact('databaseList', 'message', 'filetype', 'filesBackup'));
    }

    public function actionDownloadDatabase(){
        $filename = isset($_GET['filename']) ? $_GET['filename'] : '';

        if(Yii::app()->user->isGuest || Yii::app()->user->getId() != Yii::app()->params['super_id'] ||  Yii::app()->user->role != '1' || !$filename)
            throw new CHttpException("404", "File not found.");

        $file = Yii::getPathOfAlias(Yii::app()->params['DbBackupPath']). DIRECTORY_SEPARATOR . $filename;

        if(file_exists($file))
        {
            return Yii::app()->getRequest()->sendFile($filename, @file_get_contents($file));
        }else throw new CHttpException("404", "File not found.");
    }
}