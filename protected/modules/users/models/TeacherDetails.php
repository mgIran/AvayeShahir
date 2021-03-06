<?php

/**
 * This is the model class for table "{{teacher_details}}".
 *
 * The followings are the available columns in table '{{teacher_details}}':
 * @property string $user_id
 * @property string $avatar
 * @property string $name
 * @property string $family
 * @property string $grade
 * @property string $resume
 * @property string $social_links
 * @property string $tell
 * @property string $address
 * @property string $file
 */
class TeacherDetails extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{teacher_details}}';
	}

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
				'EasyMultiLanguage'=>array(
						'class' => 'ext.EasyMultiLanguage.EasyMultiLanguageBehavior',
						// @todo Please change those attributes that should be translated.
						'translated_attributes' => array('name','family','grade','resume','address'),
						'admin_routes' => array('users/teacherDetails/update'),
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
			array('user_id', 'required' ,'on' => 'create'),
			array('user_id, name, family', 'required' ,'on' => 'update'),
			array('user_id', 'length', 'max'=>10),
			array('avatar', 'length', 'max'=>500),
			array('name, family', 'length', 'max'=>50),
			array('grade', 'length', 'max'=>100),
			array('social_links', 'length', 'max'=>2000),
			array('tell', 'length', 'max'=>11),
			array('resume, address, file', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, avatar, name, family, grade, resume, social_links, tell, address', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'name' => 'نام',
			'family' => 'نام خانوادگی',
			'grade' => 'سطح تحصیلات',
			'avatar' => 'آواتار',
			'resume' => 'رزومه',
			'file' => 'فایل رزومه',
			'social_links' => 'لینک های اجتماعی',
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
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->compare('name',$this->name,true);
		$criteria->compare('family',$this->family,true);
		$criteria->compare('grade',$this->grade,true);
		$criteria->compare('tell',$this->tell,true);
		$criteria->compare('address',$this->address,true);
		$criteria->order = 'id DESC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TeacherDetails the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getFullName(){
		return $this->name.' '.$this->family;
	}
}
