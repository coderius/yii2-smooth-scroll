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

or add

```json
"coderius/yii2-smooth-scroll" : "@dev"
```

to the require section of your application's `composer.json` file.

Basic usage.
------------
* In view include widget:

By default 'a[href*="#"]' passing in a selector for the anchor links that should be animated.

```php
<?php echo coderius\smoothScroll\SmoothScroll::widget([]); ?>
```
And set html link and anchor to scroll:
```html
<a href="#your-anchor-name">tuc</a>
...
<div id="your-anchor-name"></div>

```

Reference to js plugin and more settings find in [github](https://github.com/cferdinandi/smooth-scroll)author repository that is used in this widget.