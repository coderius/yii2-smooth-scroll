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

class SmoothScroll extends Widget
{
   /**
     * @var array the options for the Smooth Scroll JS plugin.
     * Please refer to the Smooth Scroll JS plugin Web page for possible options.
     * @see https://github.com/cferdinandi/smooth-scroll
     */
    public $clientOptions = [];
    
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
        var_dump($this->getId());
    }
}