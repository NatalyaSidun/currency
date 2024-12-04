<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap.css',
        'css/animate.css',
        'css/font-awesome.min.css',
        'css/simple-line-icons.css',
        'css/font.css',
        'css/app.css',
        'css/font-awesome/css/font-awesome.css',
        'js/fancybox/source/jquery.fancybox.css?v=2.1.5',
        'js/animo.js/animate-animo.min.css',
        'js/formstyler/jquery.formstyler.css',
        'js/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
        'js/jquery-ui/jquery-ui.min.css',
        'css/site.css'
    ];
    public $js = [
        'js/jquery.min.js',
        'js/bootstrap.js',
        'js/highcharts/highcharts.js',
        'js/animo.js/animo.min.js',
        'js/fancybox/source/jquery.fancybox.pack.js?v=2.1.5',
        'js/formstyler/jquery.formstyler.min.js',
        'js/moment/min/moment.min.js',
        'js/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
        'js/jquery-ui/jquery-ui.min.js',
        'js/main.js',

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}