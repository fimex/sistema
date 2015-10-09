
<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\URL;

if ($IdMaquina == 2242 ) {
    $title = 'Pruebas de Impacto Charpy';
}
if ($IdMaquina == 2243 ) {
    $title = 'Pruebas Mecanicas';
}
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
<div class="container-fluid" ng-controller="PruebasDestructivas" ng-init="
    countProduccionesAceros(<?=$IdSubProceso?>,<?=$IdArea?>,<?=$IdMaquina?>,<?=$IdCentroTrabajo?>);
    IdTurno = 1;
    IdProbeta = 1;
    IdCentroTrabajo = <?=$IdCentroTrabajo?>;
    IdMaquina = <?=$IdMaquina?>;
    IdSubProceso = <?=$IdSubProceso?>;
    IdEmpleado = <?=$IdEmpleado?>;
    loadTurnos();
    loadAleaciones();
    <?php if($IdMaquina == 2242):?>
        loadProbetas('Charpy');
    <?php endif ?>
    <?php if($IdMaquina == 2243):?>
        loadProbetas('Tension');
    <?php endif ?>
">
    <h3><?=$title?></h3>
    <div id="encabezado" class="row">
        <div class="col-md-10">
            <form class="form-horizontal" name="editableForm" >
                <input type="hidden" class="form-control input-sm" type="date" ng-model="IdMaquina" value="<?=$IdMaquina?>" />
                <input type="hidden" class="form-control input-sm" type="date" ng-model="IdCentroTrabajo" value="<?=$IdCentroTrabajo?>" />
                <div class="row">
                    <div class="col-md-2">
                        <div class="input-group">
                            <span class="input-group-addon">Fecha:</span>
                            <input ng-show="!mostrar" class="form-control input-sm" type="date" ng-change="produccion.Fecha = Fecha;" ng-model="Fecha"/>
                            <input ng-show="mostrar" disabled="" class="form-control input-sm" value="{{produccion.Fecha}}"/>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group">
                            <span class="input-group-addon">Turno:</span>
                            <select ng-disabled="mostrar" id="turnos" aria-describedby="Turnos" ng-change="loadProgramaciones()" class="form-control" ng-model="IdTurno" required>
                                <option ng-selected="IdTurno == turno.IdTurno" value="{{turno.IdTurno}}" ng-repeat="turno in turnos">{{turno.IdTurno}} - {{turno.Descripcion}}</option>
                            </select>                    
                        </div>
                    </div>
                    <?php if ($IdMaquina == 2242):?>
                    <div class="col-md-2">
                        <div class="input-group">
                            <span id="specimen" class="input-group-addon">Specimen Standard:</span>
                            <input class="form-control" value="ASTM-E23"/>
                        </div>
                    </div>
                    <?php endif ?>
                </div><br>
                <div class="row">
                    <div class="col-md-12">
                        <button title="Primer Registro" class="btn btn-primary" ng-click="First();" ng-disabled="!mostrar">|<</button>
                        <button title="Registro Anterior" class="btn btn-primary" ng-click="Prev();" ng-disabled="!mostrar"><</button>
                        <button class="btn btn-primary" ng-click="addProduccion();mostrar=false" ng-show="mostrar">Nuevo Registro</button>
                        <button class="btn btn-primary" ng-click="saveProduccion();mostrar=true" ng-show="!mostrar">Generar</button>
                        <button class="btn btn-success" ng-click="loadProduccion();mostrar=true" ng-show="!mostrar">Cancelar</button>
                        <button class="btn btn-success" ng-click="updateProduccion();" ng-show="mostrar">Guardar</button>
                        <button title="Siguiente Registro" class="btn btn-primary" ng-click="Next();" ng-disabled="!mostrar">></button>
                        <button title="Ultimo Registro" class="btn btn-primary" ng-click="Last();" ng-disabled="!mostrar">>|</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row"><hr /></div>
    <?php if($IdMaquina == 2242):?>
    <div class="row">
        <div class="col-md-8">
            <div class="row" style="width:110%">
                <div class="col-md-6" style="width:110%">
                    <?= $this->render('FormCharpy',[
                        'IdSubProceso'=>$IdSubProceso,
                        'IdArea' => $IdArea,
                    ]);?>
                </div>
            </div>
        </div>
    </div>
    <?php endif ?>
    <?php if($IdMaquina == 2243):?>
    <div class="row" >
        <div class="col-md-4" style="width:80%">
            <?= $this->render('FormPruebasMecanicas',[
                'IdSubProceso'=>$IdSubProceso,
                'IdArea' => $IdArea,
                'IdMaquina' => $IdMaquina,
            ]);?>
        </div>
     
    </div>
    <?php endif ?>
</div>