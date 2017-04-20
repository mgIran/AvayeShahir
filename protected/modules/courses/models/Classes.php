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
 * @property string $deleted
 * @property [] $formTags
 *
 * The followings are the available model relations:
 * @property Courses $course
 * @property ClassCategories $category
 * @property TeacherDetails $teacher
 * @property Users $teacherModels
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

    private $weekDays = array(
        'شنبه',
        'یکشنبه',
        'دوشنبه',
        'سه شنبه',
        'چهارشنبه',
        'پنجشنبه',
        'جمعه'
    );

    public $formTags = [];
    public $teachers = [];

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
        if(EMHelper::WinnieThePooh($name, $this->behaviors()))
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
        $purifier = new CHtmlPurifier();
        $purifier->setOptions(array(
            'HTML.Allowed' => 'p,a,b,i,br,img',
            'HTML.AllowedAttributes' => 'style,id,class,src,a.href',
        ));
        return array(
            array('title, category_id, course_id, capacity, teachers', 'required'),
            array('title', 'filter', 'filter' => 'strip_tags'),
            array('summary', 'filter', 'filter' => array($purifier, 'purify')),
            array('price, deleted', 'default', 'value' => 0),
            array('price, sessions, capacity', 'numerical', 'integerOnly' => true),
            array('endSignupDate', 'compare', 'compareAttribute' => 'startSignupDate', 'operator' => '>', 'message' => 'تاریخ پایان ثبت نام باید بیشتر از تاریخ شروع ثبت نام باشد.'),
            array('endClassDate', 'compare', 'compareAttribute' => 'startClassDate', 'operator' => '>', 'message' => 'تاریخ پایان کلاس باید بیشتر از تاریخ شروع کلاس باشد.'),
            array('title', 'length', 'max' => 50),
            array('category_id, course_id', 'length', 'max' => 10),
            array('teachers, formTags, status, summary, startSignupDate, endSignupDate, startClassDate, endClassDate,startClassTime,endClassTime,classDays', 'safe'),
            array('id, title, summary, price, startSignupDate, endSignupDate, startClassDate, endClassDate, category_id, course_id, deleted', 'safe', 'on' => 'search'),
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
            'teacherModels' => array(self::MANY_MANY, 'Users', '{{class_teacher_rel}}(class_id,teacher_id)'),
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
            'teachers' => 'اساتید',
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
        $criteria->compare('deleted', $this->deleted);
//		$criteria->order = 'order';
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
        $this->updateFormTags();
        $this->updateTeachers();
        parent::afterSave();
    }

    public function updateFormTags()
    {
        if($this->scenario != 'delete' && $this->formTags && !empty($this->formTags)){
            if(!$this->IsNewRecord)
                ClassTagRel::model()->deleteAll('class_id=' . $this->id);
            foreach($this->formTags as $tag){
                $tagModel = ClassTags::model()->findByAttributes(array('title' => $tag));
                if($tagModel){
                    $tag_rel = new ClassTagRel;
                    $tag_rel->class_id = $this->id;
                    $tag_rel->tag_id = $tagModel->id;
                    $tag_rel->save(false);
                }else{
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
    }

    public function updateTeachers()
    {
        if($this->scenario != 'delete' && $this->teachers && !empty($this->teachers)){
            if(!$this->isNewRecord)
                ClassTeacherRel::model()->deleteAll('class_id=' . $this->id);
            foreach($this->teachers as $teacherId){
                $teacherModel = Users::model()->findByAttributes(array('id' => $teacherId));
                if($teacherModel){
                    $teacher_rel = new ClassTeacherRel;
                    $teacher_rel->class_id = $this->id;
                    $teacher_rel->teacher_id = $teacherModel->id;
                    $teacher_rel->save(false);
                }
            }
        }
    }

    protected function beforeSave()
    {
        if($this->scenario != 'delete' && $this->classDays && !empty($this->classDays)){
            $this->classDays = array_filter($this->classDays, function ($v){
                if(in_array($v, $this->weekDays))
                    return $v;
            });
            $this->classDays = implode(',', $this->classDays);
        }
        return parent::beforeSave();
    }

    public static function getValidClasses($course_id = null, $category_id = null)
    {
        $criteria = new CDbCriteria();
        if($course_id)
            $criteria->compare('t.course_id', $course_id);
        if($category_id)
            $criteria->compare('t.category_id', $category_id);
        $criteria->addCondition('endSignupDate >= :now');
        $criteria->addCondition('t.status = 1');
        $criteria->addCondition('t.deleted = 0');
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
        if($this->price != 0)
            $html = Yii::app()->language == 'fa'?Controller::parseNumbers(number_format($this->price)) . '&nbsp;<span class="currency">' . Yii::t('app', "Toman") . '</span>':number_format($this->price) . '&nbsp;<span class="currency">' . Yii::t('app', "Toman") . '</span>';
        else
            $html = Yii::t('app', "Free");
        return $html;
    }

    public function getTeachersFullName(){
        $names = CHtml::listData($this->teacherModels,'id','teacherDetails.fullName');
        $sep = Yii::app()->language == 'fa'?'، ':', ';
        return implode($sep,$names);
    }
}