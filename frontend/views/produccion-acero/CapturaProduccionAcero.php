
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
        overflow: auto;
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
</style>

<div class="container-fluid" ng-controller="ProduccionAceros" ng-init="
    IdTurno = 1;
    IdSubProceso = <?=$IdSubProceso?>;
    IdAreaAct = <?= is_null($IdAreaAct) ? 'null' : $IdAreaAct ?>;
    IdMaquina = <?= $IdAreaAct == 1 ? 1751 : ($IdAreaAct == 2 ? 1610 : 1755) ?>;
    IdArea = <?= $IdArea?>;
    IdEmpleado = <?=$IdEmpleado?>;
    loadProgramaciones();
    loadPartesMolde();
    loadTurnos();
    loadTiempos(); 
    loadFallas();
    <?php if($IdSubProceso == 6): ?>
        loadEmpleados('1-2');
    <?php endif; ?>
    <?php if($IdSubProceso == 7): ?>
        loadEmpleados('1-3');
    <?php endif; ?>
    <?php if($IdSubProceso == 8): ?>
        IdMaquina = 1632;
    <?php endif; ?>
    <?php if($IdSubProceso == 9 || $IdSubProceso == 8): ?>
        loadEmpleados(['1-2','1-3']);
    <?php endif; ?>
">
    <!---Espacio para div que cubre toda la pantalla y pide informacion para hacer la busqueda-->
    <div id="completo" ng-model="completo" >
        <div class="centrado">
            <div class="input-group">
                <span class="input-group-addon">Fecha de captura:</span>
                <input class="form-control input-sm" type="date" ng-change="loadProgramaciones();" ng-model="Fecha" format-date />
            </div><br />
            <input type="hidden" ng-model="FechaMoldeo2">
            <!--<div class="input-group">
                <span class="input-group-addon">Fecha de Moldeo:</span>
                <input class="form-control input-sm" type="date" ng-model="FechaMoldeo2" ng-change="capturaFecha();"/>
            </div><br />-->
            <div class="input-group">
                <span class="input-group-addon">Turno:</span>
                <select id="turnos" aria-describedby="Turnos" ng-change="loadProgramaciones();" class="form-control" ng-model="IdTurno" required>
                    <option ng-selected="IdTurno == turno.IdTurno" value="{{turno.IdTurno}}" ng-repeat="turno in turnos">{{turno.IdTurno}} - {{turno.Descripcion}}</option>
                </select>                    
            </div><br />
            <div class="input-group" ng-model="msgError" id="msgError"></div>
            <div class="input-group" >
                <button class="btn btn-info" ng-click="loadDivFlotante()">Guardar</button>
            </div>
        </div>
    </div>

    <h3><?=$title?></h3>
    <div id="encabezado" class="row">
        <div class="col-md-10">
            <form class="form-horizontal" name="editableForm" onaftersave="saveProduccion()">
                <div class="row">
                    <div class="col-md-2">
                        <div class="input-group">
                            <span class="input-group-addon">Fecha de captura:</span>
                            <input class="form-control input-sm" type="date" ng-change="loadProgramaciones()" ng-model="Fecha" format-date />
                        </div>
                        <?php if($IdSubProceso != 9):?>
                        <!--<div class="input-group">
                            <span class="input-group-addon">Fecha de Moldeo:</span>-->
                            
                            <!--<input class="form-control input-sm" type="date" ng-model="FechaMoldeo2"/>-->
                        <!--</div>-->
                        <?php endif ?>
                        <div class="input-group">
                            <span class="input-group-addon">Turno:</span>
                            <select id="turnos" aria-describedby="Turnos" ng-change="loadProgramaciones()" class="form-control" ng-model="IdTurno" required>
                                <option ng-selected="IdTurno == turno.IdTurno" value="{{turno.IdTurno}}" ng-repeat="turno in turnos">{{turno.IdTurno}} - {{turno.Descripcion}}</option>
                            </select>                    
                        </div>
                        <?php if($IdSubProceso != 9):?>
                        <div class="input-group">
                            <span id="Empleados" class="input-group-addon">Empleado:</span>
                            <select ng-show="mostrar" aria-describedby="Empleados" class="form-control input-sm" ng-model="IdEmpleado" required>
                                <option ng-selected="produccion.IdEmpleado == e.IdEmpleado" ng-repeat="e in empleados" ng-value="{{e.IdEmpleado}}">{{e.NombreCompleto}}</option>
                            </select>
                        </div>
                        <?php endif ?>
                    </div>
                    <div class="col-md-2" style="margin-left:40px">
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
                    <?php if($IdSubProceso == 7):?> 
                        <?= $this->render('FormProduccionDetalleAceroMoldeoVarel',[
                            'IdSubProceso'=>$IdSubProceso,
                            'IdAreaAct' => $IdAreaAct,
                        ]);?>
                    <?php elseif($IdSubProceso == 6):?>
                        <?= $this->render('FormProduccionDetalleAceroMoldeoKlooster',[
                            'IdSubProceso'=>$IdSubProceso,
                            'IdAreaAct' => $IdAreaAct,
                        ]);?>
                    <?php else:?>
                        <?= $this->render('FormProduccionDetalleAcero',[
                            'IdSubProceso'=>$IdSubProceso,
                            'IdAreaAct' => $IdAreaAct,
                        ]);?>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
    <modal title="Control de Tiempos Muertos" visible="showModal2">
        <?= $this->render('FormTiemposMuerto');?>
    </modal>
</div>