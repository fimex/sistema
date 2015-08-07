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
    #programacion, #detalle, #rechazo, #TMuerto{
        height:280px;
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
<div class="container-fluid" ng-controller="ProduccionAceros" ng-init="loadProductosSeries(); loadProductos();">
    <div class="col-md-5">
    <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading">Control de Series</div>
        <div class="panel-body">
            <button class="btn btn-success" ng-click="addSerie()">Agregar Serie</button>
        </div>
        <div id="ProductosSeries" class="scrollable">
            <table class="table table-condensed table-striped">
                <thead>
                    <tr>
                        <th style="width: 50px;">IdSerie</th>
                        <th>No Parte</th>
                        <th style="width: 100px;">Serie</th>
                        <th style="width: 100px;"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="series in ProductosSeries" >
                        <th>{{series.IdConfiguracionSerie}}</th>
                        <th>
                            <select class="form-control"  ng-init="series.IdProducto" ng-model="series.IdProducto" >
                                <option ng-selected="series.IdProducto == producto.IdProducto" ng-init="producto.Identificacion" value="{{producto.IdProducto}}" ng-repeat="producto in productos">{{ producto.Identificacion }}</option>
                            </select>
                        </th>
                        <th style="width: 100px;"><input class="form-control" style="width: 100px;" ng-model-options="{updateOn: 'blur'}" ng-model="series.SerieInicio" value="{{series.SerieInicio}}"/>
                        <input class="form-control" type="hidden" ng-model="producto.Identificacion" value="{{producto.Identificacion}}" >
                        </th>
                        <th><button class="btn btn-danger" ng-click="saveSerie($index)">Guargar</button></th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    </div>
</div>
