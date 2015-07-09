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

        if(!file_exists($backupPath = Yii::getPathOfAlias(Yii::app()->params['DbBackupPath']))) @mkdir($backupPath);
        $action = isset($_GET['action']) ? $_GET['action'] : '';
        $filename = isset($_GET['filename']) ? $_GET['filename'] : '';
        $message = '';
        $errMessage = '';
        $items = array();

        if ($filename) {
            switch ($action) {
                case 'unlink':
                    if (file_exists($backupPath . DIRECTORY_SEPARATOR . $filename)) {
                        unlink($backupPath . DIRECTORY_SEPARATOR . $filename);
                        $message = 'success';
                    }
                    break;
                case 'restore':
                    $_message = self::_execSqlFile($backupPath . DIRECTORY_SEPARATOR . $filename, $backupPath . DIRECTORY_SEPARATOR . "temp");
                    if ($_message != 'success') $errMessage = $_message;
                    else $_message = 'success';
                    break;
            }
            $filename = '';
        }

        $filesBackup = $files = CFileHelper::findFiles(
            $backupPath,
            array(
                'fileTypes' => array('sql', 'zip', 'gz'),
                'level' => 1,
            )
        );

        foreach ($filesBackup as $flie) {
            $filename = pathinfo($flie, PATHINFO_BASENAME);
            $fileExt = pathinfo($flie, PATHINFO_EXTENSION);

            $date = explode('_', $filename);
            $date = DateTime::createFromFormat('Y-m-d-H-i-s', $date[0]);

            $items[] = array(
                'filename' => $filename,
                'extension' => $fileExt,
                'size' => round(filesize($backupPath . DIRECTORY_SEPARATOR . $filename) / 1024, 2) . " KB",
                'date' => date_format($date, "Y/m/d H:i:s"),
                'downlaodlink' => $this->createUrl("/systemsetting/default/downloaddatabase", array("filename" => $filename)),
                'deletelink' => $this->createUrl("/systemsetting/default/restoredb", array("filename" => $filename, "action" => "unlink")),
                'restorelink' => $this->createUrl("/systemsetting/default/restoredb", array("filename" => $filename, "action" => "restore")),
            );
        }

        $this->render('restoredb', compact('items', 'message', 'filetype', 'filesBackup', 'action', 'errMessage'));
    }

    private function _execSqlFile($filename, $tempPath)
    {
        $message = "success";

        if (file_exists($filename)) {
            $sqlArray = self::_uncompressed($filename, $tempPath);
            var_dump($sqlArray);
            $cmd = Yii::app()->db_backup->createCommand($sqlArray);
            try {
                $cmd->execute();
            } catch (CDbException $e) {
                $message = $e->getMessage();
            }
            return $message;
        }
        return "File not found.";
    }

    /**
     * @decripton Uncompressed "filename.sql.ext" => "filename.sql"          *
     * @param $filePath
     * @param $toExtension
     * @param $content
     * @param $getFilename [= true] return file name if true
     * @return string
     */
    private function _uncompressed($filePath, $tempPath, $getContent = true)
    {
        if (!file_exists($tempPath)) @mkdir($tempPath, 0755);
        $_result = '';
        $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
        $fileName = pathinfo($filePath, PATHINFO_FILENAME);
        switch ($fileExtension) {
            case 'zip';
                $zip = new ZipArchive;
                if (!$zip->open($filePath)) {
                    return false;
                }

                $zip->extractTo($tempPath);
                $zip->close();

                $_result = $getContent ? file_get_contents($tempPath . DIRECTORY_SEPARATOR . $fileName) : $tempPath . DIRECTORY_SEPARATOR . $fileName;
                unlink($tempPath . DIRECTORY_SEPARATOR . $fileName);
                break;

            case 'gz':
                if (function_exists('gzdecode'))
                    gzinflate(substr(file_get_contents($filePath), 10, -8));

                if ($getContent) {
                    $_result = gzinflate(substr(file_get_contents($filePath), 10, -8));
                    break;
                }
                file_put_contents($tempPath . DIRECTORY_SEPARATOR . $fileName, $_result);
                $_result = $tempPath . DIRECTORY_SEPARATOR . $fileName;
                unlink($tempPath . DIRECTORY_SEPARATOR . $fileName);
                break;
            default:
                file_get_contents($filePath);
                $_result = $getContent ? file_get_contents($filePath) : $filePath;

        }

        return $_result;
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
        if (!file_exists($backupPath)) {
            @mkdir($backupPath, 0755, true);
        }

        if (isset($_POST['Database']) && isset($_POST['FileType'])) {
            foreach ($_POST['Database'] as $name => $database) {
                $dumper = new SDatabaseDumper($databaseList[$name], $backupOption);
                $filename = date('Y-m-d-H-i-s') . '_dump_' . $name . '.sql';
                $file = $backupPath . DIRECTORY_SEPARATOR . $filename;
                $filename = self::_compressed($file, $_POST['FileType'], $dumper->getDump());
                $filesBackup[$name] = array(
                    'filename' => $filename,
                    'link' => $this->createUrl("/systemsetting/default/downloaddatabase", array("filename" => $filename)
                    ));
            }
            $message = count($filesBackup) == count($_POST['Database']) ? 'success' : $message;
        }

        $this->render('backupdb', compact('databaseList', 'message', 'filetype', 'filesBackup'));
    }

    /**
     * @decripton Compressed "filename.ext" => "filename.ext.toExtension"          *
     * @param $filePath
     * @param $toExtension
     * @param $content
     * @param $getFilename [= true] return file name if true
     * @return string
     */
    private function _compressed($filePath, $toExtension, $content, $getFilename = true)
    {
        $filename = pathinfo($filePath, PATHINFO_BASENAME);
        switch ($toExtension) {
            case 'zip';
                $zip = new ZipArchive;
                if ($zip->open($filePath . '.zip', ZipArchive::CREATE)) {
                    $zip->addFromString($filename, $content);
                    return $getFilename ? $filename . ".zip" : $filePath . ".zip";
                }
                $zip->close();
                break;

            case 'gz':
                if (function_exists('gzencode'))
                    file_put_contents($filePath . '.gz', gzencode($content));
                return $getFilename ? $filename . ".gz" : $filePath . ".gz";
                break;
            default:
                file_put_contents($filePath, $content);
                return $getFilename ? $filename : $filePath;

        }

        file_put_contents($filePath, $content);
        return $getFilename ? $filename : $filePath;
    }

    public function actionDownloadDatabase()
    {
        $filename = isset($_GET['filename']) ? $_GET['filename'] : '';

        if (Yii::app()->user->isGuest || Yii::app()->user->getId() != Yii::app()->params['super_id'] || Yii::app()->user->role != '1' || !$filename)
            throw new CHttpException("404", "File not found.");

        $file = Yii::getPathOfAlias(Yii::app()->params['DbBackupPath']) . DIRECTORY_SEPARATOR . $filename;

        if (file_exists($file)) {
            return Yii::app()->getRequest()->sendFile($filename, @file_get_contents($file));
        } else throw new CHttpException("404", "File not found.");
    }
}