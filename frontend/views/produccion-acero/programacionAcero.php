<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\URL;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\programacion\ProgramacionesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div style="width:350px; margin-right:6px" class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading">Programacion Semanal</div>
    <div class="panel-body">
    </div>
    <div id="programacion" class="scrollable">
        <table ng-table class="table table-condensed table-bordered table-striped">
            <thead>
                <tr>
                    <th style="width:40px">Prg</th>
                    <th style="width:80px">Producto</th>
                    <th style="width:20px">Faltan Llenada</th>
                    <th style="width:20px">Faltan Cerrada</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    ng-class="{'info': indexProgramacion == $index}"
                    ng-repeat="programacion in programaciones"
                    ng-click="selectProgramacion($index);"
                >
                    <th>{{programacion.Programadas}}</th>
                    <th>{{programacion.ProductoCasting}}</th>
                    <th>{{programacion.Programadas - programacion.Llenadas}}</th>
                    <th>{{programacion.Programadas - programacion.Cerradas}}</th>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="13">&nbsp;</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
