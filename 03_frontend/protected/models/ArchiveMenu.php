<?php

/**
 * This is the model class for table "archive_menu".
 *
 * The followings are the available columns in table 'archive_menu':
 * @property integer $id
 * @property integer $site_id
 * @property string $menu_name
 * @property string $menu_abbr_cd
 * @property string $created
 * @property string $modified
 *
 * The followings are the available model relations:
 * @property ArchiveSite $site
 */
class ArchiveMenu extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ArchiveMenu the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return CDbConnection database connection
	 */
	public function getDbConnection()
	{
		return Yii::app()->db_archive;
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'archive_menu';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('site_id, menu_name, menu_abbr_cd', 'required'),
			array('site_id', 'numerical', 'integerOnly'=>true),
			array('menu_name, menu_abbr_cd', 'length', 'max'=>128),
			array('created, modified', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, site_id, menu_name, menu_abbr_cd, created, modified', 'safe', 'on'=>'search'),
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
			'site' => array(self::BELONGS_TO, 'ArchiveSite', 'site_id'),
            'archiveMenuItem' => array(self::HAS_MANY, 'ArchiveMenuItem', 'menu_id', 'order' => 'sort_idx ASC'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'site_id' => 'Site',
			'menu_name' => 'Menu Name',
			'menu_abbr_cd' => 'Menu Abbr Cd',
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
		$criteria->compare('site_id',$this->site_id);
		$criteria->compare('menu_name',$this->menu_name,true);
		$criteria->compare('menu_abbr_cd',$this->menu_abbr_cd,true);
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