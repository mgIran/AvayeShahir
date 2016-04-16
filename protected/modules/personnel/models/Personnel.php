<?php

/**
 * This is the model class for table "{{personnel}}".
 *
 * The followings are the available columns in table '{{personnel}}':
 * @property string $id
 * @property string $name
 * @property string $family
 * @property string $post
 * @property string $avatar
 * @property string $resume
 * @property string $email
 * @property string $social_links
 * @property string $grade
 * @property string $tell
 * @property string $address
 * @property string $file
 */
class Personnel extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{personnel}}';
	}

	public $fullNameFilter;
	/**
	 * __set
	 *
	 * Rewrite default setter, so we can dynamically add
	 * new virtual attribtues such as name_en, name_de etc.
	 *
	 * @param string $name
	 * @param string $value
	 * @return string
	 */

	public function __set($name, $value)
	{
		if (EMHelper::WinnieThePooh($name, $this->behaviors()))
			$this->{$name} = $value;
		else
			parent::__set($name, $value);
	}


	/**
	 * behaviors
	 *
	 * @return array
	 */

	public function behaviors()
	{
		return array(
				'EasyMultiLanguage' => array(
						'class' => 'ext.EasyMultiLanguage.EasyMultiLanguageBehavior',
						// @todo Please change those attributes that should be translated.
						'translated_attributes' => array('name', 'family', 'post', 'resume', 'grade'),
						// @todo Please add admin actions
						'admin_routes' => array('personnel/manage/create', 'personnel/manage/update', 'personnel/manage/admin'),
						//
						'languages' => Yii::app()->params['languages'],
						'default_language' => Yii::app()->params['default_language'],
						'translations_table' => 'ym_translations',
				),
		);
	}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, family, post, email', 'required'),
			array('name, family, post', 'length', 'max'=>50),
			array('avatar', 'length', 'max'=>500),
			array('email, grade', 'length', 'max'=>100),
			array('social_links', 'length', 'max'=>2000),
			array('tell', 'length', 'max'=>11),
			array('resume, address ,file', 'safe'),
			// The following rule is used by search().
			array('id, name, family, post, avatar, resume, email, social_links, grade ,fullNameFilter', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'نام',
			'family' => 'نام خانوادگی',
			'post' => 'سمت',
			'avatar' => 'آواتار',
			'resume' => 'رزومه',
			'file' => 'فایل رزومه',
			'email' => 'پست الکترونیک',
			'social_links' => 'شبکه های اجتماعی',
			'grade' => 'سطح تحصیلات',
			'tell' => 'شماره تماس',
			'address' => 'آدرس',
			'fullName' => 'نام کامل'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('name',$this->fullNameFilter,true,'OR');
		$criteria->compare('family',$this->fullNameFilter,true,'OR');
		$criteria->compare('post',$this->post,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('tell',$this->tell,true);
		$criteria->order = 'id DESC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Personnel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getFullName(){
		return $this->name.' '.$this->family;
	}
}
