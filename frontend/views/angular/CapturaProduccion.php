
<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\URL;

$title = '';
if($IdArea == 3)
switch($IdSubProceso){
    case 6:
        $title = "Control de Fallas Robert Sinto y FDNX F-PC-7.0-31/05";
        break;
    case 2:
        $title = "Reporte de producción en las corazoneras  F-PC-7.0-02/6";
        break;
    case 10:
        $title = "Material vaciado F-PC-7.0-05/6";
        break;
    case 3:
        $title = "Rebabeo y ensamble almas ( Bronce ) F-PC-7.0-51/1";
        break;
}

if($IdArea == 2){
    switch($IdSubProceso){
        case 2:
            $title = "Reporte de producción Almas ( ACEROS )";
            break;

        case 4:
            $title = "Pintado Almas ( ACEROS ) ";
            break;
    }
}


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
<h4 style="margin-top:0;"><?=$title?></h4>
<div class="container-fluid" ng-controller="Produccion" ng-init="
    Fecha = '<?=strtotime(date('G:i:s')) < strtotime('06:00') ? date('Y-m-d', strtotime('-1 day',strtotime(date('Y-m-d')))) : date('Y-m-d');?>';
    IdTurno = 1;
    countProducciones(<?=$IdSubProceso?>,<?=$IdArea?>);
    IdSubProceso = <?=$IdSubProceso?>;
    IdArea = <?=$IdArea?>;
    loadProgramacion(true);
    <?=$IdEmpleado == null ? "" : "    produccion.IdEmpleado = $IdEmpleado;"?>
    loadCentros();<?php if($IdSubProceso != 12):?>
        loadMaquinas();
    <?php else:?>
        loadCentros();
    <?php endif?>
    loadFallas();
    loadDefectos();
    loadMaterial();
    loadTurnos();
    <?php if($IdSubProceso == 12 || $IdSubProceso == 16):?>
        loadEmpleados('2-6');
    <?php endif?>
    <?php if($IdSubProceso == 16):?>
        loadEmpleados('2-6');
    <?php endif?>
   <?php if( ($IdSubProceso == 2 || $IdSubProceso == 3)  && $IdArea == 3 ):?>
        loadEmpleados('2-1');
    <?php endif?>
	<?php if( ($IdSubProceso == 2 || $IdSubProceso == 4)  && $IdArea == 2 ):?>
        loadEmpleados('1-1');
    <?php endif?>
    <?php if($IdSubProceso == 6 || $IdSubProceso == 10):?>
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
                    <div class="col-md-2">
                        <div class="input-group">
                            <span class="input-group-addon">Fecha:</span>
                            <input ng-show="!mostrar" class="form-control input-sm" type="date" ng-change="produccion.Fecha = Fecha;loadProgramacion();" max="<?=strtotime(date('G:i:s')) < strtotime('06:00') ? date('Y-m-d', strtotime('-1 day',strtotime(date('Y-m-d')))) : date('Y-m-d');?>" ng-model="Fecha" format-date/>
                            <input ng-show="mostrar" disabled="" class="form-control input-sm" value="{{produccion.Fecha}}"/>
                        </div>
                    </div>
                    <?php if($IdSubProceso == 3 || $IdSubProceso == 19 || $IdSubProceso == 12):?>
                    <div class="col-md-2">
                        <div class="input-group">
                            <span id="Maquinas" class="input-group-addon">Proceso:</span>
                            <select ng-show="!mostrar" id="aleacion" aria-describedby="Maquinas" class="form-control input-sm" ng-change="produccion.IdCentroTrabajo = IdCentroTrabajo;loadMaquinas();loadProgramacion();" ng-model="IdCentroTrabajo" required>
                                <option ng-selected="produccion.IdCentroTrabajo == centro.IdCentroTrabajo" value="{{centro.IdCentroTrabajo}}" ng-repeat="centro in centros">{{centro.Descripcion}}</option>
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
                                <option ng-selected="IdMaquina == maquina.IdMaquina" value="{{maquina.IdMaquina}}" ng-repeat="maquina in maquinas">{{maquina.ClaveMaquina}} - {{maquina.Maquina}}</option>
                            </select>
                            <input ng-show="mostrar" disabled="" class="form-control input-sm" value="{{produccion.idMaquina.Identificador}} - {{produccion.idMaquina.Descripcion}}"/>
                        </div>
                    </div>
                    <?php endif;?>
                    <?php if($IdSubProceso == 12 || $IdSubProceso == 6 || $IdSubProceso == 2 || $IdSubProceso == 16 || $IdSubProceso == 3 ||  $IdSubProceso == 4):?>
                    <div class="col-md-3">
                        <div class="input-group">
                            <span id="Empleados" class="input-group-addon">Empleado:</span>
                            <select ng-show="!mostrar" aria-describedby="Empleados" class="form-control input-sm" ng-model="IdEmpleado" required>
                                <option ng-selected="produccion.IdEmpleado == e.IdEmpleado" ng-repeat="e in empleados" ng-value="{{e.IdEmpleado}}">{{e.NombreCompleto}}</option>
                            </select>
                            <input ng-show="mostrar" disabled="" class="form-control input-sm" value="{{produccion.idEmpleado.ApellidoPaterno}} {{produccion.idEmpleado.ApellidoMaterno}} {{produccion.idEmpleado.Nombre}}"/>
                        </div>
                    </div>
                    <?php endif;?>
                    <div class="col-md-2">
                        <div class="input-group">
                            <span id="Turnos" class="input-group-addon">Turno:</span>
                            <select ng-show="!mostrar" aria-describedby="Turnos" class="form-control input-sm" ng-model="IdTurno" required>
                                <option ng-selected="IdTurno == t.IdTurno" ng-repeat="t in turnos" ng-value="{{t.IdTurno}}">{{t.Descripcion}}</option>
                            </select>
                            <input ng-show="mostrar" disabled="" class="form-control input-sm" value="{{produccion.idTurno.Descripcion}}"/>
                        </div>
                    </div>
                    <br><br>
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
                            <span id="consecutivo" class="input-group-addon">Cons Horno:</span>
                            <input ng-show="mostrar" class="form-control input-sm" ng-model="produccion.lances.HornoConsecutivo" ng-value="{{produccion.lances.HornoConsecutivo}}"/>
                            <input ng-show="!mostrar" disabled="" class="form-control input-sm" value="{{produccion.lances.HornoConsecutivo}}"/>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group">
                            <span id="colada" class="input-group-addon">Colada:</span>
                            <input ng-show="mostrar" class="form-control" ng-model="produccion.lances.Colada" ng-value="{{produccion.lances.Colada}}"/>
                            <input ng-show="!mostrar" disabled="" class="form-control input-sm" value="{{produccion.lances.Colada}}"/>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group">
                            <span id="lance" class="input-group-addon">Lance:</span>
                            <input ng-show="mostrar" class="form-control" ng-model="produccion.lances.Lance" ng-value="{{produccion.lances.Lance}}"/>
                            <input ng-show="!mostrar" disabled="" class="form-control input-sm" value="{{produccion.lances.Lance}}"/>
                        </div>
                    </div>
                </div>
                <?php endif;?>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-primary" ng-click="addProduccion();mostrar=false" ng-show="mostrar">Nuevo Registro</button>
                        <button class="btn btn-primary" ng-click="findProduccion();mostrar=true" ng-show="!mostrar">Generar</button>
                        <button class="btn btn-success" ng-click="loadProduccion();mostrar=true" ng-show="!mostrar">Cancelar</button>
                        <button class="btn btn-success" ng-click="updateProduccion();getChanges();saveChanges();" ng-show="mostrar">Guardar</button>
                        <button class="btn btn-danger" ng-click="deleteProducciones();" ng-show="mostrar">Eliminar</button>
                        <button class="btn" ng-click="produccion.IdProduccionEstatus=2;saveProduccion();" ng-show="mostrar">Cerrar Captura</button>
                        <?php if($IdSubProceso == 10):?>
                        <button ng-click="buscar2();" class="btn btn-info">Mantenimiento de Hornos</button>
                        <?php endif;?>
                        <button title="Buscar" class="btn" ng-click="buscar();" >Buscar</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button title="Primer Registro" class="btn btn-default btn-sg" ng-click="First();" ng-disabled="!mostrar"><span class="glyphicon glyphicon-step-backward" aria-hidden="true"></span></button>
                        <button title="Registro Anterior" class="btn btn-default btn-sg" ng-click="Prev();" ng-disabled="!mostrar"><span class="glyphicon glyphicon-backward" aria-hidden="true"></span></button>
                        <b>Registro: {{index+1}} de {{producciones.length}}</b>
                        <button title="Siguiente Registro" class="btn btn-default btn-sg" ng-click="Next();" ng-disabled="!mostrar"><span class="glyphicon glyphicon-forward" aria-hidden="true"></span></button>
                        <button title="Ultimo Registro" class="btn btn-default btn-sg" ng-click="Last();" ng-disabled="!mostrar"><span class="glyphicon glyphicon-step-forward" aria-hidden="true"></span></button>
                        <b>Semana: {{produccion.Semana}}</b>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <hr />
        <div>
            <alert ng-repeat="alert in alerts" type="{{alert.type}}" close="closeAlert($index)">{{alert.msg}}</alert>
        </div>
    </div>
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
        <?php if($IdArea == 3): ?>
        <div class="col-md-4">
            <?= $this->render('FormTemperaturas',[
                'IdSubProceso'=>$IdSubProceso,
            ]);?>
        </div>
        <?php endif;?>
    </div>
    <?php endif?>
    <?php if($IdSubProceso == 3|| $IdSubProceso == 4):?>
    <div class="row">
        <div class="col-md-4" style="height: 700px;">
            <?= $this->render('programacionAlmas',[
                'IdSubProceso'=>$IdSubProceso,
            ]);?>
        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <?= $this->render('FormProduccionAlmasDetalle',[
                        'IdSubProceso'=>$IdSubProceso,
                    ]);?>
                </div>
                <div class="col-md-6">
                    <?= $this->render('FormProduccionAlmasRechazo',[
                        'IdSubProceso'=>$IdSubProceso,
                        'titulo' => 'Rechazo Almas',
                    ]);?>
                </div>
            </div>
            <div class="row">
                <?= $this->render('FormTiemposMuerto',[
                    'IdSubProceso'=>$IdSubProceso,
                ]);?>
            </div>
        </div>
    </div>
    <?php endif?>
    <?php if($IdSubProceso == 6):?>
    <div class="row">
        <div class="col-md-4">
            <?= $this->render('programacion',[
                'IdSubProceso'=>$IdSubProceso,
            ]);?>
        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-8">
                    <?= $this->render('FormProduccionDetalle',[
                        'IdSubProceso'=>$IdSubProceso,
                    ]);?>
                </div>
                <div class="col-md-4">
                    <?= $this->render('FormProduccionRechazo',[
                        'IdSubProceso'=>$IdSubProceso,
                        'titulo' => 'Rechazo Moldeo',
                    ]);?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?= $this->render('FormTiemposMuerto',[
                            'subProceso'=>$IdSubProceso,
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
    <?php if($IdSubProceso == 12):?>
    <div class="row">
        <div class="col-md-4">
            <?= $this->render('programacion',[
                'IdSubProceso'=>$IdSubProceso,
            ]);?>
        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-8">
                    <?= $this->render('FormProduccionDetalle',[
                        'IdSubProceso'=>$IdSubProceso,
                    ]);?>
                </div>
                <div class="col-md-4">
                    <?= $this->render('FormProduccionRechazo',[
                        'IdSubProceso'=>$IdSubProceso,
                        'titulo' => 'Rechazo Moldeo',
                    ]);?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?= $this->render('FormTiemposMuerto',[
                            'subProceso'=>$IdSubProceso,
                        ]);?>
                </div>
            </div>
        </div>
    </div>
    <?php endif?>
    <modal title="Buscar Produccion" visible="showModal">
        <div style="height: 400px;overflow: auto;"><table class="table table-bordered table-responsive">
            <thead>
                <tr>
                    <th></th>
                    <th>Semana
                        <br /><input class="form-control" ng-model="filtro.Semana">
                    </th>
                    <th>Fecha
                        <br /><input class="form-control" ng-model="filtro.Fecha">
                    </th>
                    <th>Turno
                        <br /><input class="form-control" ng-model="filtro.Turno">
                    </th>
                    <th ng-show="IdSubProceso == 10">Lance
                        <br /><input class="form-control" ng-model="filtro.Lance">
                    </th>
                    <th>Empleado
                        <br /><input class="form-control" ng-model="filtro.Empleado">
                    </th>
                    <th>Maquina
                        <br /><input class="form-control" ng-model="filtro.Maquina">
                    </th>
                    <th>Producto
                        <br /><input class="form-control" ng-model="filtro.Producto">
                    </th>
                    <th>Buenas</th>
                    <th>Rechazadas</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    ng-class="{'info': index == busqueda.index}"
                    ng-repeat="busqueda in busquedas | filter:filtro">
                    <td><button class="btn" ng-click="show(busqueda.index);">Ver</button></td>
                    <td>{{busqueda.Semana}}</td>
                    <td>{{busqueda.Fecha | date:'dd-MMM-yyyy'}}</td>
                    <td>{{busqueda.Turno}}</td>
                    <td ng-show="IdSubProceso == 10">{{busqueda.Lance}}</td>
                    <td>{{busqueda.Empleado}}</td>
                    <td>{{busqueda.Maquina}}</td>
                    <td>{{busqueda.Producto}}</td>
                    <td>{{busqueda.Hechas}}</td>
                    <td>{{busqueda.Rechazadas}}</td>
                </tr>
            </tbody>
        </table></div>
    </modal>
    <modal title="Registro de mantenimiento de hornos" visible="showModal2">
        <?= $this->render('MantenimientoHornos',[
            'IdSubProceso'=>$IdSubProceso,
        ]);?>
    </modal>
</div>