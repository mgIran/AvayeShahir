<?php

/**
 * This is the model class for table "{{multimedia}}".
 *
 * The followings are the available columns in table '{{multimedia}}':
 * @property string $id
 * @property string $type
 * @property string $title
 * @property string $data
 * @property string $order
 * @property string $seen
 * @property string $thumbnail
 * @property string $description
 *
 * The followings are the available model relations:
 * @property ClassTags[] $tags
 */
class Multimedia extends SortableCActiveRecord
{
	const TYPE_PICTURE = 'picture';
	const TYPE_VIDEO = 'video';

	public $formTags = [];

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{multimedia}}';
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
				'translated_attributes' => array('title', 'description'),
				'admin_routes' => array('multimedia/videos/create', 'multimedia/videos/update', 'multimedia/videos/admin',
					'multimedia/pictures/create', 'multimedia/pictures/update', 'multimedia/pictures/admin'),
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
			array('type', 'required'),
			array('type', 'length', 'max' => 7),
			array('title', 'length', 'max' => 50),
			array('data', 'length', 'max' => 1000),
			array('thumbnail', 'length', 'max' => 255),
			array('order, seen', 'length', 'max' => 10),
			array('formTags, description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, type, title, data, order, seen', 'safe', 'on' => 'search'),
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
			'tags' => array(self::MANY_MANY, 'ClassTags', '{{multimedia_tag_rel}}(multimedia_id,tag_id)'),
			'tagsRel' => array(self::HAS_MANY, 'MultimediaTagRel', 'multimedia_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'type' => 'نوع',
			'title' => 'عنوان',
			'data' => 'محتوا',
			'order' => 'ترتیب',
			'seen' => 'تعداد بازدید',
			'thumbnail' => 'تصویر',
			'description' => 'توضیحات',
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
		$criteria->compare('type', $this->type, true);
		$criteria->compare('title', $this->title, true);
		$criteria->compare('data', $this->data, true);
		$criteria->compare('order', $this->order, true);
		$criteria->compare('seen', $this->seen, true);
		$criteria->compare('thumbnail', $this->thumbnail, true);

		$criteria->order = 't.order';

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Multimedia the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

    /**
     * @param string $type
     * @param int $limit
     * @param string $return
     * @return Multimedia[]|string
     */
	public static function getLatest($type = 'videos', $limit = 15, $return = 'html')
    {
        $criteria = new CDbCriteria();
        $criteria->compare('type', $type == 'videos'?Multimedia::TYPE_VIDEO:Multimedia::TYPE_PICTURE);
        $criteria->limit = $limit;
        $criteria->order = 'id DESC';
        if($return == 'html')
            foreach(Multimedia::model()->findAll($criteria) as $model)
                echo '<li><a href="' . Yii::app()->createUrl('/multimedia/' . $type . '/' . $model->id . '/' . urlencode($model->title)) . '" ><span>' . $model->title . '</span></a></li>';
        else{
            $out = array();
            foreach(Multimedia::model()->findAll($criteria) as $model)
                $out[] = $model;
            return $out;
        }
        return '';
    }

	protected function afterSave()
	{
		if($this->formTags && !empty($this->formTags)){
			if(!$this->isNewRecord)
				MultimediaTagRel::model()->deleteAll('multimedia_id=' . $this->id);
			foreach($this->formTags as $tag){
				$tagModel = ClassTags::model()->findByAttributes(array('title' => $tag));
				if($tagModel){
					$tag_rel = new MultimediaTagRel();
					$tag_rel->multimedia_id = $this->id;
					$tag_rel->tag_id = $tagModel->id;
					$tag_rel->save(false);
				}else{
					$tagModel = new ClassTags;
					$tagModel->title = $tag;
					$tagModel->save(false);
					$tag_rel = new MultimediaTagRel();
					$tag_rel->multimedia_id = $this->id;
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
}