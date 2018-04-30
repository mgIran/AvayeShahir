<?php

/**
 * This is the model class for table "{{article_links}}".
 *
 * The followings are the available columns in table '{{article_links}}':
 * @property string $id
 * @property string $article_id
 * @property string $title
 * @property string $summary
 * @property string $link
 * @property string $order
 *
 * The followings are the available model relations:
 * @property Articles $article
 */
class ArticleLinks extends SortableCActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{article_links}}';
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
				'admin_routes' => array('articles/extlinks/create','articles/extlinks/update','articles/extlinks/admin','articles/extlinks/delete','articles/manage/update'),
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
			array('article_id, title, link', 'required'),
			array('article_id, order', 'length', 'max'=>10),
			array('title', 'length', 'max'=>100),
			array('summary', 'length', 'max'=>500),
			array('link', 'length', 'max'=>255),
			array('title, summary', 'filter', 'filter'=>'strip_tags'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, article_id, title, summary, link, order', 'safe', 'on'=>'search'),
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
			'article_id' => 'Article',
			'title' => 'عنوان',
			'summary' => 'توضیح',
			'link' => 'لینک',
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
		$criteria->compare('article_id',$this->article_id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('summary',$this->summary,true);
		$criteria->compare('link',$this->link,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ArticleLinks the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function getSearchCriteria($text, $words){
		$criteria = new CDbCriteria();
		$condition = 't.title LIKE :text';
//		$condition .= ' OR t.summary LIKE :text';
		$criteria->params['text'] = "%{$text}%";
        if($words && is_array($words)) {
            foreach ($words as $key => $word) {
                $condition .= " OR t.title LIKE :text$key";
                //		$condition .= " OR t.summary LIKE :text$key";
                $criteria->params["text$key"] = "%{$word}%";
            }
        }
        $criteria->addCondition($condition);
//		$criteria->addCondition('deleted = 0');
		$criteria->order = 't.order';
		return $criteria;
	}
}
