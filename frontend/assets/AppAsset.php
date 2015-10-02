<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/frontend/assets';
    public $css = [
        'css/site.css',
        //'css/demo.css',
        'css/icon.css',
        'css/default/easyui.css',
        'css/xeditable.css',
        'css/flexyLayout.css',
        'css/defaultTheme.css',
        'css/styles.css',
    ];
    public $js = [
        //'js/angular/jquery.dataTables.js',
        //'js/angular/dataTables.fixedColumns.js',
        //'js/fixedtable.js',
        'js/easy_ui/jquery.easyui.min.js',
        'js/easy_ui/datagrid-groupview.js',
        'js/easy_ui/datagrid-filter.js',
        'js/jquery.fixedheadertable.js',
        'js/angular/angular.min.js',
        //'js/angular/angular-touch.js', // para el frozen
        //'js/angular/ui-grid.js', // para el frozen
        'js/angular/ui-bootstrap-tpls-0.13.0.min.js',
        'js/angular/i18n/angular-locale_es-mx.js',
        'js/angular/ng-table-master/dist/ng-table.js',
        'js/angular/ngDraggable.js',
        'js/angular/angular-mocks.js',
        'js/jquery.stickytableheaders.js',
        'js/angular.modules.js',
        'js/angular.produccion_acero.js',
        'js/angular.produccion.js',
        //'js/angular.tratamientos.js',
        //'js/angular.tratamientos.js',
        'js/angular.pruebas.js',
        'js/angular.almas.programacion.js',
        'js/angular.programacion.js',
        'js/angular.calidad.js',
        'js/angular/flexy-layout.min.js',
        'js/angular/Block.js',
        'js/angular/Directives.js',
        'js/script.js',
        'js/angular/MediatorController.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}