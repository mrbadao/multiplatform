<?php

/**
 * This is the model class for table "administrator_module_actions".
 *
 * The followings are the available columns in table 'administrator_module_actions':
 * @property integer $id
 * @property integer $module_id
 * @property string $action_name
 * @property string $action_abbr_cd
 * @property integer $is_menu
 * @property string $created
 * @property string $modified
 *
 * The followings are the available model relations:
 * @property AdministratorModuleAccess[] $administratorModuleAccesses
 * @property AdministratorModules $module
 */
class AdministratorModuleActions extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AdministratorModuleActions the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'administrator_module_actions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('module_id, action_name, action_abbr_cd', 'required'),
			array('module_id, is_menu', 'numerical', 'integerOnly'=>true),
			array('action_name, action_abbr_cd', 'length', 'max'=>128),
			array('created, modified', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, module_id, action_name, action_abbr_cd, is_menu, created, modified', 'safe', 'on'=>'search'),
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
			'administratorModuleAccesses' => array(self::HAS_MANY, 'AdministratorModuleAccess', 'muodule_action_id'),
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
			'module_id' => 'Module',
			'action_name' => 'Action Name',
			'action_abbr_cd' => 'Action Abbr Cd',
			'is_menu' => 'Is Menu',
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('module_id',$this->module_id);
		$criteria->compare('action_name',$this->action_name,true);
		$criteria->compare('action_abbr_cd',$this->action_abbr_cd,true);
		$criteria->compare('is_menu',$this->is_menu);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Before save to database action.
     */
    public function beforeSave(){
        $curentDate =  new CDbExpression('NOW()');

        if($this->isNewRecord){
            $this->created = $curentDate;
        }
        $this->modified = $curentDate;

        return true;
    }
}