<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\URL;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\programacion\ProgramacionesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $title;
?>
<style>
    .filter{
        width: 100px;
        height: 22px;
        font-size: 10pt;
    }
    th, td{
        text-align: center;
    }
    .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td{
        padding: 4px;
    }
    h3{
        margin: 0;
    }
    #scrollable-area {
        margin: auto;
        height: 700px;
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
    .success2{
        background-color: lightgreen;
    }
</style>
<h4 style="margin-top:0;"><?=$title?></h4>
<div ng-controller="ProgramacionAlmas" ng-init="IdArea=<?=$area?>;loadDias();">
    <b style="font-size: 14pt;">Programacion Diaria</b>  <input type="week" ng-model="semanaActual" ng-change="loadDias();" />
    <button class="btn btn-success" ng-click="loadProgramacionDiaria();">Actualizar</button>
    <button class="btn btn-primary" ng-show="!mostrar" ng-click="mostrar = true">Mostrar Datos</button>
<button class="btn btn-primary" ng-show="mostrar" ng-click="mostrar = false">Ocultar Datos</button>
    <div class="panel panel-default">
        <div class="panel-body">
        </div>
        <div id="scrollable-area">
        <table ng-table fixed-table-headers="scrollable-area" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th rowspan="2">Alma</th>
                    <th rowspan="2">Pr</th>
                    <th rowspan="2">Prog</th>
                    <th rowspan="2">Total Prog</th>
                    <th rowspan="2">H</th>
                    <th colspan="5" ng-repeat="dia in dias">{{dia}}</th>
                </tr>
                    <?php for($x=1;$x<=6;$x++):?>
                    <th style="width: 100px;">Maq</th>
                    <th style="width: 100px;">Proceso</th>
                    <th>Prg</th>
                    <th>H</th>
                    <th style="width: 33px;">F</th>
                    <?php endfor;?>
                </tr>
            </thead>
            <tbody style="font-size: 10pt">
                <tr ng-repeat="programacion in programaciones" ng-click="setSelected(programacion);">
                    <th ng-class="{info: (programacion.TotalProgramado*1) > (programacion.Programadas*1)}">{{programacion.Producto}}/{{programacion.Alma}}</th>
                    <th ng-class="{info: (programacion.TotalProgramado*1) > (programacion.Programadas*1)}" ng-show="mostrar" style="width: 33px;">{{programacion.Prioridad}}</th>
                    <th ng-class="{success: programacion.TotalProgramado >= programacion.Programadas, danger: programacion.TotalProgramado == 0, warning: programacion.TotalProgramado < programacion.Programadas}">{{programacion.Programadas}}</th>
                    <th ng-class="{success: programacion.TotalProgramado >= programacion.Programadas, danger: programacion.TotalProgramado == 0, warning: programacion.TotalProgramado < programacion.Programadas}">{{programacion.TotalProgramado | currency :"":0}}</th>
                    <th ng-class="{success: programacion.Hechas >= programacion.Programadas, danger: programacion.Hechas == 0, warning: programacion.Hechas < programacion.Programadas}">{{programacion.Hechas}}</th>

                <?php for($x=1;$x<=6;$x++):?>
                    <td><select class="form-control" style="min-width: 100px; font-size: 9pt;" ng-model-options="{updateOn: 'blur'}" ng-change="saveProgramacionDiaria(<?=$x?>);" ng-model="programacion.Maquina<?=$x?>">
                        <option ng-selected="programacion.Maquina<?=$x?> == maquina.IdMaquina" value="{{maquina.IdMaquina}}" ng-repeat="maquina in maquinas">{{maquina.ClaveMaquina}}</option>
                    </select></td>
                    <td><select class="form-control" style="min-width: 100px; font-size: 9pt;" ng-model-options="{updateOn: 'blur'}" ng-change="saveProgramacionDiaria(<?=$x?>);" ng-model="programacion.Centro<?=$x?>">
                        <option ng-selected="programacion.Centro<?=$x?> == centro.IdCentroTrabajo" value="{{centro.IdCentroTrabajo}}" ng-repeat="centro in centros">{{centro.Descripcion}}</option>
                    </select></td>
                    <td><input class="form-control" class="filter" style="min-width: 80px; font-size: 9pt;" ng-model-options="{updateOn: 'blur'}" ng-change="saveProgramacionDiaria(<?=$x?>);" ng-model="programacion.Programadas<?=$x?>" value="{{programacion.Programadas<?=$x?>}}"></td>
                    <td style="min-width: 50px; font-size: 9pt;">{{programacion.Hechas<?=$x?>}}</td>
                    <td style="min-width: 50px; font-size: 9pt;">{{programacion.Programadas<?=$x?> - programacion.Hechas<?=$x?>}}</td>
                <?php endfor; ?>
                </tr>
            </tbody>
        </table>
        </div>
    </div>
</div>