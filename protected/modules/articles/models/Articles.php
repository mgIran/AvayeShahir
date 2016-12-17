<?php

/**
 * This is the model class for table "{{articles}}".
 *
 * The followings are the available columns in table '{{articles}}':
 * @property string $id
 * @property string $title
 * @property string $summary
 * @property string $image
 * @property string $create_date
 * @property string $publish_date
 * @property string $seen
 * @property string $status
 * @property string $category_id
 * @property string $order
 *
 * The followings are the available model relations:
 * @property ArticleFileLinks[] $links
 * @property ArticleLinks[] $extlinks
 * @property ArticleFiles[] $files
 * @property ArticleCategories $category
 * @property ClassTags[] $tags
 */
class Articles extends SortableCActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{articles}}';
	}
	
	public $formTags=[];
	public $statusLabels=[
		'draft' => 'پیش نویس',
		'publish' => 'انتشار یافته'
	];

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

	public function __set($name ,$value)
	{
		if(EMHelper::WinnieThePooh($name ,$this->behaviors()))
			$this->{$name} = $value;
		else
			parent::__set($name ,$value);
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
				'class' => 'ext.EasyMultiLanguage.EasyMultiLanguageBehavior' ,
				// @todo Please change those attributes that should be translated.
				'translated_attributes' => array('title' ,'summary') ,
				'admin_routes' => array('articles/manage/admin' ,'articles/manage/update' ,'articles/manage/delete' ,'articles/manage/create') ,
				//
				'languages' => Yii::app()->params['languages'] ,
				'default_language' => Yii::app()->params['default_language'] ,
				'translations_table' => 'ym_translations' ,
			) ,
		);
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		$purifier  = new CHtmlPurifier();
		$purifier->setOptions(array(
			'HTML.Allowed'=> 'p,a,b,i,br,img',
			'HTML.AllowedAttributes'=> 'style,id,class,src,a.href',
		));
		return array(
			array('title, category_id, summary', 'required'),
			array('title', 'length', 'max'=>100),
			array('image, publish_date', 'length', 'max'=>255),
			array('create_date', 'length', 'max'=>20),
			array('seen', 'length', 'max'=>11),
			array('status', 'length', 'max'=>7),
			array('category_id, order', 'length', 'max'=>10),
			array('title' ,'filter' ,'filter' => 'strip_tags') ,
			array('summary' ,'filter' ,'filter' => array($purifier ,'purify')) ,
			array('create_date, publish_date, formTags', 'safe'),
			array('create_date', 'default' , 'value' => time()),
			array('seen', 'default' , 'value' => 0),
			array('summary', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, summary, image, create_date, publish_date, seen, status, category_id, order', 'safe', 'on'=>'search'),
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
			'extlinks' => array(self::HAS_MANY, 'ArticleLinks', 'article_id','order' => 'extlinks.order'),
			'links' => array(self::HAS_MANY, 'ArticleFileLinks', 'article_id','order' => 'links.order'),
			'files' => array(self::HAS_MANY, 'ArticleFiles', 'article_id','order' => 'files.order'),
			'category' => array(self::BELONGS_TO, 'ArticleCategories', 'category_id'),
			'tags' => array(self::MANY_MANY ,'ClassTags' ,'{{article_tag_rel}}(article_id,tag_id)') ,
			'tagsRel' => array(self::HAS_MANY, 'ArticleTagRel', 'article_id'),
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
			'summary' => 'توضیح',
			'image' => 'تصویر',
			'create_date' => 'تاریخ ایجاد',
			'publish_date' => 'تاریخ انتشا',
			'seen' => 'بازدید',
			'status' => 'وضعیت',
			'category_id' => 'دسته بندی',
			'order' => 'Order',
			'formTags' => 'برچسب ها' ,
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
		$criteria->compare('image',$this->image,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('publish_date',$this->publish_date,true);
		$criteria->compare('seen',$this->seen,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('category_id',$this->category_id,true);
		$criteria->compare('order',$this->order,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Articles the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	protected function afterSave()
	{
		if($this->formTags && !empty($this->formTags)){
			if(!$this->isNewRecord)
				ArticleTagRel::model()->deleteAll('article_id=' . $this->id);
			foreach($this->formTags as $tag){
				$tagModel = ClassTags::model()->findByAttributes(array('title' => $tag));
				if($tagModel){
					$tag_rel = new ArticleTagRel();
					$tag_rel->article_id = $this->id;
					$tag_rel->tag_id = $tagModel->id;
					$tag_rel->save(false);
				}else{
					$tagModel = new ClassTags;
					$tagModel->title = $tag;
					$tagModel->save(false);
					$tag_rel = new ArticleTagRel();
					$tag_rel->article_id = $this->id;
					$tag_rel->tag_id = $tagModel->id;
					$tag_rel->save(false);
				}
			}
		}
		parent::afterSave();
	}

	public function getKeywords()
	{
		$tags = CHtml::listData($this->tags ,'title' ,'title');
		return implode(',' ,$tags);
	}

	public function getStatusLabel(){
		return $this->statusLabels[$this->status];
	}
	
	/**
	 * Get criteria for valid books
	 * @param array $categoryIds
	 * @param string $order
	 * @param null $limit
	 * @param string $alias
	 * @return CDbCriteria
	 */
	public static function getValidArticles($categoryIds = array(),$order = 't.order',$limit = null ,$alias = 't')
	{
		$criteria = new CDbCriteria();
		$criteria->addCondition($alias.'.'.'status=:status');
		$criteria->params[':status'] = 'publish';
		if($categoryIds)
			$criteria->addInCondition('category_id', $categoryIds);
		$criteria->order = $order;
		if($limit)
			$criteria->limit = $limit;
		return $criteria;
	}
}
