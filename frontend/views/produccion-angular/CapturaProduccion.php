
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
<div class="container-fluid" ng-controller="Produccion" ng-init="
    producciones[0].IdSubProceso = <?=$IdSubProceso?>;
<?=$IdEmpleado == null ? "" : "    producciones[0].IdEmpleado = $IdEmpleado;"?>
    loadMaquinas();
    loadProduccion();
    loadProgramacion();
    loadMaterial();
    loadFallas();
    loadDefectos();
    <?php if($IdSubProceso == 12):?>
        loadEmpleados('2-6');
    <?php endif?>
    <?php if($IdSubProceso == 2):?>
        loadEmpleados('2-1');
    <?php endif?>
    <?php if($IdSubProceso == 6):?>
        loadEmpleados(['2-1,2-2,2-5']);
    <?php endif?>
    <?php if($IdSubProceso == 10):?>
        loadAleaciones();
    <?php endif?>
">
    <div id="encabezado" class="row">
        <div class="col-md-10">
            <form class="form-horizontal" name="editableForm" onaftersave="saveProduccion()">
            <div class="row">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-addon">Fecha:</span>
                            <input class="form-control" type="date" ng-change="loadProgramacion();loadTiempos();loadProduccion();" value="{{producciones[index].Fecha | date:'yyyy-MM-dd'}}" ng-model="Fecha"/>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <span id="Maquinas" class="input-group-addon"><?php if($IdSubProceso == 10):?>Horno:<?php else:?>Maquina:<?php endif;?></span>
                        <select ng-disabled="mostrar" id="aleacion" aria-describedby="Maquinas" class="form-control" ng-change="selectMaquina();<?php if($IdSubProceso == 6):?>loadProgramacion();<?php endif;?>loadTiempos();" ng-model="producciones[index].IdMaquina" required>
                            <option ng-selected="producciones[index].IdMaquina == maquina.IdMaquina" value="{{maquina.IdMaquina}}" ng-repeat="maquina in maquinas">{{maquina.ClaveMaquina}} - {{maquina.Maquina}}</option>
                        </select>
                    </div>
                </div>
                <?php if($IdSubProceso == 10):?>
                    <div class="col-md-2">
                        <div class="input-group">
                            <span id="consecutivo" class="input-group-addon">Consecutivo Horno:</span>
                                <input ng-disabled="mostrar" class="form-control" ng-model="producciones[index].lances.HornoConsecutivo" ng-value="{{producciones[index].lances.HornoConsecutivo}}"/>
                        </div>
                    </div>
                <?php endif;?>
            </div>
        <?php if($IdSubProceso == 12 || $IdSubProceso == 6 || $IdSubProceso == 2):?>
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        <span id="Empleados" class="input-group-addon">Empleado:</span>
                            <select ng-disabled="mostrar" aria-describedby="Empleados" class="form-control" ng-model="producciones[index].IdEmpleado" required>
                                <option ng-selected="producciones[index].IdEmpleado == e.IdEmpleado" ng-repeat="e in empleados" ng-value="{{e.IdEmpleado}}">{{e.NombreCompleto}}</option>
                            </select>
                    </div>
                </div>
            </div>
        <?php endif;?>
        <?php if($IdSubProceso == 10):?>
            <div class="row">
                <div class="col-md-2">
                    <div class="input-group">
                        <span id="colada" class="input-group-addon">Colada:</span>
                            <input ng-disabled="mostrar" class="form-control" ng-model="producciones[index].lances.Colada" ng-value="{{producciones[index].lances.Colada}}"/>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="input-group">
                        <span id="lance" class="input-group-addon">Lance:</span>
                        <input ng-disabled="mostrar" class="form-control" ng-model="producciones[index].lances.Lance" ng-value="{{producciones[index].lances.Lance}}"/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <span id="Aleaciones" class="input-group-addon">Aleacion:</span>
                            <select ng-disabled="mostrar" id="aleacion" aria-describedby="Aleaciones"  class="form-control" ng-model="producciones[index].lances.IdAleacion" required>
                                <option ng-selected="producciones[index].lances.IdAleacion == a.IdAleacion" ng-repeat="a in aleaciones" ng-value="{{a.IdAleacion}}">{{a.Identificador}}</option>
                            </select>
                    </div>
                </div>
            </div>
        <?php endif;?>
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
        <div class="col-md-4">
            <?php if($IdSubProceso == 2):?>
            <?= $this->render('programacionAlmas',[
                'IdSubProceso'=>$IdSubProceso,
            ]);?>
            <?php else:?>
            <?= $this->render('programacion',[
                'IdSubProceso'=>$IdSubProceso,
            ]);?>
            <?php endif?>
        </div>
        <?php if($IdSubProceso == 2):?>
        <div class="col-md-8">
            <?= $this->render('FormProduccionAlmasDetalle',[
                'IdSubProceso'=>$IdSubProceso,
            ]);?>
        </div>
        <?php else:?>
        <div <?php if($IdSubProceso != 10):?>class="col-md-5"<?php else:?>class="col-md-4"<?php endif?>>
            <?= $this->render('FormProduccionDetalle',[
                'IdSubProceso'=>$IdSubProceso,
            ]);?>
        </div>
        <?php endif?>
        <?php if($IdSubProceso == 10):?>
        <div class="col-md-4">
            <?= $this->render('FormProduccionMaterial',[
                'subProceso'=>$IdSubProceso,
            ]);?>
        </div>
        <?php elseif($IdSubProceso != 2):?>
        <div class="col-md-3">
            <?= $this->render('FormProduccionRechazo',[
                'IdSubProceso'=>$IdSubProceso,
                'titulo' => 'Rechazo Moldeo',
            ]);?>
        </div>
        <?php endif?>
    </div>
    <div class="row">
        <?php if($IdSubProceso == 6 || $IdSubProceso == 2):?>
        <div class="col-md-9">
            <?= $this->render('FormTiemposMuerto',[
                'subProceso'=>$IdSubProceso,
            ]);?>
        </div>
        <div class="col-md-3">
            <?= $this->render('FormProduccionAlmasRechazo',[
                'subProceso'=>$IdSubProceso,
                'titulo' => 'Rechazo Almas',
            ]);?>
        </div>
        <?php endif?>
        <?php if($IdSubProceso == 10):?>
        <div class="col-md-4">
            <?= $this->render('FormTemperaturas',[
                'subProceso'=>$IdSubProceso,
            ]);?>
        </div>
        <?php endif?>
    </div>
</div>