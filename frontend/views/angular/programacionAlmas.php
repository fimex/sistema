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
    <div id="programacion" class="scrollable" style="height: <?php if($IdSubProceso != 3): ?>310<?php else:?>550<?php endif;?>px;">
        <table ng-table class="table table-condensed table-bordered table-striped">
            <thead>
                <tr>
                    <?php if($IdSubProceso != 3): ?>
                    <th>Pr</th>
                    <?php endif;?>
                    <th>Alma</th>
                    <?php if($IdSubProceso != 3): ?>
                    <th>Pzas/hrs</th>
                    <th>Prog</th>
                    <th>Hrs</th>
                    <th>H</th>
                    <th>Faltan</th>
                    <th>Maquina</th>
                    <?php endif;?>
                </tr>
            </thead>
            <tbody>
                <tr
                    ng-class="{'info': indexProgramacion == $index,'success':(programacion.Programadas - programacion.Llenadas)<=0}"
                    ng-repeat="programacion in programaciones"
                    ng-click="selectProgramacion($index);"
                >
                    <?php if($IdSubProceso != 3): ?>
                    <th>{{programacion.Prioridad}}</th>
                    <?php endif;?>
                    <th>{{programacion.Producto}}/{{programacion.Alma}}</th>
                    <?php if($IdSubProceso != 3): ?>
                    <th>{{programacion.TiempoLlenado  | currency:"":0}}</th>
                    <th>{{programacion.Programadas}}</th>
                    <th>{{programacion.Programadas / programacion.TiempoLlenado | currency:"":1}}</th>
                    <th>{{programacion.Hechas}}</th>
                    <th>{{programacion.Programadas - programacion.Hechas}}</th>
                    <th>{{programacion.Identificador}}</th>
                    <?php endif;?>
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
