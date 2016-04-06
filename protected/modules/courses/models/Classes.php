<?php

/**
 * This is the model class for table "{{classes}}".
 *
 * The followings are the available columns in table '{{classes}}':
 * @property string $id
 * @property string $title
 * @property string $summary
 * @property integer $price
 * @property string $startSignupDate
 * @property string $endSignupDate
 * @property string $startClassDate
 * @property string $endClassDate
 * @property string $category_id
 * @property string $course_id
 *
 * The followings are the available model relations:
 * @property Courses $course
 * @property ClassCategories $category
 */
class Classes extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{classes}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, category_id, course_id', 'required'),
			array('endSignupDate','compare','compareAttribute'=>'startSignupDate','operator'=>'>','message'=>'تاریخ پایان ثبت نام باید بیشتر از تاریخ شروع ثبت نام باشد.'),
			array('endClassDate','compare','compareAttribute'=>'startClassDate','operator'=>'>','message'=>'تاریخ پایان کلاس باید بیشتر از تاریخ شروع کلاس باشد.'),
			array('price', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>50),
			array('category_id, course_id', 'length', 'max'=>10),
			array('summary, startSignupDate, endSignupDate, startClassDate, endClassDate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, summary, price, startSignupDate, endSignupDate, startClassDate, endClassDate, category_id, course_id', 'safe', 'on'=>'search'),
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
			'course' => array(self::BELONGS_TO, 'Courses', 'course_id'),
			'category' => array(self::BELONGS_TO, 'ClassCategories', 'category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'عنوان',
			'summary' => 'توضیحات',
			'price' => 'شهریه',
			'startSignupDate' => 'تاریخ شروع ثبت نام',
			'endSignupDate' => 'تاریخ پایان ثبت نام',
			'startClassDate' => 'تاریخ شروع کلاس',
			'endClassDate' => 'تاریخ پایان کلاس',
			'category_id' => 'گروه',
			'course_id' => 'دوره',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('summary',$this->summary,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('startSignupDate',$this->startSignupDate,true);
		$criteria->compare('endSignupDate',$this->endSignupDate,true);
		$criteria->compare('startClassDate',$this->startClassDate,true);
		$criteria->compare('endClassDate',$this->endClassDate,true);
		$criteria->compare('category_id',$this->category_id,true);
		//var_dump($this->course_id);exit;
		$criteria->compare('course_id',$this->course_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Classes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
