<?php

/**
 * @package yii2-extentions
 * @license BSD-3-Clause
 * @copyright Copyright (C) 2012-2019 Sergio coderius <coderius>
 * @contacts sunrise4fun@gmail.com - Have suggestions, contact me :) 
 * @link https://github.com/coderius - My github
 */
namespace coderius\smoothScroll;

use yii\base\Widget;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use Closure;
use yii\base\InvalidConfigException;
use yii\base\InvalidParamException;

class SmoothScroll extends Widget
{
   /**
     * @var array the options for the Smooth Scroll JS plugin.
     * Please refer to the Smooth Scroll JS plugin Web page for possible options.
     * @see https://github.com/cferdinandi/smooth-scroll
     */
    public $clientOptions = [];
    
    public $clientMethods = [];

    public $selector;

    private $scrollVarName = 'scroll';

    private $pluginName = 'SmoothScroll';

    public function init()
    {
        parent::init();

        if ($this->selector === null) {
            $this->selector = 'a[href*="#"]';
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->registerClientScript();
    }

    /**
     * Registers Smooth Scroll js plugin
     */
    protected function registerClientScript()
    {
        $js = [];
        $view = $this->getView();
        SmoothScrollAsset::register($view);
        // var_dump($this->getId());
        $options = Json::encode($this->clientOptions);
        
        // \yii\helpers\Json::htmlEncode($var)
        $js[] = "var $this->scrollVarName = new SmoothScroll('$this->selector', $options);";
        
        $view->registerJs(implode("\n", $js));

        $this->registerClientMethods();
        
    }

    protected function registerClientMethods()
    {
        $allowMethods = [
            'animateScroll', 
            'cancelScroll', 
            'destroy'
        ];

        if(!empty($this->clientMethods)){
            foreach($this->clientMethods as $method => $value){
                if(!in_array($method, $allowMethods)){
                    throw new InvalidConfigException("Method $method cannot be allowed.");
                }

                switch ($method) {
                    case 'animateScroll' :
                        $this->animateScrollSmoothScroll($value);
                    break;

                    case 'cancelScroll' :
                        $this->cancelScrollSmoothScroll($value);
                    break;

                    case 'destroy' :
                       $this->destroySmoothScroll($value);
                    break;
                }
            }
        }
        return;
    }
    
    private function animateScrollSmoothScroll($value)
    {
        $allowParams = [
            'anchor',
            'toggle',
            'options',
        ];

        if(!is_array($value)){
            throw new InvalidParamException("Invalid Parameter in ". __METHOD__ ." 'value' should be an array");
        }

        if(!empty($value)){
            foreach($value as $param => $data){
                if(!in_array($param, $allowParams)){
                    throw new InvalidConfigException("Param cannot be allowed.");
                }
            }
            extract($value);
            return "$this->scrollVarName.animateScroll($anchor, $toggle, $options);";
        }
        
        return;
        
    }

    private function cancelScrollSmoothScroll($value)
    {
        if (is_bool($value) === false) {
            throw new InvalidParamException("Invalid Parameter 'value' in ". __METHOD__ ." Allowed only boolean type");
        }

        return $value ? "$this->scrollVarName.cancelScroll();" : "";
    }

    private function destroySmoothScroll($value)
    {
        if (is_bool($value) === false) {
            throw new InvalidParamException("Invalid Parameter 'value' in ". __METHOD__ ." Allowed only boolean type");
        }

        return $value ? "$this->scrollVarName.destroy();" : "";
    }

}