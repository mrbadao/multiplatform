<?php
class CodeMirrorExtendsion extends CApplicationComponent
{
    private $basePath;

    function init()
    {
        $this->basePath = sprintf("%s/plugin/codemirror/", Yii::app()->request->getBaseUrl(true));
    }

    public function import()
    {
        Yii::app()->clientScript
            ->registerCssFile($this->basePath. 'lib/codemirror.css')
//            ->registerCssFile($this->basePath. 'theme/eclipse.css')
            ->registerScriptFile($this->basePath. 'lib/codemirror.js', CClientScript::POS_END)
//            ->registerScriptFile($this->basePath. 'addon/edit/matchbrackets.js', CClientScript::POS_END)
//            ->registerScriptFile($this->basePath. 'htmlmixed/htmlmixed.js', CClientScript::POS_END)
//            ->registerScriptFile($this->basePath. 'xml/xml.js', CClientScript::POS_END)
//            ->registerScriptFile($this->basePath. 'javascript/javascript.js', CClientScript::POS_END)
//            ->registerScriptFile($this->basePath. 'css/css.js', CClientScript::POS_END)
//            ->registerScriptFile($this->basePath. 'clike/clike.js', CClientScript::POS_END)
            ->registerScriptFile($this->basePath. 'mode/php/php.js', CClientScript::POS_END)
            ->registerScriptFile($this->basePath. 'config.js', CClientScript::POS_END);
    }
}
