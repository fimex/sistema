
<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\URL;

$this->title = $title;
if ($IdAreaAct == 1){
    $nameAreAc = "Kloster";
}elseif ($IdAreaAct == 2) {
    $nameAreAc = "Varel";
}else{
    $nameAreAc = "Especial";
}
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
    countProduccionesAceros(<?=$IdSubProceso?>);
    IdSubProceso = <?=$IdSubProceso?>;
    IdAreaAct = <?= $IdAreaAct?>;
    <?=$IdEmpleado == null ? "" : "    produccion.IdEmpleado = $IdEmpleado;"?>
    loadMaquinas();
    loadPartesMolde();
    <?php if($IdSubProceso == 6):?>
        loadEmpleados(['1-2']);
    <?php endif?>
">
    <?php if ($IdSubProceso == 6):?>
        <h3>Molde <?= $nameAreAc?></h3>
    <?php endif;?>
    <div id="encabezado" class="row">
        <div class="col-md-10">
            <form class="form-horizontal" name="editableForm" onaftersave="saveProduccion()">
                <div class="row">
                    <div class="col-md-2">
                        <div class="input-group">
                            <span class="input-group-addon">Fecha:</span>
                            <input ng-show="!mostrar" class="form-control input-sm" type="date" ng-change="produccion.Fecha = Fecha;loadProgramacion();" ng-model="Fecha"/>
                            <input ng-show="mostrar" disabled="" class="form-control input-sm" value="{{produccion.Fecha}}"/>
                        </div>
                    </div>
                    <?php if($IdSubProceso == 3):?>
                    <div class="col-md-2">
                        <div class="input-group">
                            <span id="Maquinas" class="input-group-addon">Proceso:</span>
                            <select ng-show="!mostrar" id="aleacion" aria-describedby="Maquinas" class="form-control input-sm" ng-change="selectMaquina();loadProgramacion();" ng-model="IdMaquina" required>
                                <option ng-selected="produccion.IdCentroTrabajo == maquina.IdCentroTrabajo" value="{{maquina.IdCentroTrabajo}}" ng-repeat="maquina in maquinas">{{maquina.Descripcion}}</option>
                            </select>
                            <input ng-show="mostrar" disabled="" class="form-control input-sm" value="{{produccion.idCentroTrabajo.Descripcion}}"/>
                        </div>
                    </div>
                    <?php endif;?>
                    <?php if($IdSubProceso != 16 && $IdSubProceso != 3):?>
                    <div class="col-md-2">
                        <div class="input-group">
                            <span id="Maquinas" class="input-group-addon"><?php if($IdSubProceso == 10):?>Horno:<?php else:?>Maquina:<?php endif;?></span>
                            <select ng-show="!mostrar" id="aleacion" aria-describedby="Maquinas" class="form-control input-sm" ng-change="selectMaquina();loadProgramacion();" ng-model="IdMaquina" required>
                                <option ng-selected="produccion.IdMaquina == maquina.IdMaquina" value="{{maquina.IdMaquina}}" ng-repeat="maquina in maquinas">{{maquina.ClaveMaquina}} - {{maquina.Maquina}}</option>
                            </select>
                            <input ng-show="mostrar" disabled="" class="form-control input-sm" value="{{produccion.idMaquina.Identificador}} - {{produccion.idMaquina.Descripcion}}"/>
                        </div>
                    </div>
                    <?php endif;?>
                    <?php if($IdSubProceso == 12 || $IdSubProceso == 6 || $IdSubProceso == 2 || $IdSubProceso == 16 || $IdSubProceso == 3):?>
                    <div class="col-md-4">
                        <div class="input-group">
                            <span id="Empleados" class="input-group-addon">Empleado:</span>
                            <select ng-show="!mostrar" aria-describedby="Empleados" class="form-control input-sm" ng-model="IdEmpleado" required>
                                <option ng-selected="produccion.IdEmpleado == e.IdEmpleado" ng-repeat="e in empleados" ng-value="{{e.IdEmpleado}}">{{e.NombreCompleto}}</option>
                            </select>
                            <input ng-show="mostrar" disabled="" class="form-control input-sm" value="{{produccion.idEmpleado.ApellidoPaterno}} {{produccion.idEmpleado.ApellidoMaterno}} {{produccion.idEmpleado.Nombre}}"/>
                        </div>
                    </div>
                    <?php endif;?>
                    <div class="col-md-4">
                        <div class="input-group">
                            <span id="Observaciones" class="input-group-addon">Observaciones:</span>
                            <textarea aria-describedby="Observaciones" class="form-control input-sm" ng-model="produccion.Observaciones">{{produccion.Observaciones}}</textarea>
                        </div>
                    </div>
                </div>
                <?php if($IdSubProceso == 10):?>
                <div class="row">
                    <div class="col-md-2">
                        <div class="input-group">
                            <span id="Aleaciones" class="input-group-addon">Aleacion:</span>
                            <select ng-show="!mostrar" id="aleacion" aria-describedby="Aleaciones"  class="form-control" ng-model="IdAleacion" required>
                                <option ng-selected="produccion.lances.IdAleacion == a.IdAleacion" ng-repeat="a in aleaciones" ng-value="{{a.IdAleacion}}">{{a.Identificador}}</option>
                            </select>
                            <input ng-show="mostrar" disabled="" class="form-control input-sm" value="{{produccion.lances.idAleacion.Identificador}}"/>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group">
                            <span id="consecutivo" class="input-group-addon">Consecutivo Horno:</span>
                            <input ng-show="!mostrar" class="form-control input-sm" ng-model="produccion.lances.HornoConsecutivo" ng-value="{{produccion.lances.HornoConsecutivo}}"/>
                            <input ng-show="mostrar" disabled="" class="form-control input-sm" value="{{produccion.lances.HornoConsecutivo}}"/>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group">
                            <span id="colada" class="input-group-addon">Colada:</span>
                            <input ng-show="!mostrar" class="form-control" ng-model="produccion.lances.Colada" ng-value="{{produccion.lances.Colada}}"/>
                            <input ng-show="mostrar" disabled="" class="form-control input-sm" value="{{produccion.lances.Colada}}"/>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group">
                            <span id="lance" class="input-group-addon">Lance:</span>
                            <input ng-show="!mostrar" class="form-control" ng-model="produccion.lances.Lance" ng-value="{{produccion.lances.Lance}}"/>
                            <input ng-show="mostrar" disabled="" class="form-control input-sm" value="{{produccion.lances.Lance}}"/>
                        </div>
                    </div>
                </div>
                <?php endif;?>
                <?php if($IdSubProceso == 6):?>
                    <div class="col-md-2">
                        <div class="input-group">
                            <span class="input-group-addon">Fecha de Moldeo:</span>
                            <input class="form-control input-sm" type="date" ng-model="FechaMoldeo2"/>
                        </div>
                    </div><br><br>
                <?php endif;?>
                <div class="row">
                    <div class="col-md-12">
                        <button title="Primer Registro" class="btn btn-primary" ng-click="First();" ng-disabled="!mostrar">|<</button>
                        <button title="Registro Anterior" class="btn btn-primary" ng-click="Prev();" ng-disabled="!mostrar"><</button>
                        <button class="btn btn-primary" ng-click="addProduccion();mostrar=false" ng-show="mostrar">Nuevo Registro</button>
                        <button class="btn btn-primary" ng-click="saveProduccion();mostrar=true" ng-show="!mostrar">Generar</button>
                        <button class="btn btn-success" ng-click="updateProduccion();" ng-show="mostrar">Guardar</button>
                        <button class="btn" ng-click="produccion.IdProduccionEstatus=2;saveProduccion();" ng-show="mostrar">Cerrar Captura</button>
                        <button title="Siguiente Registro" class="btn btn-primary" ng-click="Next();" ng-disabled="!mostrar">></button>
                        <button title="Ultimo Registro" class="btn btn-primary" ng-click="Last();" ng-disabled="!mostrar">>|</button>
                        <b>Semana: {{produccion.Semana}}</b>
                    </div>
                   
                    
                </div>
            </form>
        </div>
    </div>
    <div class="row"><hr /></div>
    <?php if($IdSubProceso == 2):?>
    <div class="row">
        <div class="col-md-4">
            <?= $this->render('programacionAlmas',[
                'IdSubProceso'=>$IdSubProceso,
            ]);?>
        </div>
        <div class="col-md-4">
            <?= $this->render('FormProduccionAlmasDetalle',[
                'IdSubProceso'=>$IdSubProceso,
            ]);?>
        </div>
        <div class="col-md-4">
            <?= $this->render('FormProduccionAlmasRechazo',[
                'subProceso'=>$IdSubProceso,
                'titulo' => 'Rechazo Almas',
            ]);?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <?= $this->render('FormTiemposMuerto',[
                'IdSubProceso'=>$IdSubProceso,
            ]);?>
        </div>
        <div class="col-md-4">
            <?= $this->render('FormTemperaturas',[
                'IdSubProceso'=>$IdSubProceso,
            ]);?>
        </div>
    </div>
    <?php endif?>
    <?php if($IdSubProceso == 3):?>
    <div class="row">
        <div class="col-md-4">
            <?= $this->render('programacionAlmas',[
                'IdSubProceso'=>$IdSubProceso,
            ]);?>
        </div>
        <div class="col-md-4">
            <?= $this->render('FormProduccionAlmasDetalle',[
                'IdSubProceso'=>$IdSubProceso,
            ]);?>
        </div>
        <div class="col-md-4">
            <?= $this->render('FormProduccionAlmasRechazo',[
                'subProceso'=>$IdSubProceso,
                'titulo' => 'Rechazo Almas',
            ]);?>
        </div>
    </div>
    <?php endif?>
    <?php if($IdSubProceso == 6):?>
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
    <?php endif?>
    <?php if($IdSubProceso == 10):?>
    <div class="row">
        <div class="col-md-4">
            <?= $this->render('programacion',[
                'IdSubProceso'=>$IdSubProceso,
            ]);?>
        </div>
        <div class="col-md-4">
            <?= $this->render('FormProduccionDetalle',[
                'IdSubProceso'=>$IdSubProceso,
            ]);?>
            <?= $this->render('FormTemperaturas',[
                'IdSubProceso'=>$IdSubProceso,
            ]);?>
        </div>
        <div class="col-md-4">
            <?= $this->render('FormProduccionMaterial',[
                'subProceso'=>$IdSubProceso,
            ]);?>
        </div>
    </div>
    <?php endif?>
</div>