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
        height: 750px;
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
    .cap{
        background-color: rgb(142,187,245);
    }
    .par{
        background-color: #E6EDD7;
    }
    .impar{
        background-color: #A4D5E2;
    }
</style>
<div ng-controller="Programacion" ng-init="loadDias();">
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
                    <th rowspan="2">Producto<br /><input style="width: 70px;" class="filter" ng-model="filtro.Producto" /></th>
                    <th rowspan="2">Casting<br /><input style="width: 70px;" class="filter" ng-model="filtro.Casting" /></th>
                    <th ng-show="mostrar" rowspan="2">Embarque<br /><input style="width: 60px;" class="filter" ng-model="filtro.Embarque" /></th>
                    <th ng-show="mostrar" rowspan="2" ng-click="orden = orden == '+Aleacion' ? '-Aleacion' : '+Aleacion'">Aleacion<span class="glyphicon glyphicon glyphicon-triangle-bottom"></span><br /><input style="width: 60px;" class="filter" ng-model="filtro.Aleacion" /></th>
                    <th ng-show="mostrar" rowspan="2" ng-click="orden = orden == '+Marca' ? '-Marca' : '+Marca'">Cliente<span class="glyphicon glyphicon glyphicon-triangle-top"></span><br /><input style="width: 60px;" class="filter" ng-model="filtro.Cliente" /></th>
                    <th ng-show="mostrar" rowspan="2">Pr<br /><input style="width: 33px;" class="filter" ng-model="filtro.Pr" /></th>
                    <th rowspan="2">Mold</th>
                    <th rowspan="2">Prog</th>
                    <th rowspan="2">H</th>
                    <th class="cap" colspan="<?= $area == 2 ? 6 : 5?>" ng-repeat="dia in dias">{{dia}}</th>
                </tr>
                    <?php for($x=1;$x<=6;$x++):?>
                    <?php $class = $x % 2 != 0 ?'par' : 'impar'; ?>
                    <th class="cap" style="width: 100px;">Maq</th>
                    <th class="cap">Prg</th>
                    <th class="<?=$class?>"><?= $area == 2 ? 'L' : 'Mol'?></th>
                    <?= $area == 2 ? "<th class='$class'>C</th>" : ''?>
                    <th class="<?=$class?>"><?= $area == 2 ? 'V' : 'Vac'?></th>
                    <th class="<?=$class?>" style="width: 33px;">F</th>
                    <?php endfor;?>
                </tr>
            </thead>
            <tbody style="font-size: 10pt">
                <tr ng-repeat="programacion in programaciones | filter:{
                Producto:filtro.Producto,
                ProductoCasting:filtro.Casting,
                FechaEmbarque:filtro.Embarque,
                Aleacion:filtro.Aleacion,
                Marca:filtro.Cliente,
                Prioridad:filtro.Pr,
            } | orderBy:orden" ng-click="setSelected(programacion);" ng-class="{info:selected.IdProgramacionSemana == programacion.IdProgramacionSemana}">
                    <th ng-class="{info: (programacion.TotalProgramado*1) > (programacion.Programadas*1)}">{{programacion.Producto}}</th>
                    <th ng-class="{info: (programacion.TotalProgramado*1) > (programacion.Programadas*1)}">{{programacion.ProductoCasting}}</th>
                    <th ng-class="{info: (programacion.TotalProgramado*1) > (programacion.Programadas*1)}" ng-show="mostrar">{{programacion.FechaEmbarque | date:'dd-MM-yy'}}</th>
                    <th ng-class="{info: (programacion.TotalProgramado*1) > (programacion.Programadas*1)}" ng-show="mostrar">{{programacion.Aleacion}}</th>
                    <th ng-class="{info: (programacion.TotalProgramado*1) > (programacion.Programadas*1)}" ng-show="mostrar">{{programacion.Marca}}</th>
                    <th ng-class="{info: (programacion.TotalProgramado*1) > (programacion.Programadas*1)}" ng-show="mostrar" style="width: 33px;">{{programacion.Prioridad}}</th>
                    <th ng-class="{success: programacion.TotalProgramado >= programacion.Programadas, danger: programacion.TotalProgramado == 0, warning: programacion.TotalProgramado < programacion.Programadas}">{{programacion.Programadas}}</th>
                    <th ng-class="{success: programacion.TotalProgramado >= programacion.Programadas, danger: programacion.TotalProgramado == 0, warning: programacion.TotalProgramado < programacion.Programadas}">{{programacion.TotalProgramado | currency :"":0}}</th>
                    <th ng-class="{success: programacion.Hechas >= programacion.Programadas, danger: programacion.Hechas == 0, warning: programacion.Hechas < programacion.Programadas}">{{programacion.Hechas}}</th>

                <?php for($x=1;$x<=6;$x++):?>
                    <?php $class = $x % 2 != 0 ?'par' : 'impar'; ?>
                    <td class="cap"><select ng-model-options="{updateOn: 'blur'}" ng-change="saveProgramacionDiaria(<?=$x?>);" ng-model="programacion.Maquina<?=$x?>">
                        <option ng-selected="programacion.Maquina<?=$x?> == maquina.IdMaquina" value="{{maquina.IdMaquina}}" ng-repeat="maquina in maquinas">{{maquina.ClaveMaquina}}</option>
                    </select></td>
                    <td class="cap"><input disabled="" class="filter" style="width: 33px; font-size: 9pt;" ng-model-options="{updateOn: 'blur'}" ng-change="saveProgramacionDiaria(<?=$x?>);" ng-model="programacion.Programadas<?=$x?>" value="{{programacion.Programadas<?=$x?>}}"></td>
                    <td class="<?=$class?>">{{programacion.Llenadas<?=$x?>}}</td>
                    <td class="<?=$class?>">{{programacion.Vaciadas<?=$x?>}}</td>
                    <td class="<?=$class?>">{{programacion.Programadas<?=$x?> - programacion.Llenadas<?=$x?>}}</td>
                <?php endfor; ?>
                </tr>
            </tbody>
        </table>
        </div>
    </div>
    <table class="table table-striped table-bordered table-hover" style="width: 100%;">
        <tfoot>
            <tr>
                <th rowspan="2">Resumen</th>
                <th colspan="5" class="info"><input type="week" ng-model="semanaActual" ng-disabled="true" /></th>
                <th colspan="5" ng-class="{'par':$index % 2 == 0, 'impar':$index % 2 != 0}" ng-repeat="dia in dias">{{dia}}</th>
            </tr>
            <tr>
                <th class="info">Mol</th>
                <th class="info">Pzas</th>
                <th class="info">Ton P</th>
                <th class="info">Ton A</th>
                <th class="info">Hrs</th>
                <?php for($x=0;$x<6;$x++):?>
                <?php $class = $x % 2 == 0 ?'par' : 'impar'; ?>
                <th class="<?=$class?>">Mol</th>
                <th class="<?=$class?>">Pzas</th>
                <th class="<?=$class?>">Ton P</th>
                <th class="<?=$class?>">Ton A</th>
                <th class="<?=$class?>">Hrs</th>
                <?php endfor;?>

            </tr>
            <tr ng-repeat="resumen in resumenes">
                <?php 
                    $Prioridad ='';
                    $Maquina ='';
                    $Hechas ='';
                    $Programadas ='';
                    $Horas ='';
                ?>
                <th>{{resumen.PiezasMolde}}</th>
                <td class="info">{{semanal[$index].Prioridad1 | currency:'':0}}{{resumen.PiezasMolde == '% PROD' ? '%' : ''}}</td>
                <td class="info">{{semanal[$index].Maquina1 | currency:'':0}}{{resumen.PiezasMolde == '% PROD' ? '%' : ''}}</td>
                <td class="info">{{semanal[$index].Hechas1 | currency:'':resumen.PiezasMolde == '% PROD' ?0:2}}{{resumen.PiezasMolde == '% PROD' ? '%' : ''}}</td>
                <td class="info">{{semanal[$index].Programadas1 | currency:'':resumen.PiezasMolde == '% PROD' ?0:2}}{{resumen.PiezasMolde == '% PROD' ? '%' : ''}}</td>
                <td class="info">{{semanal[$index].Horas1 | currency:'':0}}{{resumen.PiezasMolde == '% PROD' ? '%' : ''}}</td>
                <?php for($x=1;$x<=6;$x++):?>
                <?php $class = $x % 2 != 0 ?'par' : 'impar'; ?>
                <td class="<?=$class?>">{{resumen.Prioridad<?=$x?> | currency:'':0}}{{resumen.PiezasMolde == '% PROD' ? '%' : ''}}</td>
                <td class="<?=$class?>">{{resumen.Maquina<?=$x?> | currency:'':0}}{{resumen.PiezasMolde == '% PROD' ? '%' : ''}}</td>
                <td class="<?=$class?>">{{resumen.Hechas<?=$x?> / 1000 | currency:'':2}}{{resumen.PiezasMolde == '% PROD' ? '%' : ''}}</td>
                <td class="<?=$class?>">{{resumen.Programadas<?=$x?> / 1000 | currency:'':2}}{{resumen.PiezasMolde == '% PROD' ? '%' : ''}}</td>
                <td class="<?=$class?>">{{resumen.Horas<?=$x?> | currency:'':1}}{{resumen.PiezasMolde == '% PROD' ? '%' : ''}}</td>
                <?php endfor;?>
            </tr>
        </tfoot>
        </table>
        </div>