<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\URL;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\programacion\ProgramacionesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $title;
$colspan = 2;
$colspan = $IdProceso == 1 && $IdArea == 2 ? 3 : $colspan;
$colspan = $IdProceso == 1 && $IdArea == 3 ? 3 : $colspan;
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
        height: 668px;
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
<h4 style="margin-top:0;"><?=$title?></h4>
<div ng-controller="Programacion" ng-init="filtro.Estatus = 'Abierto';IdArea=<?=$IdArea?>;Turno=1;IdProceso=<?=$IdProceso?>;IdSubProceso=<?=$IdProceso == 1 ? 6 : 12?>;loadDias();">
    <b style="font-size: 14pt;">Programacion Diaria: </b><input type="week" ng-model="semanaActual" ng-change="loadDias();" />
    <b style="font-size: 14pt;">Turno: </b><select ng-model="Turno" ng-change="loadDias();">
        <option ng-selected="Turno == 1" value="1">Dia</option>
        <option ng-selected="Turno == 3" value="3">Noche</option>
    </select>
    <button class="btn btn-success" ng-click="loadProgramacionDiaria();">Actualizar</button>
    Mostrar Pedidos: <select  ng-model="filtro.Estatus">
        <option value="">Todos</option>
        <option value="Abierto">Abiertos</option>
        <option value="Cerrado">Cerrados</option>
    </select>
    <div class="panel panel-default">
        <div class="panel-body">
        </div>
        <div id="opacidad" ng-show="isLoading"></div>
        <div class="animacionGiro" ng-show="isLoading"></div>
        <div id="scrollable-area">
        <table ng-table fixed-table-headers="scrollable-area" class="table table-striped table-bordered table-hover ">
            <thead>
                <tr>
                    <th rowspan="2">
                        Producto<br />
                        <span ng-click="orden('Producto',1)" class="seleccion glyphicon glyphicon-triangle-bottom" aria-hidden="true" ng-show="mostrarBoton('Producto',1);"></span>
                        <span ng-click="orden('Producto',2)" class="seleccion glyphicon glyphicon-triangle-top"aria-hidden="true" ng-show="mostrarBoton('Producto',2);"></span>
                        <span ng-click="orden('Producto',3)" class="seleccion glyphicon glyphicon-remove" aria-hidden="true" ng-show="mostrarBoton('Producto',3);"></span>
                        <input style="width: 70px;" class="filter" ng-model="filtro.Producto" />
                    </th>
                    <th rowspan="2">
                        Casting<br />
                        <span ng-click="orden('Casting',1)" class="seleccion glyphicon glyphicon-triangle-bottom" aria-hidden="true" ng-show="mostrarBoton('Casting',1);"></span>
                        <span ng-click="orden('Casting',2)" class="seleccion glyphicon glyphicon-triangle-top"aria-hidden="true" ng-show="mostrarBoton('Casting',2);"></span>
                        <span ng-click="orden('Casting',3)" class="seleccion glyphicon glyphicon-remove" aria-hidden="true" ng-show="mostrarBoton('Casting',3);"></span>
                        <input style="width: 70px;" class="filter" ng-model="filtro.Casting" />
                    </th>
                    <th  ng-show="IdProceso == 1">
                        Mold x Hrs<br />
                        <span ng-click="orden('MoldesHora',1)" class="seleccion glyphicon glyphicon-triangle-bottom" aria-hidden="true" ng-show="mostrarBoton('MoldesHora',1);"></span>
                        <span ng-click="orden('MoldesHora',2)" class="seleccion glyphicon glyphicon-triangle-top"aria-hidden="true" ng-show="mostrarBoton('MoldesHora',2);"></span>
                        <span ng-click="orden('MoldesHora',3)" class="seleccion glyphicon glyphicon-remove" aria-hidden="true" ng-show="mostrarBoton('MoldesHora',3);"></span>
                        <input style="width: 70px;" class="filter" ng-model="filtro.MoldesxHora" />
                    </th>
                    <th rowspan="2">
                        Embarque<br />
                        <span ng-click="orden('FechaEmbarque',1)" class="seleccion glyphicon glyphicon-triangle-bottom" aria-hidden="true" ng-show="mostrarBoton('FechaEmbarque',1);"></span>
                        <span ng-click="orden('FechaEmbarque',2)" class="seleccion glyphicon glyphicon-triangle-top"aria-hidden="true" ng-show="mostrarBoton('FechaEmbarque',2);"></span>
                        <span ng-click="orden('FechaEmbarque',3)" class="seleccion glyphicon glyphicon-remove" aria-hidden="true" ng-show="mostrarBoton('FechaEmbarque',3);"></span>
                        <input style="width: 60px;" class="filter" ng-model="filtro.Embarque" />
                    </th>
                    <th rowspan="2">
                        Aleacion<br />
                        <span ng-click="orden('Aleacion',1)" class="seleccion glyphicon glyphicon-triangle-bottom" aria-hidden="true" ng-show="mostrarBoton('Aleacion',1);"></span>
                        <span ng-click="orden('Aleacion',2)" class="seleccion glyphicon glyphicon-triangle-top"aria-hidden="true" ng-show="mostrarBoton('Aleacion',2);"></span>
                        <span ng-click="orden('Aleacion',3)" class="seleccion glyphicon glyphicon-remove" aria-hidden="true" ng-show="mostrarBoton('Aleacion',3);"></span>
                        <input style="width: 60px;" class="filter" ng-model="filtro.Aleacion" />
                    </th>
                    <th rowspan="2">
                        Cliente<br />
                        <span ng-click="orden('Marca',1)" class="seleccion glyphicon glyphicon-triangle-bottom" aria-hidden="true" ng-show="mostrarBoton('Marca',1);"></span>
                        <span ng-click="orden('Marca',2)" class="seleccion glyphicon glyphicon-triangle-top"aria-hidden="true" ng-show="mostrarBoton('Marca',2);"></span>
                        <span ng-click="orden('Marca',3)" class="seleccion glyphicon glyphicon-remove" aria-hidden="true" ng-show="mostrarBoton('Marca',3);"></span>
                        <input style="width: 60px;" class="filter" ng-model="filtro.Cliente" />
                    </th>
                    <th ng-show="mostrar" rowspan="2">
                        Pr<br />
                        <span ng-click="orden('Prioridad',1)" class="seleccion glyphicon glyphicon-triangle-bottom" aria-hidden="true" ng-show="mostrarBoton('Prioridad',1);"></span>
                        <span ng-click="orden('Prioridad',2)" class="seleccion glyphicon glyphicon-triangle-top"aria-hidden="true" ng-show="mostrarBoton('Prioridad',2);"></span>
                        <span ng-click="orden('Prioridad',3)" class="seleccion glyphicon glyphicon-remove" aria-hidden="true" ng-show="mostrarBoton('Prioridad',3);"></span>
                        <input style="width: 33px;" class="filter" ng-model="filtro.Pr" />
                    </th>
                    <th style="width: 33px" ng-show="IdProceso == 1">
                        Mold<br />
                        <span ng-click="orden('Programadas',1)" class="seleccion glyphicon glyphicon-triangle-bottom" aria-hidden="true" ng-show="mostrarBoton('Programadas',1);"></span>
                        <span ng-click="orden('Programadas',2)" class="seleccion glyphicon glyphicon-triangle-top"aria-hidden="true" ng-show="mostrarBoton('Programadas',2);"></span>
                        <span ng-click="orden('Programadas',3)" class="seleccion glyphicon glyphicon-remove" aria-hidden="true" ng-show="mostrarBoton('Programadas',3);"></span>
                    </th>
                    <th style="width: 33px">
                        Prog<br />
                        <span ng-click="orden('TotalProgramado',1)" class="seleccion glyphicon glyphicon-triangle-bottom" aria-hidden="true" ng-show="mostrarBoton('TotalProgramado',1);"></span>
                        <span ng-click="orden('TotalProgramado',2)" class="seleccion glyphicon glyphicon-triangle-top"aria-hidden="true" ng-show="mostrarBoton('TotalProgramado',2);"></span>
                        <span ng-click="orden('TotalProgramado',3)" class="seleccion glyphicon glyphicon-remove" aria-hidden="true" ng-show="mostrarBoton('TotalProgramado',3);"></span>
                    </th>
                    <th style="width: 33px" ng-show="mostrar">Falt</th>
                    <th class="cap" ng-repeat="dia in dias">{{dia}}</th>
                </tr>
            </thead>
            <tbody style="font-size: 10pt">
                <tr ng-repeat="programacion in programaciones | filter:{
                Estatus:filtro.Estatus,
                Producto:filtro.Producto,
                ProductoCasting:filtro.Casting,
                FechaEmbarque:filtro.Embarque,
                Aleacion:filtro.Aleacion,
                Marca:filtro.Cliente,
                Prioridad:filtro.Pr,
            } | orderBy:orden" ng-mousedown="setSelected(programacion);" ng-class="{info:selected.IdProgramacionSemana == programacion.IdProgramacionSemana}">
           
                    <th ng-class="{warning2: (programacion.TotalProgramado*1) > (programacion.Programadas*1)}">{{programacion.Producto}}</th>
                    <th ng-class="{warning2: (programacion.TotalProgramado*1) > (programacion.Programadas*1)}">{{programacion.ProductoCasting}}</th>
                    <th ng-show="IdProceso == 1" ng-class="{warning2: (programacion.TotalProgramado*1) > (programacion.Programadas*1)}">{{programacion.MoldesHora}}</th>
                    <th ng-class="{warning2: (programacion.TotalProgramado*1) > (programacion.Programadas*1)}" ng-show="mostrar">{{programacion.FechaEmbarque | date:'dd-MM-yy'}}</th>
                    <th ng-class="{warning2: (programacion.TotalProgramado*1) > (programacion.Programadas*1)}" ng-show="mostrar">{{programacion.Aleacion}}</th>
                    <th ng-class="{warning2: (programacion.TotalProgramado*1) > (programacion.Programadas*1)}" ng-show="mostrar">{{programacion.Marca}}</th>
                    <th ng-class="{warning2: (programacion.TotalProgramado*1) > (programacion.Programadas*1)}" ng-show="mostrar" style="width: 33px;">{{programacion.Prioridad == 0 ? '' : programacion.Prioridad}}</th>
                    <th ng-show="IdProceso == 1" style="width: 33px" ng-class="{success: programacion.TotalProgramado >= programacion.Programadas, danger: programacion.TotalProgramado == 0, warning: programacion.TotalProgramado < programacion.Programadas}">{{programacion.Programadas}}</th>
                    <th style="width: 33px" ng-class="{success: programacion.TotalProgramado >= programacion.Programadas, danger: programacion.TotalProgramado == 0, warning: programacion.TotalProgramado < programacion.Programadas}">{{programacion.TotalProgramado | currency :"":0}}</th>
                    <th style="width: 33px" ng-init="programacion.Faltan = programacion.TotalProgramado - programacion.TotalHecho" ng-class="{success: programacion.Faltan <= 0, danger: programacion.Faltan == programacion.TotalProgramado, warning: (programacion.Faltan < programacion.TotalProgramado && programacion.Faltan > 0 )}" ng-show="mostrar">{{programacion.Faltan | currency :"":0}}</th>

                <?php for($x=1;$x<=6;$x++):?>
                    <?php $class = $x % 2 != 0 ?'par' : 'impar'; ?>
                    
                    <th class="cap"><input ng-init="programacion.Maquina<?=$x?>" ng-disabled="programacion.Estatus == 'Cerrado'" class="filter" style="width: 33px; font-size: 9pt;" ng-model-options="{updateOn: 'blur'}" onkeypress="return justNumbers(event)" ng-change="saveProgramacionDiaria(programacion,<?=$x?>);" ng-model="programacion.Programadas<?=$x?>"></th>
                    <th ng-show="IdProceso == 1" class="cap">{{programacion.Programadas<?=$x?> / programacion.MoldesHora | currency:"":1}}</th>
                    <th ng-show="IdProceso == 1" class="<?=$class?>">{{programacion.Llenadas<?=$x?>}}</th>
                    <th ng-show="IdProceso == 1" class="<?=$class?>">{{programacion.Cerradas<?=$x?>}}</th>
                    <th ng-show="IdProceso == 1" class="<?=$class?>">{{programacion.Vaciadas<?=$x?>}}</th>
                    <th ng-show="IdProceso == 1" class="<?=$class?>">{{programacion.Programadas<?=$x?> - programacion.Llenadas<?=$x?>}}</th>
                <?php endfor; ?>
                </tr>
            </tbody>
        </table>
        </div>
    </div>
