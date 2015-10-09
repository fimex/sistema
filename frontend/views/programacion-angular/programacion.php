<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\programacion\ProgramacionesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$area = Yii::$app->session->get('area');
$area = $area['IdArea'];
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
        height: 742px;
        border: 2px solid #ccc;
        overflow-y: scroll; /* <-- here is what is important*/
    }
    #pedidos{
        height: 300px;
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
<div ng-controller="Programacion" ng-init="IdAreaProceso=<?=$AreaProceso?>; IdArea=<?=$area?>; loadSemanas();filtro.Estatus='Abierto';filtro.orden2 = '!P-';">
    <input type="week" ng-model="semanaActual" ng-change="loadSemanas();" format-date />
    <button class="btn btn-success" ng-click="loadSemanas()">Actualizar</button>
    <button class="btn btn-primary" ng-click="mostrarPedido = !mostrarPedido"><span ng-if="!mostrarPedido">Mostrar Pedidos</span><span ng-if="mostrarPedido">Ocultar Pedidos</span></button>
    <button class="btn btn-primary" ng-model="filtro.orden2" ng-click="filtro.orden2 = filtro.orden2 == '!P-' ? '' : '!P-'"><span ng-if="filtro.orden2 == '!P-'">Mostrar Pruebas</span><span ng-if="filtro.orden2 != '!P-'">Ocultar Pruebas</span></button>
    <?php if($area == 3){ ?>
        <button class="btn btn-success" ng-click="cerrarPedido();">Cerrar Pedido</button>
    <?php } ?>
    Mostrar Pedidos: <select  ng-model="filtro.Estatus">
        <option value="">Todos</option>
        <option value="Abierto">Abiertos</option>
        <option value="Cerrado">Cerrados</option>
    </select>
    Ultima Actualizacion: {{actual}}
    
    <div class="panel panel-default" ng-show="mostrarPedido">
        <div class="panel-body">
        </div>
        <?= $this->render('pedidos',['area'=>$area]);?>
    </div>
    <?= $this->render('programacionSemanal' . (Yii::$app->user->identity->role == 1 ? '' : '2'),['AreaProceso'=>$AreaProceso]);?>
</div>