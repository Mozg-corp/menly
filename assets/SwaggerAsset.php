<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Class SwaggerAsset
 *
 * @package yii2mod\swagger
 */
class SwaggerAsset extends AssetBundle
{
    /**
     * @var string the directory that contains the source asset files for this asset bundle
     */
    public $sourcePath = '@webroot/swagger-ui';

    /**
     * @var array list of JavaScript files that this bundle contains
     */
    public $js = [
        'swagger-ui-bundle.js',
        'swagger-ui-standalone-preset.js',
    ];

    /**
     * @var array list of CSS files that this bundle contains
     */
    public $css = [
        'swagger-ui.css',
    ];
}