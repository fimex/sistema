
<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\URL;

$this->title = $title;
//$minFecha = date('H')< 6 ? date('Y-m-d',strtotime('-1 day',strtotime(date()))) : date('Y-m-d');
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
        height:280px;
    }
</style>
<div class="container-fluid" ng-controller="ProduccionAceros" ng-init="
    IdSubProceso = <?=$IdSubProceso?>;
    IdAreaAct = <?= $IdAreaAct?>;
    IdMaquina = <?= $IdAreaAct == 1 ? 1751 : ($IdAreaAct == 2 ? 1610 : 1630) ?>;
    IdArea = <?= $IdArea?>;
    IdEmpleado = <?=$IdEmpleado?>;
    loadProgramaciones();
    loadPartesMolde();
    loadTurnos();
">
    <h3><?=$title?></h3>
    <div id="encabezado" class="row">
        <div class="col-md-10">
            <form class="form-horizontal" name="editableForm" onaftersave="saveProduccion()">
                <div class="row">
                    <div class="col-md-2">
                        <div class="input-group">
                            <span class="input-group-addon">Fecha:</span>
                            <input class="form-control input-sm" type="date" ng-change="loadProgramaciones()" ng-model="Fecha" format-date />
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">Fecha de Moldeo:</span>
                            <input class="form-control input-sm" type="date" ng-model="FechaMoldeo2"/>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">Turno:</span>
                            <select ng-disabled="mostrar" id="turnos" aria-describedby="Turnos" ng-change="loadProgramaciones()" class="form-control" ng-model="IdTurno" required>
                                <option ng-selected="IdTurno == turno.IdTurno" value="{{turno.IdTurno}}" ng-repeat="turno in turnos">{{turno.IdTurno}} - {{turno.Descripcion}}</option>
                            </select>                    
                        </div>
                    </div>
                    <div class="col-md-2" >
                        <div class="input-group" >
                            <button ng-click="buscar2();" class="btn btn-info">Control de Tiempos Muertos</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row"><hr /></div>
    <div class="row">
        <div class="col-md-8">
            <div class="row" style="width:110%">
                <div class="col-md-6" style="width:110%">
                    <?= $this->render('FormProduccionDetalleAcero',[
                        'IdSubProceso'=>$IdSubProceso,
                        'IdAreaAct' => $IdAreaAct,
                    ]);?>
                </div>
            </div>
        </div>
    </div>
    <modal title="Control de Tiempos Muertos" visible="showModal2">
        <?= $this->render('FormTiemposMuerto');?>
    </modal>
</div>