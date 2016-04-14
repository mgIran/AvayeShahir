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
			array('id, name, family, post, avatar, resume, email, social_links, grade', 'safe', 'on'=>'search'),
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('family',$this->family,true);
		$criteria->compare('post',$this->post,true);
		$criteria->compare('avatar',$this->avatar,true);
		$criteria->compare('resume',$this->resume,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('social_links',$this->social_links,true);
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
	 * @return Personnel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
