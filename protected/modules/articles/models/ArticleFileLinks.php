<?php

/**
 * This is the model class for table "{{article_file_links}}".
 *
 * The followings are the available columns in table '{{article_file_links}}':
 * @property string $id
 * @property string $title
 * @property string $summary
 * @property string $link
 * @property string $file_type
 * @property string $article_id
 * @property string $order
 * @property string $link_size
 * @property string $image
 *
 * The followings are the available model relations:
 * @property Articles $article
 */
class ArticleFileLinks extends SortableCActiveRecord
{
	private $_types = array(
		'jpeg','jpg','png','bmp','pdf',	'docx','doc','ppt','pptx','pps',
		'ppsx','xls','xlsx','mp4','mov','webm','avi','wmv','flv','mkv',
		'mp3','m4a','ogg','wav','acc','wma','rma','zip','rar',
		'apk'
	);

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{article_file_links}}';
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
				'translated_attributes' => array('title' ,'summary'),
				// @todo Please add admin actions
				'admin_routes' => array('articles/links/create','articles/links/update','articles/links/admin','articles/links/delete','articles/manage/update'),
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
			array('title, link, file_type, article_id', 'required'),
			array('title, image', 'length', 'max'=>255),
			array('link', 'length', 'max'=>500),
			array('file_type', 'length', 'max'=>50),
			array('article_id, order', 'length', 'max'=>10),
			array('link_size', 'length', 'max'=>15),
			array('title, summary, link_size', 'filter', 'filter'=>'strip_tags'),
			array('summary', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, summary, link, file_type, article_id, order, link_size, image', 'safe', 'on'=>'search'),
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
			'article' => array(self::BELONGS_TO, 'Articles', 'article_id'),
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
			'link' => 'لینک فایل',
			'file_type' => 'نوع فایل',
			'article_id' => 'گروه',
			'order' => 'ترتیب',
			'link_size' => 'حجم فایل',
			'image' => 'تصویر',
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
		$criteria->compare('link',$this->link,true);
		$criteria->compare('file_type',$this->file_type,true);
		$criteria->compare('article_id',$this->article_id,true);
		$criteria->compare('order',$this->order,true);
		$criteria->compare('link_size',$this->link_size,true);
		$criteria->compare('image',$this->image,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ArticleFileLinks the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getTypes(){
		$list = array();
		foreach($this->_types as $type)
			$list[$type] = $type;
		return $list;
	}
}
