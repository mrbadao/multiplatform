<?php

/**
 * This is the model class for table "archive_site".
 *
 * The followings are the available columns in table 'archive_site':
 * @property integer $id
 * @property string $site_name
 * @property integer $staff_id
 * @property string $site_abbr_cd
 * @property integer $use_single_domain
 * @property string $site_domain
 * @property string $created
 * @property string $modified
 *
 * The followings are the available model relations:
 * @property ArchiveMenu[] $archiveMenus
 * @property ArchivePages[] $archivePages
 * @property SupStaff.staff $staff
 */
class ArchiveSite extends CActiveRecord
{
    public $own='';

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ArchiveSite the static model class
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
		return 'archive_site';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('site_name, staff_id, site_abbr_cd', 'required'),
			array('staff_id, use_single_domain', 'numerical', 'integerOnly'=>true),
			array('site_domain', 'validateSiteDomain'),
			array('site_name, site_abbr_cd, site_domain', 'length', 'max'=>128),
			array('created, modified', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, site_name, staff_id, site_abbr_cd, use_single_domain, site_domain, created, modified', 'safe', 'on'=>'search'),
		);
	}
	
	public function validateSiteDomain()
	{

		if(!$this->use_single_domain){
			$this->site_domain ='';
			return true;
		}
		if(filter_var($this->site_domain, FILTER_VALIDATE_URL) && preg_match("~^(?:f|ht)tps?://~i", $this->site_domain)) return true;
		$this->addError('site_domain', 'Incorrect site domain');
		return false;
	}
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'archiveMenus' => array(self::HAS_MANY, 'ArchiveMenu', 'site_id'),
			'archivePages' => array(self::HAS_MANY, 'ArchivePages', 'site_id'),
			'Staff' => array(self::BELONGS_TO, 'Staff', 'staff_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'site_name' => 'Site Name',
			'staff_id' => 'Staff',
			'site_abbr_cd' => 'Site Derectory',
			'use_single_domain' => 'Use Single Domain',
			'site_domain' => 'Site Domain',
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
		$criteria->compare('site_name',$this->site_name,true);
		$criteria->compare('staff_id',$this->staff_id);
		$criteria->compare('site_abbr_cd',$this->site_abbr_cd,true);
		$criteria->compare('use_single_domain',$this->use_single_domain);
		$criteria->compare('site_domain',$this->site_domain,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function afterFind(){
		$this->own = $this->Staff;
        return true;
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