
<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\URL;
use yii\grid\GridView;

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
    
    #detalle, #rechazo, #TMuerto, #Temperaturas{
        height:380px;
    }
    .listaSerie{
        position:relative;
        display:inline-block;
        margin:0 10px 10px 0;
        border-bottom:#999999 solid 1px;
        border-right:#999999 solid 1px;
    }
</style>
<div class="container-fluid" ng-controller="ProduccionAceros" ng-init="loadDatosEstatusMonitoreo();">
    <h3> <?= $title ?></h3>
    <div id="encabezado" class="row">
        <div class="col-md-10">
            <form class="form-horizontal" id="formuploadajax" enctype="multipart/form-data" name="editableForm" onaftersave="saveProduccion()">
                <div class="row">
                    <div class="col-md-2">
                        <div class="input-group">
                            <span class="input-group-addon">Semana:</span>
                            <input class="form-control input-sm" type="week" ng-model="semanaActual" ng-change="loadDatosEstatusMonitoreo();" />
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row"><hr /></div>
    <div class="row">
        <div class="col-md-20" >
            <?= $this->render('FormMonitoreo');?>
        </div>
    </div>
</div>

