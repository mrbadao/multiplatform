<?php

/**
 * This is the model class for table "administrator_modules".
 *
 * The followings are the available columns in table 'administrator_modules':
 * @property integer $id
 * @property string $module_name
 * @property string $module_abbr_cd
 * @property string $module_info
 * @property string $version
 * @property string $idx
 * @property string $created
 * @property string $modified
 * @property string $moduleActions
 *
 * The followings are the available model relations:
 * @property AdministratorModuleAccess[] $administratorModuleAccesses
 * @property AdministratorModuleActions[] $administratorModuleActions
 * @property AdministratorModuleWidgets[] $administratorModuleWidgets
 */
class AdministratorModules extends CActiveRecord
{
    public $moduleActions;
    public $object = '';

    private $_allowExt = array(
        'zip' => 'application/zip',
    );

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AdministratorModules the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'administrator_modules';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('object, module_name, module_abbr_cd, module_info', 'required'),
            array('module_name, module_abbr_cd', 'length', 'max' => 128),
            array('version, idx, created, modified', 'safe'),
            array('module_abbr_cd', 'unique'),
            array('module_name', 'unique'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, module_name, module_abbr_cd, module_info, version, idx, created, modified', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'administratorModuleAccesses' => array(self::HAS_MANY, 'AdministratorModuleAccess', 'module_id'),
            'administratorModuleActions' => array(self::HAS_MANY, 'AdministratorModuleActions', 'module_id'),
            'administratorModuleWidgets' => array(self::HAS_MANY, 'AdministratorModuleWidgets', 'module_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'module_name' => 'Module Name',
            'module_abbr_cd' => 'Module domain',
            'module_info' => 'Module Info',
            'version' => 'Version',
            'idx' => 'Sort index',
            'created' => 'Created',
            'modified' => 'Modified',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('module_name', $this->module_name, true);
        $criteria->compare('module_abbr_cd', $this->module_abbr_cd, true);
        $criteria->compare('module_info', $this->module_info, true);
        $criteria->compare('version', $this->version, true);
        $criteria->compare('idx', $this->idx);
        $criteria->compare('created', $this->created, true);
        $criteria->compare('modified', $this->modified, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Before save to database action.
     */
    public function beforeSave()
    {
        $curentDate = new CDbExpression('NOW()');

        if ($this->isNewRecord) {
            $this->created = $curentDate;
        }
        $this->modified = $curentDate;

        return true;
    }

    protected function beforeValidate()
    {
        if (!$this->object['name']['object'] && $this->isNewRecord == true) {
            $this->addError('object', 'Object can not be blank.');
            return false;
        }

        if (!isset($this->object['error']['object']) || is_array($this->object['error']['object'])) {
            $this->addError('object', 'Object be damaged.');
            return false;
        }

        return true;
    }

    protected function afterValidate()
    {
        $errors = $this->getErrors();

        if (empty($errors)) {
            if (!$this->object['name']['object'] && $this->isNewRecord == false) return true;

            $finfo = new finfo(FILEINFO_MIME_TYPE);
            if (false == $ObjectExt = array_search($finfo->file($this->object['tmp_name']['object']), $this->_allowExt, true)) {
                $this->addError('object', 'Object extention not allow.');
                return false;
            }

            if(!file_exists(Yii::getPathOfAlias(Yii::app()->params['module']['zipPath']))){
                @mkdir(Yii::getPathOfAlias(Yii::app()->params['module']['zipPath']), 0755, true);
            }

            $filename = sprintf('%s/%s.%s', Yii::getPathOfAlias(Yii::app()->params['module']['zipPath']), $this->module_abbr_cd, $ObjectExt);
            if (!move_uploaded_file($this->object['tmp_name']['object'], $filename)) {
                $this->addError('object', 'Object upload failed.');
                return false;
            }

            $zip = new ZipArchive;
            if (!$zip->open($filename)) {
                $this->addError('object', 'Unable open object.');
                return false;
            }

            $extractPath = Yii::getPathOfAlias(Yii::app()->params['module']['tempPath']);
            if(!file_exists($extractPath)){
                @mkdir($extractPath,0777, true);
            }

            $zip->extractTo($extractPath);
            $zip->close();

            $extractPath = sprintf('%s/%s', $extractPath, $this->module_abbr_cd);

            $versionFile = $extractPath . "/version.json";

            if (!file_exists($versionFile)) {
                $this->addError('object', 'Unable read version file.');
            }

            $versionData = json_decode(file_get_contents($versionFile), true);

            if (!$versionData || !is_array($versionData)) {
                $this->addError('object', 'Unable read object info.');
                return false;
            }

            if($this->isNewRecord == false && $this->version == $versionData['version']){
                $this->addError('object', 'Object already installed.');
                return false;
            }
            $this->version = $versionData['version'];

            if(self::_moveFilesToModules($versionData['dir'], $extractPath)){
                $this->save(false);
                foreach($versionData['controller'] as $controllerName => $controller){
                    foreach($controller as $action){
                        $action = array_merge(
                            $action, array('module_id' => $this->id, "controller" => $controllerName)
                        );

                        $moduleAction = AdministratorModuleActions::model()->findByAttributes(array(
                            "controller" => $action['controller'],
                            "module_id" => $action['module_id'],
                            "action_abbr_cd" => $action['action_abbr_cd'],
                        ));

                        $moduleAction = !$moduleAction ? new AdministratorModuleActions() : $moduleAction;
                        $moduleAction->attributes = $action;
                        $moduleAction->save(false);

                        $superAdminAccess = AdministratorModuleAccess::model()->findByAttributes(array(
                            'administrator_id' => isset(Yii::app()->params['super_id']) ? Yii::app()->params['super_id'] : '1',
                            'module_id' => $this->id,
                            'muodule_action_id' => $moduleAction->id,
                        ));

                        $superAdminAccess = !$superAdminAccess ? new AdministratorModuleAccess() : $superAdminAccess;
                        $superAdminAccess->attributes = array(
                            'administrator_id' => '1',
                            'module_id' => $this->id,
                            'muodule_action_id' => $moduleAction->id,
                        );
                        $superAdminAccess->save(false);
                    }
                }
                unlink($extractPath);
            }

        }

        return false;
    }

    private function _moveFilesToModules($data, $extractPath)
    {
        try {
            foreach ($data as $src => $dst) {
                self::_recurseCopy($extractPath . "/$src", Yii::getPathOfAlias($dst));
            }
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

    private function _recurseCopy($src, $dst)
    {
        $dir = opendir($src);
        @mkdir($dst);
        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {
                    self::_recurseCopy($src . '/' . $file, $dst . '/' . $file);
                } else {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

    public function afterFind(){
        $this->moduleActions = $this->administratorModuleActions;
    }
}