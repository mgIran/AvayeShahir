<?php

/**
 * This is the model class for table "{{courses}}".
 *
 * The followings are the available columns in table '{{courses}}':
 * @property string $id
 * @property string $title
 * @property string $pic
 * @property string $summary
 * @property string $order
 *
 * The followings are the available model relations:
 * @property Classes[] $classes
 * @property ClassCategories[] $categories
 */
class Courses extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{courses}}';
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
						'translated_attributes' => array('title','summary'),
						'admin_routes' => array('courses/manage/admin', 'courses/manage/update', 'courses/manage/create'),
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
			array('title, pic, summary', 'required'),
			array('pic', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('title, pic, summary', 'safe', 'on'=>'search'),
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
			'classes' => array(self::HAS_MANY, 'Classes', 'course_id','order'=>'id DESC'),
			'categories' => array(self::HAS_MANY, 'ClassCategories', 'course_id','order'=>'id DESC'),
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
			'pic' => 'تصویر',
			'summary' => 'توضیحات',
			'order' => 'ترتیب',
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
		$criteria->compare('pic',$this->pic,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('summary',$this->summary,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Courses the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
