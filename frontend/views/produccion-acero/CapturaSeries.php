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
    #completo{
        width:97%;
        height:91%;
        position:absolute;
        display:block;
        background: #999999;
        z-index:99999;
        opacity:1;
        margin:0%;
        -webkit-transition: all 1s ease-in-out;
        -moz-transition: all 1s ease-in-out;
        -o-transition: all 1s ease-in-out;
        transition: all 1s ease-in-out;
    }
    .centrado{
        width:50%;
        max-width: 400px;
        height:auto;
        position:relative;
        display:block;
        margin:auto;
        border:red solid 1px;
        top:30%;
        background:#ffffff;
        border:white solid 1px;
        padding:30px;
    }
    .error{
        width:100%;
        border:none;
    }
</style>
<div class="container-fluid" ng-controller="ProduccionAceros2" ng-init="loadProductosSeries(); loadProductos();
role = <?= $role?>;
username = '<?= $username?>';">
    <!---Espacio para div que cubre toda la pantalla y pide informacion para hacer la busqueda-->
    <div id="completo" ng-model="completo" >
        <div class="centrado" ng-show="!(role == 1)">
            No tienes permitido entrar a esta seccion
        </div>
        <div class="centrado" ng-show="role == 1">
            <div class="input-group">
                <span class="input-group-addon">Usuario</span>
                <input class="form-control input-sm" type="text" ng-change="" ng-model="username" ng-value="username"/>
            </div><br />
            <input type="hidden" ng-model="FechaMoldeo2">
            <div class="input-group">
                <span class="input-group-addon">Clave:</span>
                <input class="form-control input-sm" type="password" ng-change="" ng-model="clave" />                   
            </div><br />
            <div class="input-group" ><input type="text" class="error" ng-model="msgError"></div><br />
            <div class="input-group" >
                <button class="btn btn-info" ng-click="accesar()">Accesar</button>
            </div>
        </div>
    </div>
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
