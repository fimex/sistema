<?php
/* @var $this yii\web\View */
    use yii\helpers\Html;
    use yii\bootstrap\Modal;
    use yii\helpers\URL;

    $this->title = $title;
?>

<div ng-controller="ProduccionAceros" ng-init="
        countProduccionesAceros(<?=$IdSubProceso?>);
        IdSubProceso = <?=$IdSubProceso?>;
        Proceso = <?=$Proceso?>;
        IdAreaAct = 1;
        <?=$IdEmpleado == null ? "" : "    produccion.IdEmpleado = $IdEmpleado;"?>
        loadMaquinas();
        loadPartesMolde();
        loadEmpleados(['1-2']);
        ">
    <h3>Cerrado Kloster</h3>
    <div class="row">
        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-addon">Fecha:</span>
                <input ng-show="!mostrar" class="form-control input-sm" type="date" ng-change="produccion.Fecha = Fecha;loadProgramacion();" ng-model="Fecha"/>
                <input ng-show="mostrar" disabled="" class="form-control input-sm" value="{{produccion.Fecha}}"/>
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-group">
                <span id="Empleados" class="input-group-addon">Empleado:</span>
                <select ng-show="!mostrar" aria-describedby="Empleados" class="form-control input-sm" ng-model="IdEmpleado" required>
                    <option ng-selected="produccion.IdEmpleado == e.IdEmpleado" ng-repeat="e in empleados" ng-value="{{e.IdEmpleado}}">{{e.NombreCompleto}}</option>
                </select>
                <input ng-show="mostrar" disabled="" class="form-control input-sm" value="{{produccion.idEmpleado.ApellidoPaterno}} {{produccion.idEmpleado.ApellidoMaterno}} {{produccion.idEmpleado.Nombre}}"/>
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-group">
                <span id="Observaciones" class="input-group-addon">Observaciones:</span>
                <textarea aria-describedby="Observaciones" class="form-control input-sm" ng-model="produccion.Observaciones">{{produccion.Observaciones}}</textarea>
            </div>
        </div>
    </div>
    <?php if($IdSubProceso == 6):?>
        <div class="col-md-2">
            <div class="input-group">
                <span class="input-group-addon">Fecha de Moldeo:</span>
                <input class="form-control input-sm" type="date" ng-model="FechaMoldeo2"/>
            </div>
        </div><br><br>
    <?php endif;?>
    <div>
        <button title="Primer Registro" class="btn btn-primary" ng-click="First();" ng-disabled="!mostrar">|<</button>
        <button title="Registro Anterior" class="btn btn-primary" ng-click="Prev();" ng-disabled="!mostrar"><</button>
        <button class="btn btn-primary" ng-click="addProduccion();mostrar=false" ng-show="mostrar">Nuevo Registro</button>
        <button class="btn btn-primary" ng-click="saveProduccion();mostrar=true" ng-show="!mostrar">Generar</button>
        <button class="btn btn-success" ng-click="loadProduccion();mostrar=true" ng-show="!mostrar">Cancelar</button>
        <button class="btn btn-success" ng-click="updateProduccion();" ng-show="mostrar">Guardar</button>
        <button class="btn" ng-click="produccion.IdProduccionEstatus=2;saveProduccion();" ng-show="mostrar">Cerrar Captura</button>
        <button title="Siguiente Registro" class="btn btn-primary" ng-click="Next();" ng-disabled="!mostrar">></button>
        <button title="Ultimo Registro" class="btn btn-primary" ng-click="Last();" ng-disabled="!mostrar">>|</button>
        <b>Semana: {{produccion.Semana}}</b>
    </div>
    <br>
    <div class="row">
        <div class="col-md-4">
            <?= $this->render('CerradoK',[
                'IdSubProceso'=>$IdSubProceso,
            ]);?>
        </div>
    </div>
</div>

