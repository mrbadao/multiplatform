<?php

/**
 * This is the model class for table "administrator_custom_fileds".
 *
 * The followings are the available columns in table 'administrator_custom_fileds':
 * @property integer $id
 * @property integer $administrator_id
 * @property string $filed_name
 * @property string $filed_value
 * @property string $created
 * @property string $modified
 *
 * The followings are the available model relations:
 * @property Administrator $administrator
 */
class AdministratorCustomFileds extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AdministratorCustomFileds the static model class
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
		return 'administrator_custom_fileds';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('administrator_id, filed_name, filed_value', 'required'),
			array('administrator_id', 'numerical', 'integerOnly'=>true),
			array('filed_name', 'length', 'max'=>45),
			array('created, modified', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, administrator_id, filed_name, filed_value, created, modified', 'safe', 'on'=>'search'),
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
			'administrator' => array(self::BELONGS_TO, 'Administrator', 'administrator_id'),
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
			'filed_name' => 'Filed Name',
			'filed_value' => 'Filed Value',
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
		$criteria->compare('administrator_id',$this->administrator_id);
		$criteria->compare('filed_name',$this->filed_name,true);
		$criteria->compare('filed_value',$this->filed_value,true);
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