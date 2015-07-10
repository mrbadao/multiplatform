<?php

/**
 * This is the model class for table "administrator".
 *
 * The followings are the available columns in table 'administrator':
 *
 * @property integer $indentifyInfomation
 * @property integer $id
 * @property string $login_id
 * @property string $password
 * @property integer $role
 * @property string $created
 * @property string $modified
 *
 * The followings are the available model relations:
 * @property AdministratorCustomFileds[] $administratorCustomFileds
 * @property AdministratorModuleAccess[] $administratorModuleAccesses
 */
class Administrator extends CActiveRecord
{
    public $indentifyInfomation = array(
        'full_name' => '',
        'phone' => '',
        'email' => '',
    );

    private $_indentifyInfomationModel;

    /**
     * Returns the static model of the specified AR class.
     *
     * @param string $className active record class name.
     * @return Administrator the static model class
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
        return 'administrator';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('login_id, password', 'required'),
            array('login_id', 'unique'),
            array('role', 'numerical', 'integerOnly' => true),
            array('login_id', 'length', 'max' => 20),
            array('password', 'length', 'max' => 128),
            array('created, modified', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, login_id, password, role, created, modified', 'safe', 'on' => 'search'),
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
            'administratorCustomFileds' => array(self::HAS_MANY, 'AdministratorCustomFileds', 'administrator_id'),
            'administratorModuleAccesses' => array(self::HAS_MANY, 'AdministratorModuleAccess', 'administrator_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'full_name' => 'Full name',
            'phone' => 'Phone number',
            'email' => 'Email',
            'id' => 'ID',
            'login_id' => 'Login id',
            'password' => 'Password',
            'role' => 'Role',
            'created' => 'Created',
            'modified' => 'Modified',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('login_id', $this->login_id, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('role', $this->role);
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

        if (!preg_match('/^[a-f0-9]{32}$/', $this->password)) $this->password = md5($this->password);

        return true;
    }

    public function afterSave()
    {
        foreach ($this->_indentifyInfomationModel as $customFieldModel) {
            $customFieldModel->administrator_id = $this->id;
            $customFieldModel->save(false);
        }
        return true;
    }

    /**
     * After find to database action.
     */
    public function afterFind()
    {
        if ($this->isNewRecord) return;

        $indentifyInfomation = $this->administratorCustomFileds;
        if (!$indentifyInfomation) return;
        foreach ($indentifyInfomation as $intent) {
            $this->indentifyInfomation[$intent->filed_name] = $intent->filed_value;
            $this->_indentifyInfomationModel[$intent->filed_name] = $intent;
        }
    }

    /**
     * Before Validate to database action.
     */
    protected function beforeValidate()
    {
        foreach ($this->indentifyInfomation as $field_name => $field_value) {
            if($this->isNewRecord || !isset($this->_indentifyInfomationModel[$field_name]) || !$this->_indentifyInfomationModel[$field_name])
                $this->_indentifyInfomationModel[$field_name] = new AdministratorCustomFileds();

            $this->_indentifyInfomationModel[$field_name]->attributes = array(
                'administrator_id' => !$this->isNewRecord ? $this->id : '',
                'filed_name' => $field_name,
                'filed_value' => $field_value,
            );

            $validateCustomeFieldResult = !$this->isNewRecord ? $this->_indentifyInfomationModel[$field_name]->validate() : $this->_indentifyInfomationModel[$field_name]->validate(array('filed_name', 'filed_value'));

            if (!$validateCustomeFieldResult) {
                if ($this->_indentifyInfomationModel[$field_name]->getError('filed_value')) $this->addError($field_name, $this->getAttributeLabel($field_name) . " can not be blank.");
            }
        }
        return true;
    }

    private function _fnUasortASC($a, $b)
    {
        if ($a[0]['sort_idx'] == $b[0]['sort_idx']) {
            return 0;
        }
        return ($a[0]['sort_idx'] < $b[0]['sort_idx']) ? -1 : 1;
    }

    /**
     * Get menu that admin have permission to access.
     */
    public function getMenuData($site_domain)
    {
        $section = '';
        $menuData = array();
        foreach ($this->administratorModuleAccesses as $moduleAccess) {
            $module = $moduleAccess->module;
            $moduleAction = $moduleAccess->muoduleActionMenu;

            $c = new CDbCriteria();
            $c->addCondition('id=' . $moduleAccess->muodule_action_id, 'AND');
            $c->addCondition("is_menu = '1'", 'AND');
            $c->together = true;


            if ($moduleAction) {
                $menuData[$module->module_name][] = array(
                    'title' => $moduleAction->action_name,
                    'link' => "/" . $module->module_abbr_cd . '/' . $moduleAction->controller . '/' . $moduleAction->action_abbr_cd,
                    'sort_idx' => $module->idx
                );
            }
        }
        uasort($menuData, array('self', '_fnUasortASC'));
        return $menuData;
    }

}