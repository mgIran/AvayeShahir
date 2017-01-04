<?php

/**
 * This is the model class for table "{{article_categories}}".
 *
 * The followings are the available columns in table '{{article_categories}}':
 * @property string $id
 * @property string $title
 * @property string $parent_id
 * @property string $path
 * @property string $order
 *
 * The followings are the available model relations:
 * @property Articles[] $articles
 * @property ArticleCategories $parent
 * @property ArticleCategories[] $childes
 */
class ArticleCategories extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{article_categories}}';
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
				'translated_attributes' => array('title') ,
				'admin_routes' => array('articles/category/admin' ,'articles/category/update' ,'articles/category/delete' ,'articles/category/create') ,
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
		return array(
			array('title' ,'length' ,'max' => 50) ,
			array('parent_id, order' ,'length' ,'max' => 10) ,
			array('path' ,'length' ,'max' => 255) ,
			array('title' ,'compareWithParent') ,
			array('parent_id' ,'checkParent') ,
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, parent_id, path, order' ,'safe' ,'on' => 'search') ,
		);
	}

	public function compareWithParent($attribute ,$params)
	{
		if(!empty($this->title) && $this->parent_id){
			$record = ArticleCategories::model()->findByAttributes(array('id' => $this->parent_id ,'title' => $this->title));
			if($record)
				$this->addError($attribute ,'عنوان دسته بندی با عنوان والد یکسان است.');
		}
	}

	public function checkParent($attribute ,$params)
	{
		if(!empty($this->parent_id) && $this->id){
			if($this->parent_id == $this->id)
				$this->addError($attribute ,'دسته بندی نمی تواند زیرمجموعه خودش باشد.');
		}
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'articles' => array(self::HAS_MANY ,'Articles' ,'category_id') ,
			'childes' => array(self::HAS_MANY ,'ArticleCategories' ,'parent_id') ,
			'parent' => array(self::BELONGS_TO ,'ArticleCategories' ,'parent_id') ,
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID' ,
			'title' => 'عنوان' ,
			'parent_id' => 'والد' ,
			'path' => 'Path' ,
			'order' => 'Order' ,
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

		$criteria->compare('id' ,$this->id ,true);
		$criteria->compare('title' ,$this->title ,true);
		$criteria->compare('parent_id' ,$this->parent_id ,true);
		$criteria->compare('path' ,$this->path ,true);
		$criteria->compare('order' ,$this->order ,true);

		return new CActiveDataProvider($this ,array(
			'criteria' => $criteria ,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ArticleCategories the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function sortList()
	{
		$parents = $this->findAll('parent_id IS NULL order by title');
		$list = array();
		foreach($parents as $parent){
			$childes = $this->findAll($this->getCategoryChildes($parent->id ,false ,'criteria'));
			foreach($childes as $child){
				array_push($list ,$child);
			}
		}
		return CHtml::listData($list ,'id' ,'fullTitle');
	}

	public function adminSortList($excludeId = NULL ,$withPrompt = true)
	{
		$parents = $this->findAll('parent_id IS NULL order by title');
		$list = array();
		foreach($parents as $parent){
			if($parent->id != $excludeId){
				array_push($list ,$parent);
				$childes = $this->findAll($this->getCategoryChildes($parent->id ,false ,'criteria'));
				foreach($childes as $child){
					if($child->id != $excludeId && $child->parent_id != $excludeId)
						array_push($list ,$child);
				}
			}
		}
		return $withPrompt ? CMap::mergeArray(array('' => '-') ,CHtml::listData($list ,'id' ,'fullTitle')) : CHtml::listData($list ,'id' ,'fullTitle');
	}

	public function getParents($id = NULL ,$title = 'fullTitle')
	{
		if($id)
			$parents = $this->findAll('parent_id = :id order by t.order' ,array(':id' => $id));
		else
			$parents = $this->findAll('parent_id IS NULL order by t.order');
		$list = array();
		foreach($parents as $parent){
			array_push($list ,$parent);
		}
		return CHtml::listData($list ,'id' ,$title);
	}

	public function getFullTitle()
	{
		$fullTitle = $this->title;
		$model = $this;
		while($model->parent){
			$model = $model->parent;
			if($model->parent)
				$fullTitle = $model->title . ' - ' . $fullTitle;
			else
				$fullTitle = $fullTitle . ' (' . $model->title . ')';
		}
		return $fullTitle;
	}

	public function beforeSave()
	{
		if(empty($this->parent_id))
			$this->parent_id = NULL;
		$this->path = null;
		return parent::beforeSave();
	}

	protected function afterSave()
	{
		$this->updatePath($this->id);
		parent::afterSave();
	}

	public function getCategoryChildes($id = null ,$withSelf = true ,$returnType = 'array', $fullTree = false)
	{
		if($id)
			$this->id = $id;
		$criteria = new CDbCriteria();
		if($fullTree) {
			$criteria->addCondition('path LIKE :regex1', 'OR');
			$criteria->addCondition('path LIKE :regex2', 'OR');
			$criteria->params[':regex1'] = $this->id.'-%';
			$criteria->params[':regex2'] = '%-'.$this->id.'-%';
		}else
		{
			$criteria->addCondition('parent_id = :parent');
			$criteria->params[':parent'] = $this->id;
		}

		if ($withSelf) {
			$criteria->addCondition('id  = :id', 'OR');
			$criteria->params[':id'] = $this->id;
		}
		if($returnType === 'array')
			return CHtml::listData($this->findAll($criteria) ,'id' ,'id');
		elseif($returnType === 'criteria')
			return $criteria;
	}

	/**
	 * Update Path field when model parent_id is changed
	 * @param $id
	 */
	private function updatePath($id)
	{
		/* @var $model ArticleCategories */
		$model = ArticleCategories::model()->findByPk($id);
		if($model->parent){
			$path = $model->parent->path ? $model->parent->path . $model->parent_id . '-' : $model->parent_id . '-';
			ArticleCategories::model()->updateByPk($model->id ,array('path' => $path));
		}
		foreach($model->childes as $child)
			$this->updatePath($child->id);
	}


	public static function getHtmlSortList($categoryID = null ,$activeID = Null)
	{
		foreach(ArticleCategories::model()->getParents($categoryID ,'title') as $id => $title){
			echo '<li class="' . ($activeID == $id ? 'active' : '') . '" ><a href="' . Yii::app()->createUrl('/articles/category/' . $id . '/' . urlencode($title)) . '" ><span>' . $title . '</span>&nbsp;&nbsp;<small>(' . ArticleCategories::model()->countArticles($id) . ')</small></a></li>';
			if(ArticleCategories::model()->count('parent_id = :id' ,array(':id' => $id))){
				echo '<ol>';
				self::getHtmlSortList($id ,$activeID);
				echo '</ol>';
			}
		}
	}

	public function countArticles($id = NULL)
	{
		$criteria = Articles::getValidArticles();
		$criteria->addInCondition('category_id' ,ArticleCategories::model()->getCategoryChildes($id));
		return Articles::model()->count($criteria);
	}	
}