<?php
/**
 * Created by PhpStorm.
 * User: Yusef-PC
 * Date: 12/10/2015
 * Time: 10:04 PM
 */

class tagIt extends CWidget
{
    /**
     * @var array of scripts and styles
     */
    private $_scripts;
    /**
     * @var string DropZone id
     */
    public $id = false;
    /**
     * @var string The name of the field
     */
    public $name = false;
    /**
     * @var CModel The model for the field
     */
    public $model = false;
    /**
     * @var string The attribute of the model
     */
    public $attribute = false;
    /**
     * @var array of suggest data
     */
    public $data = array();

    /**
     * @var array of suggest data
     */
    public $suggest = array();

    /**
     * init widget
     */
    public function init()
    {
        if(!$this->id)
            $this->id = rand(0, 100);

        Yii::app()->clientScript->registerCoreScript('jquery');
        $this->_scripts = array(
            'css'.DIRECTORY_SEPARATOR.'jquery.tagit.css',
            'css'.DIRECTORY_SEPARATOR.'tagit.ui-zendesk.css',
            'js'.DIRECTORY_SEPARATOR.'tag-it.min.css'
        );
        return parent::init();
    }

    /**
     * the appropriate Javascripts
     */
    protected function registerClientScript()
    {
        Yii::app()->clientScript->registerCoreScript('jquery');
        Yii::app()->clientScript->registerCoreScript('jquery.ui');
        $cs = Yii::app()->clientScript;
        foreach($this->_scripts as $script) {
            $file = Yii::getPathOfAlias('ext.tagIt.assets').DIRECTORY_SEPARATOR.$script;
            $type = explode(DIRECTORY_SEPARATOR, $script);
            if($type[0] === 'css')
                $cs->registerCssFile(Yii::app()->getAssetManager()->publish($file));
            else if($type[0] === 'js')
                $cs->registerScriptFile(Yii::app()->getAssetManager()->publish($file));
        }
        // assign hidden field name
        if($this->model && $this->attribute) {
            $this->name = CHtml::activeName($this->model, $this->attribute);
        } else if($this->model && !$this->attribute && $this->name)
            $this->name = CHtml::activeName($this->model, $this->name);
        else if(!$this->model && $this->attribute)
            $this->name = $this->attribute;

        $script = '';
        $cs->registerScript('tagIt-'.$this->id, '
            $("#tagIt-'.$this->id.'").tagit();
        ');
    }

    public function run()
    {
        $this->registerClientScript();
    }
}