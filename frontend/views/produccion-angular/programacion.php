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
                    <th>Producto</th>
                    <th>Prog</th>
                    <th>Mold</th>
                    <th>Vac</th>
                    <th>Faltan</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    ng-class="{'info': indexProgramacion == $index,'success':(programacion.Programadas - programacion.Llenadas)<=0}"
                    ng-repeat="programacion in programaciones"
                    ng-click="selectProgramacion($index);"
                >
                    <th>{{programacion.Prioridad}}</th>
                    <th>{{programacion.ProductoCasting}}</th>
                    <th>{{programacion.Programadas}}</th>
                    <th>{{programacion.Llenadas}}</th>
                    <?php if($IdSubProceso == 6 || $IdSubProceso == 7): ?>
                    <th>{{programacion.Programadas - programacion.Llenadas}}</th>
                    <?php endif; ?>
                    <?php if($IdSubProceso == 10): ?>
                    <th>{{programacion.Llenadas}}</th>
                    <th>{{programacion.Vaciadas}}</th>
                    <th>{{programacion.Llenadas - programacion.Vaciadas}}</th>
                    <?php endif; ?>
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
