Smooth Scroll js plugin widget for Yii2
=======================================
The Smooth Scroll widget is a customized Smooth Scroll script based on [Smooth Scroll](https://github.com/cferdinandi/smooth-scroll) and represents a lightweight script to animate scrolling to anchor links in web page.


Installation
------------
The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require coderius/yii2-smooth-scroll "@dev"
```
or
```
composer require coderius/yii2-smooth-scroll "@dev"
```

or add

```json
"coderius/yii2-smooth-scroll" : "@dev"
```

to the require section of your application's `composer.json` file.

Basic usage.
------------
* In view include widget:

By default selector 'a[href*="#"]' passed in for the anchor links that should be animated.

```php
<?php echo coderius\smoothScroll\SmoothScroll::widget([]); ?>
```
And set html link and anchor to scroll:
```html
<a href="#your-anchor-name">tuc</a>
...
<div id="your-anchor-name"></div>

```

Advansed usage.
---------------
```php
<?php 
    echo coderius\smoothScroll\SmoothScroll::widget([
        // 'selector' => false,
        'clientOptions' => [
            'speed' => '1500',
            'speedAsDuration' => true,
            'easing' => 'easeInQuint',
            'customEasing' => new \yii\web\JsExpression(
                'function (time) {
                    return time < 0.5 ? 2 * time * time : -1 + (4 - 2 * time) * time;
                }'
            ),
            'clip' => true,
            // History
            'updateURL' => true, // Update the URL on scroll
	        'popstate' => true, // Animate scrolling with the forward/backward browser buttons (requires updateURL to be true)
            // Custom Events
	        'emitEvents' => true // Emit custom events
        ],
        'clientMethods' => [
            // Animate scrolling to an anchor.
            'animateScroll' => [
                'anchor' => "document.querySelector('#tuc')",// numbel (y-position to scroll) or dom element
                // 'toggle' => 700,
                'options' => "{ speed: 1500, easing: 'easeOutCubic' }",
            ],
            'cancelScroll' => false,
            'destroy' => false,
        ],
        'beginClientJs' => function($self){
            $script = "var logScrollEvent = function (event) {

                // The event type
                console.log('type:', event.type);
            
                // The anchor element being scrolled to
                console.log('anchor:', event.detail.anchor);
            
                // The anchor link that triggered the scroll
                console.log('toggle:', event.detail.toggle);
            
            };";

            return $script;
        },
        'endClientJs' => function($self){
            $script = "console.log(" . $self->getScrollVarName() . ")";

            return $script;
        },
        'clientEvents' => [
            'scrollStart' => ['logScrollEvent', false],
            'scrollStop' => ['logScrollEvent', false],
            'scrollCancel' => ['logScrollEvent', false],
        ],
    ]); 
?>
```


Reference to js plugin and more settings find in [github](https://github.com/cferdinandi/smooth-scroll) author repository that is used in this widget.