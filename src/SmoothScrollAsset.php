<?php

/**
 * @package yii2-extentions
 * @license BSD-3-Clause
 * @copyright Copyright (C) 2012-2019 Sergio coderius <coderius>
 * @contacts sunrise4fun@gmail.com - Have suggestions, contact me :) 
 * @link https://github.com/coderius - My github
 */

namespace coderius\smoothScroll;

use Yii;
use yii\web\AssetBundle;
/**
 * Asset bundle SmoothScrollAsset
 */
class SmoothScrollAsset extends AssetBundle
{
    public $sourcePath = '@npm/smooth-scroll/dist';
    
    public $css = [];
    
    public $js = [];
    
    public $depends = [
        // 'yii\web\JqueryAsset',
    ];
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        $devJsAssets = [
            'smooth-scroll.min.js',
            'smooth-scroll.polyfills.min.js'
        ];
        $prodJsAssets = [
            'smooth-scroll.js',
            'smooth-scroll.polyfills.js'
        ];

        $this->js[] = YII_DEBUG ? $devJsAssets : $prodJsAssets;
        
    }
    
}