<?php if($IdArea == 3 && $IdProceso == 1): ?>
    <div id="encabezado" class="row">
        <div class="col-md-3">
            <table ng-class="{par:$index % 2 == 0, impar:$index % 2 != 0}" class="table table-bordered table-hover" style="font-size: 11pt;">
                <tr>
                    <th rowspan="2">Resumen</th>
                    <th colspan="5"><input type="week" disabled="" ng-model="semanaActual" ng-change="loadDias();" /></th>
                </tr>
                <tr>
                    <th>Mol</th>
                    <th>Pzas</th>
                    <th>Ton</th>
                    <th>Ton P</th>
                    <th>Hrs</th>
                </tr>
                <tr>
                    <th>PRG</th>
                    <th>{{sumatoria(resumenes,'PrgMol')}}</th>
                    <th>{{sumatoria(resumenes,'PrgPzas') | currency:'':0}}</th>
                    <th>{{sumatoria(resumenes,'PrgTon') | currency:'':2}}</th>
                    <th>{{sumatoria(resumenes,'PrgTonP') | currency:'':2}}</th>
                    <th>{{sumatoria(resumenes,'PrgHrs') | currency:'':1}}</th>
                </tr>
                <tr>
                    <th>PROD</th>
                    <th>{{sumatoria(resumenes,'HecMol')}}</th>
                    <th>{{sumatoria(resumenes,'HecPzas') | currency:'':0}}</th>
                    <th>{{sumatoria(resumenes,'HecTon') | currency:'':2}}</th>
                    <th>{{sumatoria(resumenes,'HecTonP') | currency:'':2}}</th>
                    <th>{{sumatoria(resumenes,'HecHrs') | currency:'':1}}</th>
                </tr>
                <tr>
                    <th>FALTAN</th>
                    <th>{{(sumatoria(resumenes,'PrgMol') - sumatoria(resumenes,'HecMol'))}}</th>
                    <th>{{(sumatoria(resumenes,'PrgPzas') - sumatoria(resumenes,'HecPzas'))| currency:'':0}}</th>
                    <th>{{(sumatoria(resumenes,'PrgTon') - sumatoria(resumenes,'HecTon'))| currency:'':2}}</th>
                    <th>{{(sumatoria(resumenes,'PrgTonP') - sumatoria(resumenes,'HecTonP'))| currency:'':2}}</th>
                    <th>{{(sumatoria(resumenes,'PrgHrs') - sumatoria(resumenes,'HecHrs'))| currency:'':2}}</th>
                </tr>
                <tr>
                    <th>% PROD</th>
                    <th>{{(sumatoria(resumenes,'HecMol') / sumatoria(resumenes,'PrgMol')) * 100 | currency:'':2}}%</th>
                    <th>{{(sumatoria(resumenes,'HecPzas') / sumatoria(resumenes,'PrgPzas')) * 100 | currency:'':2}}%</th>
                    <th>{{(sumatoria(resumenes,'HecTon') / sumatoria(resumenes,'PrgTon')) * 100 | currency:'':2}}%</th>
                    <th>{{(sumatoria(resumenes,'HecTonP') / sumatoria(resumenes,'PrgTonP')) * 100 | currency:'':2}}%</th>
                    <th>{{(sumatoria(resumenes,'HecHrs') / sumatoria(resumenes,'PrgHrs')) * 100 | currency:'':2}}%</th>
                </tr>
            </table>
        </div>
        <div ng-repeat="resumen in resumenes" class="col-md-3">
            <table ng-class="{par:$index % 2 == 0, impar:$index % 2 != 0}" class="table table-bordered table-hover" style="font-size: 11pt;">
                <tr>
                    <th rowspan="2">Resumen</th>
                    <th colspan="5">{{dias[$index]}}</th>
                </tr>
                <tr>
                    <th>Mol</th>
                    <th>Pzas</th>
                    <th>Ton</th>
                    <th>Ton P</th>
                    <th>Hrs</th>
                </tr>
                <tr>
                    <th>PRG</th>
                    <th>{{resumen.PrgMol}}</th>
                    <th>{{resumen.PrgPzas | currency:'':0}}</th>
                    <th>{{resumen.PrgTon | currency:'':2}}</th>
                    <th>{{resumen.PrgTonP | currency:'':2}}</th>
                    <th>{{resumen.PrgHrs | currency:'':1}}</th>
                </tr>
                <tr>
                    <th>PROD</th>
                    <th>{{resumen.HecMol}}</th>
                    <th>{{resumen.HecPzas | currency:'':0}}</th>
                    <th>{{resumen.HecTon | currency:'':2}}</th>
                    <th>{{resumen.HecTonP | currency:'':2}}</th>
                    <th>{{resumen.HecHrs | currency:'':1}}</th>
                </tr>
                <tr>
                    <th>FALTAN</th>
                    <th>{{(resumen.PrgMol - resumen.HecMol)}}</th>
                    <th>{{(resumen.PrgPzas - resumen.HecPzas)| currency:'':0}}</th>
                    <th>{{(resumen.PrgTon - resumen.HecTon)| currency:'':2}}</th>
                    <th>{{(resumen.PrgTonP - resumen.HecTonP)| currency:'':2}}</th>
                    <th>{{(resumen.PrgHrs - resumen.HecHrs)| currency:'':2}}</th>
                </tr>
                <tr>
                    <th>% PROD</th>
                    <th>{{((resumen.HecMol / resumen.PrgMol)*100)| currency:'':1}}%</th>
                    <th>{{((resumen.HecPzas / resumen.PrgPzas)*100)| currency:'':1}}%</th>
                    <th>{{((resumen.HecTon / resumen.PrgTon)*100)| currency:'':1}}%</th>
                    <th>{{((resumen.HecTonP / resumen.PrgTonP)*100)| currency:'':1}}%</th>
                    <th>{{((resumen.HecHrs / resumen.PrgHrs)*100)| currency:'':1}}%</th>
                </tr>
            </table>
        </div>
    </div>

