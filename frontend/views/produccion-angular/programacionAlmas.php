<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\URL;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\programacion\ProgramacionesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading">Programacion del dia</div>
    <div class="panel-body">
    </div>
    <div id="programacion" class="scrollable">
        <table ng-table class="table table-condensed table-bordered table-striped">
            <thead>
                <tr>
                    <th>Pr</th>
                    <th>Alma</th>
                    <th>Prog</th>
                    <th>H</th>
                    <th>Faltan</th>
                    <th>Maquina</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    ng-class="{'info': indexProgramacion == $index,'success':(programacion.Programadas - programacion.Llenadas)<=0}"
                    ng-repeat="programacion in programaciones"
                    ng-click="selectProgramacion($index);"
                >
                    <th>{{programacion.Prioridad}}</th>
                    <th>{{programacion.Producto}}/{{programacion.Alma}}</th>
                    <th>{{programacion.Programadas}}</th>
                    <th>{{programacion.Hechas}}</th>
                    <th>{{programacion.Programadas - programacion.Hechas}}</th>
                    <th>{{programacion.Identificador}}</th>
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
