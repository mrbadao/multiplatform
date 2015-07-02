<?php

/**
 * This is the model class for table "administrator_modules".
 *
 * The followings are the available columns in table 'administrator_modules':
 * @property integer $id
 * @property string $module_name
 * @property string $module_abbr_cd
 * @property string $module_info
 * @property string $created
 * @property string $modified
 *
 * The followings are the available model relations:
 * @property AdministratorModuleAccess[] $administratorModuleAccesses
 * @property AdministratorModuleActions[] $administratorModuleActions
 * @property AdministratorModuleWidgets[] $administratorModuleWidgets
 */
class AdministratorModules extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AdministratorModules the static model class
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
			array('module_name, module_abbr_cd, module_info', 'required'),
			array('module_name, module_abbr_cd', 'length', 'max'=>128),
			array('created, modified', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, module_name, module_abbr_cd, module_info, created, modified', 'safe', 'on'=>'search'),
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
			'module_abbr_cd' => 'Module Abbr Cd',
			'module_info' => 'Module Info',
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
		$criteria->compare('module_name',$this->module_name,true);
		$criteria->compare('module_abbr_cd',$this->module_abbr_cd,true);
		$criteria->compare('module_info',$this->module_info,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}