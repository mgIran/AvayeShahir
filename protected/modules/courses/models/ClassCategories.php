<?php

/**
 * This is the model class for table "{{class_categories}}".
 *
 * The followings are the available columns in table '{{class_categories}}':
 * @property string $id
 * @property string $title
 * @property string $course_id
 * @property string $summary
 * @property string $order
 * @property [] $formTags
 *
 * The followings are the available model relations:
 * @property Courses $course
 * @property Classes[] $classes
 * @property ClassCategoryFiles[] $files
 * @property ClassCategoryFileLinks[] $links
 * @property ClassTags[] $tags
 */
class ClassCategories extends SortableCActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{class_categories}}';
	}

	public $formTags=[];

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
						'admin_routes' => array('courses/categories/admin', 'courses/categories/update', 'courses/categories/delete', 'courses/categories/create'),
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
			array('formTags', 'safe'),
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
			'classes' => array(self::HAS_MANY, 'Classes', 'category_id', 'order'=>'classes.order'),
			'files' => array(self::HAS_MANY, 'ClassCategoryFiles', 'category_id' , 'order'=>'files.order'),
			'links' => array(self::HAS_MANY, 'ClassCategoryFileLinks', 'category_id' , 'order'=>'links.order'),
			'tags' => array(self::MANY_MANY, 'ClassTags', '{{category_tag_rel}}(category_id,tag_id)'),
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
			'course_id' => 'دوره موردنظر',
			'order' => 'ترتیب',
			'formTags' => 'برچسب ها',
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
		$criteria->compare('course_id', $this->course_id, true);
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

	public function getValidClasses(){
		$criteria = new CDbCriteria();
		$criteria = Classes::getValidClasses($this->course_id,$this->id);
		return Classes::model()->findAll($criteria);
	}


	protected function afterSave()
	{
		if($this->formTags && !empty($this->formTags)) {
			if(!$this->isNewRecord)
				CategoryTagRel::model()->deleteAll('category_id='.$this->id);
			foreach($this->formTags as $tag) {
				$tagModel = ClassTags::model()->findByAttributes(array('title' => $tag));
				if($tagModel) {
					$tag_rel = new CategoryTagRel();
					$tag_rel->category_id = $this->id;
					$tag_rel->tag_id = $tagModel->id;
					$tag_rel->save(false);
				} else {
					$tagModel = new ClassTags;
					$tagModel->title = $tag;
					$tagModel->save(false);
					$tag_rel = new CategoryTagRel();
					$tag_rel->category_id = $this->id;
					$tag_rel->tag_id = $tagModel->id;
					$tag_rel->save(false);
				}
			}
		}
		parent::afterSave();
	}

	public function getKeywords()
	{
		$tags = CHtml::listData($this->tags,'title','title');
		return implode(',',$tags);
	}
}