<?php endif; ?>
<?php if($IdArea == 2 && $IdProceso == 1): ?>
    <div id="encabezado" class="row">
        <div class="col-md-3">
            <table ng-class="{par:$index % 2 == 0, impar:$index % 2 != 0}" class="table table-bordered table-hover" style="font-size: 11pt;">
                <tr>
                    <th rowspan="2">Resumen</th>
                    <th colspan="5"><input type="week" disabled="" ng-model="semanaActual" ng-change="loadDias();" /></th>
                </tr>
                <tr>
                    <th>K</th>
                    <th>V</th>
                    <th>E</th>
                </tr>
                <tr>
                    <th>TON PRG</th>
                    <th>{{sumatoria(resumenes,'TonPrgK')}}</th>
                    <th>{{sumatoria(resumenes,'TonPrgV') | currency:'':0}}</th>
                    <th>{{sumatoria(resumenes,'TonPrgE') | currency:'':0}}</th>
                    
                </tr>
                <tr>
                    <th>TON VAC</th>
                    <th>{{sumatoria(resumenes,'TonVacK')}}</th>
                    <th>{{sumatoria(resumenes,'TonVacV') | currency:'':0}}</th>
                    <th>{{sumatoria(resumenes,'TonVacE') | currency:'':0}}</th>
                    
                </tr>
                <tr>
                    <th>Ciclos</th>
                    <th>{{(sumatoria(resumenes,'CiclosK'))}}</th>
                    <th>{{(sumatoria(resumenes,'CiclosV'))}}</th>
                    <th>{{(sumatoria(resumenes,'CiclosE'))}}</th>
                    
                </tr>
                <tr>
                    <th>Moldes</th>
                    <th>{{(sumatoria(resumenes,'MolPrgK'))}}</th>
                    <th>{{(sumatoria(resumenes,'MolPrgV'))}}</th>
                    <th>{{(sumatoria(resumenes,'MolPrgE'))}}</th>
                </tr>
            </table>
        </div>
        <div ng-repeat="resumen in resumenes" class="col-md-3">
            <table ng-class="{par:$index % 2 == 0, impar:$index % 2 != 0}" class="table table-bordered table-hover" style="font-size: 11pt;">
                <tr>
                    <th rowspan="2">Resumen</th>
                    <th colspan="5">{{dias[$index]}}</th>
                </tr>
                <tr>
                    <th>K</th>
                    <th>V</th>
                    <th>E</th>
                    
                </tr>
                <tr>
                    <th>TON PRG</th>
                    <th>{{resumen.TonPrgK}}</th>
                    <th>{{resumen.TonPrgV}}</th>
                    <th>{{resumen.TonPrgE}}</th>
                </tr>
                <tr>
                    <th>TON VAC</th>
                    <th>{{resumen.TonVacK}}</th>
                    <th>{{resumen.TonVacV}}</th>
                    <th>{{resumen.TonVacE}}</th>
                </tr>
                <tr>
                    <th>CICLOS</th>
                    <th>{{(resumen.CiclosK)}}</th>
                    <th>{{(resumen.CiclosV)}}</th>
                    <th>{{(resumen.CiclosE)}}</th>
                </tr>
                <tr>
                    <th>MOL PRG</th>
                    <th>{{(resumen.MolPrgK)}}</th>
                    <th>{{(resumen.MolPrgV)}}</th>
                    <th>{{(resumen.MolPrgE)}}</th>
                </tr>
            </table>
        </div>
    </div>
<?php endif; ?>