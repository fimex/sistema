
<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\URL;

$this->title = $title;

$minFecha = date('H')< 6 ? date('Y-m-d',strtotime('-1 day',strtotime(date()))) : date('Y-m-d');
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
<h2>Captura de tiempos muertos</h2>
<div class="container-fluid" ng-controller="Produccion" ng-init="
   IdSubProceso = <?=$IdSubProceso?>;
   IdArea = 2;
   loadMaquinas();
   loadFallas();
   loadTurnos();
   loadSuBrocesos();
">
    <div id="encabezado" class="row">
        <div class="col-md-10">
            <form class="form-horizontal" name="editableForm" onaftersave="saveProduccion()">
                <div class="row">
					<div class="col-md-4">
							 <div class="input-group">
                            <span class="input-group-addon">SubProceso:</span>
                            <select ng-disabled="mostrar" id="turnos" aria-describedby="Proceso" class="form-control" ng-change="selecTurnos();" ng-model="producciones[index].SuBroceso" required>
                                <option  value="{{SuBrocesos.IdSubproceso}}" ng-repeat="SuBroceso in SuBrocesos">{{SuBroceso.IdSubproceso}} - {{SuBroceso.Descripcion}}</option>
                            </select>                    </div>
					</div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <span id="Maquinas" class="input-group-addon">Maquina:</span>
                            <select ng-disabled="mostrar" id="aleacion" aria-describedby="Maquinas" class="form-control" ng-change="selectMaquina();" ng-model="producciones[index].IdMaquina" required>
                                <option ng-selected="producciones[index].IdMaquina == maquina.IdMaquina" value="{{maquina.IdMaquina}}" ng-repeat="maquina in maquinas">{{maquina.ClaveMaquina}} - {{maquina.Maquina}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-addon">Turno:</span>
                            <select ng-disabled="mostrar" id="turnos" aria-describedby="Turnos" class="form-control" ng-change="selecTurnos();" ng-model="producciones[index].IdTurno" required>
                                <option ng-selected="producciones[index].IdTurno == turnos.IdTurno" value="{{turnos.IdTurno}}" ng-repeat="turno in turnos">{{turno.IdTurno}} - {{turno.Descripcion}}</option>
                            </select>                    </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <button title="Primer Registro" class="btn btn-primary" ng-click="First();" ng-disabled="!mostrar">|<</button>
                        <button title="Registro Anterior" class="btn btn-primary" ng-click="Prev();" ng-disabled="!mostrar"><</button>
                        <button class="btn btn-primary" ng-click="addProduccion();mostrar=false" ng-show="mostrar">Nuevo Registro</button>
                        <button class="btn btn-primary" ng-click="saveProduccion();mostrar=true" ng-show="!mostrar">Generar</button>
                        <button class="btn btn-success" ng-click="saveProduccion();" ng-show="mostrar">Actualizar</button>
                        <button class="btn" ng-click="producciones[index].IdProduccionEstatus=2;saveProduccion();" ng-show="mostrar">Cerrar Captura</button>
                        <button title="Siguiente Registro" class="btn btn-primary" ng-click="Next();" ng-disabled="!mostrar">></button>
                        <button title="Ultimo Registro" class="btn btn-primary" ng-click="Last();" ng-disabled="!mostrar">>|</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row"><hr /></div>

    <div class="row">
        <div class="col-md-9">
            <?= $this->render('FormTiemposMuerto',[
                'subProceso'=>3,
            ]);?>
        </div>
    </div>
</div>