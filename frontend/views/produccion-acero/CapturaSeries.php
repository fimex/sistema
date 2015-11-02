<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\URL;

$this->title = $title;

?>
<style>
    .table{
        display: fixed;
    }
    
    .table input{
        width: 100%;
    }
    
    .table .captura{
        width: 50px;
    }
    
    .div-table-content {
      height:300px;
      overflow-y:auto;
    }
    .div-table-content2 {
      height:200px;
      overflow-y:auto;
    }
    .scrollable {
        width: 100%;
        margin: auto;
        border: 2px solid #ccc;
        overflow-y: scroll; /* <-- here is what is important*/
    }
    #ProductosSeries{
        height:800px;
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
</style>
<div class="container-fluid" ng-controller="ProduccionAceros2" ng-init="loadProductosSeries(); loadProductos();">
    <div class="col-md-12">
    <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading">Control de Series</div>
        <div class="panel-body">
        </div>
        <div id="ProductosSeries" class="scrollable">
            <table ng-table fixed-table-headers="ProductosSeries" class="table table-condensed table-striped" >
                <thead>
                    <tr>
                        <th>IdSerie</th>
                        <th>Cliente<br /><input class="form-control" ng-model="filtro.Marca"/></th>
                        <th>No Parte<br /><input class="form-control" ng-model="filtro.Identificacion"/></th>
                        <th>Descripcion</th>
                        <th style="width: 100px;">Serie</th>
                        <th style="width: 100px;"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="series in ProductosSeries | filter:filtro">
                        <th>{{series.IdConfiguracionSerie}}</th>
                        <th>{{series.Marca}}</th>
                        <th>{{series.Identificacion}}</th>
                        <th>{{series.Descripcion}}</th>
                        <th style="width: 100px;"><input class="form-control" style="width: 100px;" ng-model-options="{updateOn: 'blur'}" ng-model="series.idConfiguracionSerie.SerieInicio"/>
                        </th>
                        <th>
                            <button class="btn btn-danger" ng-if="!series.IdConfiguracionSerie" ng-click="saveSerie(series)">Generar</button>
                            <button class="btn btn-info" ng-if="series.IdConfiguracionSerie" ng-click="saveSerie(series)">Actualizar</button>
                        </th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    </div>
</div>
