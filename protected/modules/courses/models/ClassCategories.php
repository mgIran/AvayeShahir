<?php

/**
 * This is the model class for table "{{class_categories}}".
 *
 * The followings are the available columns in table '{{class_categories}}':
 * @property string $id
 * @property string $title
 * @property string $course_id
 * @property string $summary
 *
 * The followings are the available model relations:
 * @property Courses $course
 * @property Classes[] $classes
 * @property ClassCategoryFiles[] $files
 * @property ClassCategoryFileLinks[] $links
 */
class ClassCategories extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{class_categories}}';
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
						'admin_routes' => array('courses/categories/admin', 'courses/categories/update', 'courses/categories/create'),
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
			array('title ,course_id','required'),
			array('title','unique'),
		  	array('title', 'length', 'max'=>255),
			array('summary ,course_id' , 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title ,summary', 'safe', 'on'=>'search'),
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
			'classes' => array(self::HAS_MANY, 'Classes', 'category_id', 'order'=>'id DESC'),
			'files' => array(self::HAS_MANY, 'ClassCategoryFiles', 'category_id' , 'order'=>'id DESC'),
			'links' => array(self::HAS_MANY, 'ClassCategoryFileLinks', 'category_id' , 'order'=>'id DESC'),
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
			'course_id' => 'دوره موردنظر'
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
		$criteria->order = 'id DESC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ClassCategories the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
