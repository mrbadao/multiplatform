<?php

/**
 * This is the model class for table "administrator".
 *
 * The followings are the available columns in table 'administrator':
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
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Administrator the static model class
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
			array('role', 'numerical', 'integerOnly'=>true),
			array('login_id', 'length', 'max'=>45),
			array('password', 'length', 'max'=>128),
			array('created, modified', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, login_id, password, role, created, modified', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'login_id' => 'Login',
			'password' => 'Password',
			'role' => 'Role',
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
		$criteria->compare('login_id',$this->login_id,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('role',$this->role);
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

        if(!preg_match('/^[a-f0-9]{32}$/', $this->password)) $this->password = md5($this->password);

        return true;
    }


    /**
     * Get menu that admin have permission to access.
     */
    public function getMenuData($site_domain){
        $section ='';
        $menuData = array();

        foreach($this->administratorModuleAccesses as $moduleAccess){
            $module = $moduleAccess->module;
            $action = $moduleAccess->muoduleAction;

            $menuData[$module->module_name][] = array(
                'title' => $action->action_name,
                'link'  => "/" .$module->module_abbr_cd .'/' .$action->controller .'/' .$action->action_abbr_cd,
            );
        }
        return $menuData;
    }

}