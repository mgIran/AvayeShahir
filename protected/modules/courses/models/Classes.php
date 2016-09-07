<?php

/**
 * This is the model class for table "{{classes}}".
 *
 * The followings are the available columns in table '{{classes}}':
 * @property string $id
 * @property string $title
 * @property string $summary
 * @property integer $capacity
 * @property integer $price
 * @property string $startSignupDate
 * @property string $endSignupDate
 * @property string $startClassDate
 * @property string $endClassDate
 * @property string $classDays
 * @property string $category_id
 * @property string $course_id
 * @property string $teacher_id
 * @property string $order
 * @property string $sessions
 * @property string $startClassTime
 * @property string $endClassTime
 * @property string $status
 * @property string $remainingCapacity
 * @property string $titleWithCapacity
 * @property [] $formTags
 *
 * The followings are the available model relations:
 * @property Courses $course
 * @property ClassCategories $category
 * @property TeacherDetails $teacher
 * @property ClassTags[] $tags
 * @property UserTransactions[] $registers
 * @property UserTransactions[] $paidRegisters
 */
class Classes extends SortableCActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{classes}}';
	}

	public $formTags = [];

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
				'translated_attributes' => array('title', 'summary'),
				// @todo Please add admin actions
				'admin_routes' => array('courses/classes/create', 'courses/classes/update', 'courses/classes/delete', 'courses/classes/admin'),
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
			array('title, category_id, course_id ,capacity ,teacher_id', 'required'),
			array('price', 'default', 'value' => 0),
			array('price,sessions', 'numerical', 'integerOnly' => true),
			array('endSignupDate', 'compare', 'compareAttribute' => 'startSignupDate', 'operator' => '>', 'message' => 'تاریخ پایان ثبت نام باید بیشتر از تاریخ شروع ثبت نام باشد.'),
			array('endClassDate', 'compare', 'compareAttribute' => 'startClassDate', 'operator' => '>', 'message' => 'تاریخ پایان کلاس باید بیشتر از تاریخ شروع کلاس باشد.'),
			array('title', 'length', 'max' => 50),
			array('category_id, course_id', 'length', 'max' => 10),
			array('status, summary, startSignupDate, endSignupDate, startClassDate, endClassDate,startClassTime,endClassTime,classDays', 'safe'),
			array('id, title, summary, price, startSignupDate, endSignupDate, startClassDate, endClassDate, category_id, course_id', 'safe', 'on' => 'search'),
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
			'teacher' => array(self::BELONGS_TO, 'TeacherDetails', 'teacher_id'),
			'registers' => array(self::HAS_MANY, 'UserTransactions', 'class_id'),
			'paidRegisters' => array(self::HAS_MANY, 'UserTransactions', 'class_id', 'on' => 'paidRegisters.status = "paid" AND paidRegisters.date >= startSignupDate'),
			'tags' => array(self::MANY_MANY, 'ClassTags', '{{class_tag_rel}}(class_id,tag_id)'),
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
			'classDays' => 'روز های برگزاری کلاس',
			'startClassTime' => 'ساعت شروع کلاس',
			'endClassTime' => 'ساعت پایان کلاس',
			'category_id' => 'گروه',
			'course_id' => 'دوره',
			'teacher_id' => 'مدرس',
			'capacity' => 'ظرفیت کلاس',
			'formTags' => 'برچسب ها',
			'order' => 'ترتیب',
			'sessions' => 'تعداد جلسات',
			'status' => 'وضعیت',
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

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('title', $this->title, true);
		$criteria->compare('summary', $this->summary, true);
		$criteria->compare('price', $this->price);
		$criteria->compare('startSignupDate', $this->startSignupDate, true);
		$criteria->compare('endSignupDate', $this->endSignupDate, true);
		$criteria->compare('startClassDate', $this->startClassDate, true);
		$criteria->compare('endClassDate', $this->endClassDate, true);
		$criteria->compare('category_id', $this->category_id, true);
		$criteria->compare('course_id', $this->course_id, true);
		$criteria->compare('teacher_id', $this->teacher_id, true);
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Classes the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	protected function afterSave()
	{
		if ($this->formTags && !empty($this->formTags)) {
			if (!$this->IsNewRecord)
				ClassTagRel::model()->deleteAll('class_id=' . $this->id);
			foreach ($this->formTags as $tag) {
				$tagModel = ClassTags::model()->findByAttributes(array('title' => $tag));
				if ($tagModel) {
					$tag_rel = new ClassTagRel;
					$tag_rel->class_id = $this->id;
					$tag_rel->tag_id = $tagModel->id;
					$tag_rel->save(false);
				} else {
					$tagModel = new ClassTags;
					$tagModel->title = $tag;
					$tagModel->save(false);
					$tag_rel = new ClassTagRel;
					$tag_rel->class_id = $this->id;
					$tag_rel->tag_id = $tagModel->id;
					$tag_rel->save(false);
				}
			}
		}
		parent::afterSave();
	}

	protected function beforeSave()
	{
		if ($this->classDays && !empty($this->classDays)) {
			$this->classDays = array_filter($this->classDays, function ($v) {
				if (in_array($v, array(
					'شنبه',
					'یکشنبه',
					'دوشنبه',
					'سه شنبه',
					'چهارشنبه',
					'پنجشنبه',
					'جمعه'
				)))
					return $v;
			});
			$this->classDays = implode(',', $this->classDays);
		}
		return parent::beforeSave();
	}

	public static function getValidClasses()
	{
		$criteria = new CDbCriteria();
		$criteria->addCondition('endSignupDate >= :now');
		$criteria->addCondition('t.status = 1');
		$criteria->with[] = 'paidRegisters';
		$criteria->group = 't.id';
		$criteria->having = 'paidRegisters.user_id IS NULL OR COUNT(paidRegisters.user_id) < t.capacity';
		$criteria->params[':now'] = time();
		$criteria->order = 't.order';
		return $criteria;
	}

	public function getTitleWithCapacity()
	{
		return $this->title . ' (' . Yii::t('app', 'Remaining Capacity') . ': ' . $this->remainingCapacity . ')';
	}

	public function getRemainingCapacity()
	{
		$criteria = new CDbCriteria();
		$criteria->addCondition('status = "paid"');
		$criteria->addCondition('class_id = :c');
		$criteria->addCondition('date >= :date');
		$criteria->params[':c'] = $this->id;
		$criteria->params[':date'] = $this->startSignupDate;
		return abs(UserTransactions::model()->count($criteria) - $this->capacity);
	}

	/**
	 * Get html Price Tags
	 * @return string
	 */
	public function getHtmlPrice()
	{
		if ($this->price != 0)
			$html = Yii::app()->language == 'fa' ? Controller::parseNumbers(number_format($this->price)) . '&nbsp;<span class="currency">' . Yii::t('app', "Toman") . '</span>' : number_format($this->price) . '&nbsp;<span class="currency">' . Yii::t('app', "Toman") . '</span>';
		else
			$html = Yii::t('app', "Free");
		return $html;
	}
}
