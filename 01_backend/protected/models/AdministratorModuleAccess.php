<?php

/**
 * This is the model class for table "administrator_module_access".
 *
 * The followings are the available columns in table 'administrator_module_access':
 *
 * @property integer $account
 * @property integer $id
 * @property integer $administrator_id
 * @property integer $module_id
 * @property integer $muodule_action_id
 * @property string $created
 * @property string $modified
 *
 * The followings are the available model relations:
 * @property AdministratorModuleActions $muoduleAction
 * @property AdministratorModuleActions $muoduleActionMenu
 * @property Administrator $administrator
 * @property AdministratorModules $module
 */
class AdministratorModuleAccess extends CActiveRecord
{
    public $account = '';

    /**
     * Returns the static model of the specified AR class.
     *
     * @param string $className active record class name.
     * @return AdministratorModuleAccess the static model class
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
        return 'administrator_module_access';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('administrator_id, module_id, muodule_action_id', 'required'),
            array('administrator_id, module_id, muodule_action_id', 'numerical', 'integerOnly' => true),
            array('created, modified', 'safe'),
            array('administrator_id', 'UniqueAttributesValidator', 'with'=>'module_id,muodule_action_id'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, administrator_id, module_id, muodule_action_id, created, modified', 'safe', 'on' => 'search'),
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
            'muoduleAction' => array(self::BELONGS_TO, 'AdministratorModuleActions', 'muodule_action_id'),
            'muoduleActionMenu' => array(self::BELONGS_TO, 'AdministratorModuleActions', 'muodule_action_id', 'condition' => 'muoduleActionMenu.is_menu = 1'),
            'administrator' => array(self::BELONGS_TO, 'Administrator', 'administrator_id', 'condition' => ''),
            'module' => array(self::BELONGS_TO, 'AdministratorModules', 'module_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'administrator_id' => 'Administrator',
            'module_id' => 'Module',
            'muodule_action_id' => 'Muodule Action',
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
        $criteria->compare('administrator_id', $this->administrator_id);
        $criteria->compare('module_id', $this->module_id);
        $criteria->compare('muodule_action_id', $this->muodule_action_id);
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

        if ($this->isNewRecord || !$this->created) {
            $this->created = $curentDate;
        }
        $this->modified = $curentDate;

        return true;
    }

    public function afterFind()
    {
        $this->account = $this->administrator_id ? Administrator::model()->findByPk($this->administrator_id) : $this->account;
        return true;
    }
}