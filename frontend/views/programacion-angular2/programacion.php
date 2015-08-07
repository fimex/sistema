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

<div ng-controller="Programacion" ng-init="loadSemanas();selectAll=true">
    <div class="panel panel-default" ng-show="mostrarPedido">
        <div class="panel-body">
        </div>
        <?= $this->render('pedidos');?>
    </div>
    <?= $this->render('programacionSemanal' . (Yii::$app->user->identity->role == 1 ? '' : '2'));?>
</div>