<?php

/**
 * This is the model class for table "{{class_category_files}}".
 *
 * The followings are the available columns in table '{{class_category_files}}':
 * @property string $id
 * @property string $title
 * @property string $path
 * @property string $image
 * @property string $file_type
 * @property string $summary
 * @property string $category_id
 * @property string $order
 *
 * The followings are the available model relations:
 * @property ClassCategories $category
 */
class ClassCategoryFiles extends SortableCActiveRecord
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
		return '{{class_category_files}}';
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
				'admin_routes' => array('courses/files/create','courses/files/update','courses/files/admin','courses/files/delete','courses/categories/update'),
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
			array('path,category_id', 'required'),
			array('title', 'length', 'max'=>255),
			array('file_type', 'length', 'max'=>50),
			array('path, image', 'length', 'max'=>500),
			array('category_id', 'length', 'max'=>10),
			//array('file_type', 'checkFileType'),
			array('summary', 'safe'),
			array('title, summary', 'filter', 'filter'=>'strip_tags'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, category_id', 'safe'),
		);
	}

	public function checkFileType($attribute)
	{
		if (!in_array($this->$attribute,$this->_types))
			$this->addError($attribute, 'نوع فایل مورد نظر مجاز نیست.');
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'category' => array(self::BELONGS_TO, 'ClassCategories', 'category_id'),
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
			'title_en' => 'عنوان انگلیسی',
			'summary' => 'توضیحات',
			'summary_en' => 'توضیحات انگلیسی',
			'path' => 'فایل',
			'image' => 'تصویر',
			'file_type' => 'نوع فایل',
			'category_id' => 'گروه',
			'order' => 'ترتیب',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ClassCategoryFiles the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getTypes(){
		return array_map(function($v){ return '.'.$v; },$this->_types);
	}

	public static function getSearchCriteria($text, $words){
		$criteria = new CDbCriteria();
		$condition = 't.title LIKE :text';
//		$condition .= ' OR t.summary LIKE :text';
		$criteria->params['text'] = "%{$text}%";
        if($words && is_array($words)) {
            foreach ($words as $key => $word) {
                $condition .= " OR t.title LIKE :text$key";
//			$condition .= " OR t.summary LIKE :text$key";
                $criteria->params["text$key"] = "%{$word}%";
            }
            $criteria->addCondition($condition);
        }
//		$criteria->addCondition('deleted = 0');
		$criteria->order = 't.order';
		return $criteria;
	}
}
