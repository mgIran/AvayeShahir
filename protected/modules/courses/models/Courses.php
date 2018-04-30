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
 * @property string $seen
 * @property string $deleted
 * @property [] $formTags
 *
 * The followings are the available model relations:
 * @property Classes[] $classes
 * @property ClassCategories[] $categories
 * @property ClassTags[] $tags
 */
class Courses extends SortableCActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{courses}}';
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
                'admin_routes' => array('courses/manage/admin', 'courses/manage/update', 'courses/manage/create', 'courses/manage/delete'),
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
            'HTML.AllowedAttributes' => 'style,id,class,src,a.href,dir',
        ));
        return array(
            array('title, pic, summary', 'required'),
            array('title', 'filter', 'filter' => 'strip_tags'),
            array('summary', 'filter', 'filter' => array($purifier, 'purify')),
            array('pic', 'length', 'max' => 200),
            array('seen, deleted', 'default', 'value' => 0),
            array('formTags, deleted', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('title, pic, summary, deleted', 'safe', 'on' => 'search'),
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
            'classes' => array(self::HAS_MANY, 'Classes', 'course_id', 'order' => 'classes.order'),
            'categories' => array(self::HAS_MANY, 'ClassCategories', 'course_id', 'order' => 'categories.order'),
            'tags' => array(self::MANY_MANY, 'ClassTags', '{{course_tag_rel}}(course_id,tag_id)'),
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('pic', $this->pic, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('summary', $this->summary, true);
        $criteria->compare('deleted', $this->deleted);
        $criteria->order = 't.order';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Courses the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    protected function afterSave()
    {
        if($this->scenario != 'delete' && $this->formTags && !empty($this->formTags)){
            if(!$this->IsNewRecord)
                CourseTagRel::model()->deleteAll('course_id=' . $this->id);
            foreach($this->formTags as $tag){
                $tagModel = ClassTags::model()->findByAttributes(array('title' => $tag));
                if($tagModel){
                    $tag_rel = new CourseTagRel();
                    $tag_rel->course_id = $this->id;
                    $tag_rel->tag_id = $tagModel->id;
                    $tag_rel->save(false);
                }else{
                    $tagModel = new ClassTags;
                    $tagModel->title = $tag;
                    $tagModel->save(false);
                    $tag_rel = new CourseTagRel();
                    $tag_rel->course_id = $this->id;
                    $tag_rel->tag_id = $tagModel->id;
                    $tag_rel->save(false);
                }
            }
        }
        parent::afterSave();
    }

    public function getKeywords()
    {
        $tags = CHtml::listData($this->tags, 'title', 'title');
        return implode(',', $tags);
    }

    public function getCategoriesKeywords()
    {
        $allTags = array();
        foreach($this->categories as $category){
            $tags = CHtml::listData($category->tags, 'title', 'title');
            if($tags)
                $allTags = CMap::mergeArray($allTags, $tags);
        }
        return implode(',', $allTags);
    }

    public static function getHtmlSortList()
    {
        foreach(CHtml::listData(Courses::model()->findAll('deleted = 0'), 'id', 'title') as $id => $title){
            echo '<li><a href="' . Yii::app()->createUrl('/courses/' . $id . '/' . urlencode($title)) . '" ><span>' . $title . '</span></a></li>';
        }
    }

    public static function getSearchCriteria($text, $words, $withFiles = false, $withLinks = false)
    {
        $criteria = new CDbCriteria();
        $criteria->with = array('categories');
        $condition = 't.title LIKE :text OR t.summary LIKE :text OR categories.title LIKE :text OR categories.summary LIKE :text';
        if($withLinks)
        {
            $condition .= ' OR links.title LIKE :text OR links.summary LIKE :text';
            $criteria->with[] = 'categories.links';
        }
        if($withFiles)
        {
            $condition .= ' OR files.title LIKE :text OR files.summary LIKE :text';
            $criteria->with[] = 'categories.files';
        }
        $criteria->params['text'] = "%{$text}%";
        if($words && is_array($words)) {
            foreach ($words as $key => $word) {
                $condition .= " OR t.title LIKE :text$key OR t.summary LIKE :text$key OR categories.title LIKE :text$key OR categories.summary LIKE :text$key";
                if ($withLinks)
                    $condition .= " OR links.title LIKE :text$key OR links.summary LIKE :text$key";
                if ($withFiles)
                    $condition .= " OR files.title LIKE :text$key OR files.summary LIKE :text$key";
                $criteria->params["text$key"] = "%{$word}%";
            }
        }
        $criteria->addCondition($condition);
        $criteria->together = true;
        $criteria->addCondition('deleted = 0');
        $criteria->order = 't.order';
        return $criteria;
    }

    public function scopes()
    {
        return array(
            'sitemap' => self::getQuery(),
        );
    }

    /**
     * @return CDbCriteria
     */
    public static function getQuery()
    {
        $criteria = new CDbCriteria();
        $criteria->addCondition('t.deleted = 0');
        $criteria->order = 't.order';
        return $criteria;
    }
}