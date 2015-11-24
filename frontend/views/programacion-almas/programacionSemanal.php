<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\programacion\ProgramacionesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $title;
?>
<style>
    .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
        padding: 0 8px;
    }
    .form-control, .filter{
        //width: 100px;
        height: 30px;
        font-size: 10pt;
    }
    th, td{
        text-align: center;
    }
    
    .success2{
        background-color: lightgreen;
    }
    
    .scrollable {
        margin: auto;
        height: 800px;
        border: 2px solid #ccc;
        overflow-y: scroll; /* <-- here is what is important*/
    }
    thead {
        background: white;
    }
    table {
        width: 100%;
        border-spacing:0;
        margin:0;
    }
    table th , table td  {
        border-left: 1px solid #ccc;
        border-top: 1px solid #ccc;
    }
    .par{
        background-color: #BFB2CF;
    }
    .par2{
        background-color: #DFDBE7;
    }
    .impar{
        background-color: #A4D5E2;
    }
    .impar2{
        background-color: #D1EAF0;
    }
</style>
<h4 style="margin-top:0;"><?=$title?></h4>
<div ng-controller="ProgramacionAlmas" ng-init="loadSemanas();selectAll=true">
    <input type="week" ng-model="semanaActual" ng-change="loadSemanas();" />
    <button class="btn btn-success" ng-click="loadProgramacionSemanal();">Actualizar</button>
    <button class="btn btn-primary" ng-show="!mostrar" ng-click="mostrar = true">Mostrar Datos</button>
    <button class="btn btn-primary" ng-show="mostrar" ng-click="mostrar = false">Ocultar Datos</button>
    <div class="panel panel-default">
        <div class="panel-body">
        </div>
        <div id="semanal" class="scrollable">
        <table ng-table fixed-table-headers="semanal" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th rowspan="3">Alma<br /><input class="form-control" ng-model="filtro.alma" /></th>
                    <th rowspan="3">Almas x Mold</th>
                    <th colspan="8">Requeridas</th>
                    <th rowspan="3">Existencia</th>
                    <th rowspan="3">xProg</th>
                    <?php for($x=1;$x<=4;$x++):?>
                    <th colspan="4" rowspan="2">Semana {{semanas.semana<?=$x?>.week}},{{semanas.semana<?=$x?>.year}}</th>
                    <?php endfor;?>
                </tr>
                <tr>
                    <?php for($x=1;$x<=4;$x++):?>
                    <th colspan="2">Semana {{semanas.semana<?=$x?>.week}},{{semanas.semana<?=$x?>.year}}</th>
                    <?php endfor;?>
                </tr>
                <tr>
                    <?php for($x=1;$x<=4;$x++):?>
                    <th>Mold</th>
                    <th>Cantidad</th>
                    <?php endfor;?>
                    <?php for($x=1;$x<=4;$x++):?>
                    <th>Pr</th>
                    <th>Prog</th>
                    <th>H</th>
                    <th>F</th>
                    <?php endfor;?>
                </tr>
            </thead>
            <tbody style="font-size: 10pt">
                <tr ng-repeat="programacion in programaciones | filter:{Producto: filtro.alma}" ng-click="setSelected(programacion);">
                    <td>{{programacion.Producto}}/{{programacion.Alma}}</td>
                    <td>{{programacion.PiezasMolde}}</td>
                    <td>{{programacion.Moldes1}}</td>
                    <td>{{programacion.Requeridas1}}</td>
                    <td>{{programacion.Moldes2}}</td>
                    <td>{{programacion.Requeridas2}}</td>
                    <td>{{programacion.Moldes3}}</td>
                    <td>{{programacion.Requeridas3}}</td>
                    <td>{{programacion.Moldes4}}</td>
                    <td>{{programacion.Requeridas4}}</td>
                    <td>{{programacion.Existencia}}</td>
                    <td>{{(programacion.Requeridas1 + programacion.Requeridas2 + programacion.Requeridas3) - programacion.Existencia}}</td>
                    <?php for($x=1;$x<=4;$x++):?>
                    <td style="min-width:80px"><input class="form-control" ng-model-options="{updateOn: 'blur'}" ng-change="saveProgramacionSemanal(<?=$x?>);" ng-model="programacion.Prioridad<?=$x?>" value="{{programacion.Prioridad<?=$x?>}}" /></td>
                    <td style="min-width:80px"><input class="form-control" ng-model-options="{updateOn: 'blur'}" ng-change="saveProgramacionSemanal(<?=$x?>);" ng-model="programacion.Programadas<?=$x?>" value="{{programacion.Programadas<?=$x?>}}" /></td>
                    <td style="width:80px"></td>
                    <td style="width:80px"></td>
                    <?php endfor;?>
                </tr>
            </tbody>
        </table>
        </div>
    </div>
</div>