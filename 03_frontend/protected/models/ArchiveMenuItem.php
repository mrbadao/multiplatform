<?php

/**
 * This is the model class for table "archive_menu_item".
 *
 * The followings are the available columns in table 'archive_menu_item':
 * @property integer $id
 * @property integer $site_id
 * @property integer $menu_id
 * @property string $title
 * @property string $menu_item_abbr_cd
 * @property integer $is_external
 * @property string $created
 * @property string $modified
 *
 * The followings are the available model relations:
 * @property ArchiveSite $site
 * @property ArchiveMenu $menu
 */
class ArchiveMenuItem extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ArchiveMenuItem the static model class
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
		return 'archive_menu_item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('site_id, menu_id, title', 'required'),
			array('site_id, menu_id, is_external, sort_idx', 'numerical', 'integerOnly'=>true),
			array('title, menu_item_abbr_cd', 'length', 'max'=>128),
			array('sort_idx, created, modified', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, site_id, menu_id, title, menu_item_abbr_cd, is_external, sort_idx, created, modified', 'safe', 'on'=>'search'),
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
			'menu' => array(self::BELONGS_TO, 'ArchiveMenu', 'menu_id'),
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
			'menu_id' => 'Menu',
			'title' => 'Title',
			'menu_item_abbr_cd' => 'Menu Item Abbr Cd',
			'is_external' => 'Is External',
            'sort_idx' => 'Sort index',
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
		$criteria->compare('menu_id',$this->menu_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('menu_item_abbr_cd',$this->menu_item_abbr_cd,true);
		$criteria->compare('is_external',$this->is_external);
		$criteria->compare('sort_idx',$this->sort_idx);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}