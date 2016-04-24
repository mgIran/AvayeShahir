<?php

/**
 * This is the model class for table "ym_user_details".
 *
 * The followings are the available columns in table 'ym_user_details':
 * @property string $user_id
 * @property string $name
 * @property string $family
 * @property string $web_url
 * @property string $national_code
 * @property string $phone
 * @property string $zip_code
 * @property string $address
 *
 * The followings are the available model relations:
 * @property Users $user
 */
class UserDetails extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user_details}}';
	}

	/* @todo if project is multi language active __set & behavior functions ,otherwise remove it
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
						'translated_attributes' => array('name','family'),
						// @todo Please add admin actions
						'admin_routes' => array('users/manage/create',
												'users/manage/update',
												'users/manage/admin'),
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
			array('user_id', 'required', 'on' => 'insert'),
			array('name, family, national_code, phone, zip_code, address', 'required', 'on' => 'update'),
			array('national_code, phone, zip_code', 'numerical'),
			array('user_id, national_code, zip_code', 'length', 'max'=>10 , 'on' => 'update'),
			array('national_code, zip_code', 'length', 'min'=>10 , 'on' => 'update'),
			array('phone', 'length', 'min'=>11 , 'on' => 'update'),
			array('name, family', 'length', 'max'=>50),
			array('web_url', 'length', 'max'=>255),
			array('phone', 'length', 'max'=>11),
			array('address', 'length', 'max'=>1000),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, name,family, web_url, web_url, national_code, phone, zip_code, address', 'safe', 'on'=>'search'),
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
			'user_id' => 'کاربر',
			'name' => 'نام فارسی',
			'family' => 'نام خانوادگی',
			'web_url' => 'آدرس سایت فارسی',
			'national_code' => 'کد ملی',
			'phone' => 'تلفن',
			'zip_code' => 'کد پستی',
			'address' => 'نشانی دقیق پستی',
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

		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('name',$this->fa_name,true);
		$criteria->compare('family',$this->en_name,true);
		$criteria->compare('web_url',$this->fa_web_url,true);
		$criteria->compare('national_code',$this->national_code,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('zip_code',$this->zip_code,true);
		$criteria->compare('address',$this->address,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserDetails the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
