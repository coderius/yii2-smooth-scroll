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
    
    /**
     * Undocumented variable
     *
     * @var array
     */
    public $clientMethods = [];

    /**
     * Undocumented variable
     *
     * @var array
     */
    public $clientEvents = [];

    /**
     * Undocumented variable
     *
     * @var boolean
     */
    public $beginClientJs = false;

    /**
     * Undocumented variable
     *
     * @var boolean
     */
    public $endClientJs = false;

    /**
     * Undocumented variable
     *
     * @var [type]
     */
    public $selector;

    /**
     * Undocumented variable
     *
     * @var string
     */
    private $scrollVarName = 'scroll';

    /**
     * Undocumented variable
     *
     * @var string
     */
    private $pluginName = 'SmoothScroll';

    /**
     * Undocumented function
     *
     * @return void
     */
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
        // \yii\helpers\Json::htmlEncode($var)
        $js[] = $this->registerBeginClientJs();
        $js[] = $this->registerClientObject();
        $js[] = $this->registerClientMethods();
        $js[] = $this->registerEndClientJs();
        $js[] = $this->registerClientEvents();

       $view->registerJs(implode("\n", array_filter($js)));
    }

    private function registerClientObject()
    {
        $options = Json::encode($this->clientOptions);
        $script = "var $this->scrollVarName = new SmoothScroll('$this->selector', $options);";
        return $script;
    }    

    /**
     * Undocumented function
     *
     * @return void
     */
    private function registerClientMethods()
    {
        $allowMethods = [
            'animateScroll', 
            'cancelScroll', 
            'destroy'
        ];

        $script = "";

        if(!empty($this->clientMethods)){
            foreach($this->clientMethods as $method => $value){
                if(!in_array($method, $allowMethods)){
                    throw new InvalidConfigException("Method $method cannot be allowed.");
                }

                switch ($method) {
                    case 'animateScroll' :
                        $script .= $this->animateScrollSmoothScroll($value);
                    break;

                    case 'cancelScroll' :
                        $script .= $this->cancelScrollSmoothScroll($value);
                    break;

                    case 'destroy' :
                        $script .= $this->destroySmoothScroll($value);
                    break;
                }
            }
        }

        return $script;
    }
    
    /**
     * Undocumented function
     *
     * @param [array|null] $value
     * @return void
     */
    private function animateScrollSmoothScroll($value)
    {
        $allowParams = [
            'anchor' => false,
            'toggle' => false,
            'options' => false,
        ];

        $script = "";

        if(!is_array($value)){
            throw new InvalidParamException("Invalid Parameter in ". __METHOD__ ." 'value' should be an array");
        }

        if(!empty($value)){
            foreach($value as $param => $data){
                if(!array_key_exists($param, $allowParams)){
                    throw new InvalidConfigException("This param '$param' not supported.");
                }
            }
            $args= array_filter(array_merge($allowParams, $value));

            $script .= "$this->scrollVarName.animateScroll(";
            $script .= implode(",", $args);
            $script .= ");";
            
            return $script;
        }
        
        return null;
        
    }

    /**
     * Undocumented function
     *
     * @param [type] $value
     * @return boolean
     */
    private function cancelScrollSmoothScroll($value)
    {
        if (is_bool($value) === false) {
            throw new InvalidParamException("Invalid Parameter 'value' in ". __METHOD__ ." Allowed only boolean type");
        }

        return $value ? "$this->scrollVarName.cancelScroll();" : "";
    }

    /**
     * Undocumented function
     *
     * @param [type] $value
     * @return void
     */
    private function destroySmoothScroll($value)
    {
        if (is_bool($value) === false) {
            throw new InvalidParamException("Invalid Parameter 'value' in ". __METHOD__ ." Allowed only boolean type");
        }

        return $value ? "$this->scrollVarName.destroy();" : "";
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    private function registerClientEvents()
    {
        $allowEvents = [
            'scrollStart', 
            'scrollStop', 
            'scrollCancel'
        ];

        $script = "";

        if(!empty($this->clientEvents)){
            foreach($this->clientEvents as $event => $params){
                if(!in_array($event, $allowEvents)){
                    throw new InvalidConfigException("Event $event cannot be allowed.");
                }

                $args = implode(",", $params);

                $script .= "document.addEventListener('$event', $args);";
                    
            }
        }

        return $script;
    }
    
    /**
     * Undocumented function
     *
     * @return void
     */
    private function registerBeginClientJs()
    {
        $js = false;
        if ($this->beginClientJs instanceof Closure) {
            $js = call_user_func($this->beginClientJs, $this);
        } 
        return $js;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    private function registerEndClientJs()
    {
        $js = false;
        if ($this->endClientJs instanceof Closure) {
            $js = call_user_func($this->endClientJs, $this);
        } 
        return $js;
    }
    
    /**
     * Get the value of scrollVarName
     */ 
    public function getScrollVarName()
    {
        return $this->scrollVarName;
    }

    /**
     * Get the value of pluginName
     */ 
    public function getPluginName()
    {
        return $this->pluginName;
    }
}