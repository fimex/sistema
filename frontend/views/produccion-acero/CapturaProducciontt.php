
<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\URL;

$title = '';

switch($IdSubProceso){
    case 19:
        $title = "Normalizado";
        break;
    case 20:
        $title = "Revenido";
        break;
    case 21:
        $title = "Temple";
        break;
    case 2:
        $title = "Solubilizado";
        break;
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
<div class="container-fluid" ng-controller="ProduccionAceros" ng-init="
    Fecha = '<?=date('Y-m-d G:i:s');?>';
    IdTurno = 1;
    countProducciones(<?=$IdSubProceso?>,<?=$IdArea?>);
    IdSubProceso = <?=$IdSubProceso?>;
    IdArea = <?=$IdArea?>;
    loadProgramacion(true);
    <?=$IdEmpleado == null ? "" : "    produccion.IdEmpleado = $IdEmpleado;"?>
    loadCentros();
    loadFallas();
    loadDefectos();
    loadTurnos();
    loadEmpleados('1-7');
	loadenfriamientos();

   
">
    <div id="encabezado" class="row">
        <div class="col-md-10">
            <form class="form-horizontal" name="editableForm" onaftersave="saveProduccion()">
                <div class="row">
				
					
		
					<div class="col-md-2">
                        <div class="input-group">
                            <span id="Maquinas" class="input-group-addon">Tipo Tratamiento:</span>
                            <select ng-show="!mostrar" id="aleacion" aria-describedby="Maquinas" class="form-control input-sm" ng-change="selectMaquina();loadMaquinas();" ng-model="IdCentroTrabajo" required>
                                <option ng-selected="produccion.IdCentroTrabajo == centro.IdCentroTrabajo" value="{{centro.IdCentroTrabajo}}" ng-repeat="centro in centros">{{centro.Descripcion}}</option>
                            </select>
                            <input ng-show="mostrar" disabled="" class="form-control input-sm" value="{{produccion.idCentroTrabajo.Descripcion}}"/>
                        </div>
                    </div>
					<div class="col-md-2">
                        <div class="input-group">
                            <span id="kwini" class="input-group-addon">Num Trat:</span>
                            <input  class="form-control input-sm" ng-model="NoTT" value="{{tratamientos.NoTT}}"/>
                        </div>
                    </div>
				
                    <div class="col-md-2">
                        <div class="input-group">
                            <span class="input-group-addon">Fecha:</span>
                            <input ng-show="!mostrar" class="form-control input-sm" type="date" ng-change="produccion.Fecha = Fecha;loadProgramacion();" ng-model="Fecha" format-date/>
                            <input ng-show="mostrar" disabled="" class="form-control input-sm" value="{{produccion.Fecha}}"/>
                        </div>
                    </div>
                    
                   
                    <div class="col-md-2">
                        <div class="input-group">
                            <span id="Maquinas" class="input-group-addon"><?php if($IdSubProceso == 10):?>Horno:<?php else:?>Maquina:<?php endif;?></span>
                            <select ng-show="!mostrar" id="aleacion" aria-describedby="Maquinas" class="form-control input-sm" ng-change="selectMaquina();loadProgramacion();" ng-model="IdMaquina" required>
                                <option ng-selected="produccion.IdMaquina == maquina.IdMaquina" value="{{maquina.IdMaquina}}" ng-repeat="maquina in maquinas">{{maquina.ClaveMaquina}} - {{maquina.Maquina}}</option>
                            </select>
                            <input ng-show="mostrar" disabled="" class="form-control input-sm" value="{{produccion.idMaquina.Identificador}} - {{produccion.idMaquina.Descripcion}}"/>
                        </div>
                    </div>
                    
                   
                    
                    <div class="col-md-2">
                        <div class="input-group">
                            <span id="Turnos" class="input-group-addon">Turno:</span>
                            <select ng-show="!mostrar" aria-describedby="Turnos" class="form-control input-sm" ng-model="IdTurno" required>
                                <option ng-selected="produccion.IdTurno == t.IdTurno" ng-repeat="t in turnos" ng-value="{{t.IdTurno}}">{{t.Descripcion}}</option>
                            </select>
                            <input ng-show="mostrar" disabled="" class="form-control input-sm" value="{{produccion.idTurno.Descripcion}}"/>
                        </div>
                    </div>
					
									 
					
                    <br><br>
					
					<div class="col-md-2">
                        <div class="input-group">
                            <span id="kwini" class="input-group-addon">kw ini:</span>
                            <input  class="form-control input-sm" ng-model="KWIni" value="{{tratamientos.KWIni}}"/>
                        </div>
                    </div>
					<div class="col-md-2">
                        <div class="input-group">
                            <span id="kwfin" class="input-group-addon">kw fin:</span>
                            <input  class="form-control input-sm" ng-model="KWFin" value="{{tratamientos.KWFin}}"/>
                        </div>
                    </div>
					<div class="col-md-2">
                        <div class="input-group">
                            <span id="kwini" class="input-group-addon">Tiempo ini:</span>
                            <input  class="form-control input-sm" ng-model="HoraInicio" value="{{tratamientos.HoraInicio}}"/>
                        </div>
                    </div>
					<div class="col-md-2">
                        <div class="input-group">
                            <span id="kwfin" class="input-group-addon">Tiempo fin:</span>
                            <input  class="form-control input-sm" ng-model="Horafin" value="{{tratamientos.Horafin}}"/>
                        </div>
                    </div>
					
                    <br><br>
					
					<div class="col-md-2">
                        <div class="input-group">
                            <span id="temp1" class="input-group-addon">Temp1 Cº</span>
                            <input  class="form-control input-sm" ng-model="Temp1" value="{{tratamientos.Temp1}}"/>
                        </div>
                    </div>
					
					<div class="col-md-2">
                        <div class="input-group">
                            <span id="temp2" class="input-group-addon">Temp2 Cº</span>
                            <input  class="form-control input-sm" ng-model="Temp2" value="{{tratamientos.Temp2}}"/>
                        </div>
                    </div>
					
					<div class="col-md-2">
                        <div class="input-group">
                            <span id="ecofuel" class="input-group-addon">Ecofuel Consumido</span>
                            <input  class="form-control input-sm" ng-model="Ecofuel" value="{{tratamientos.Ecofuel}}"/>
                        </div>
                    </div>
					
										
                    <br><br>
					
					<div class="col-md-2">
                        <div class="input-group">
                            <span id="totalkg" class="input-group-addon">Total KG Piezas</span>
                            <input  class="form-control input-sm" ng-model="TotalKG" value="{{tratamientos.TotalKG}}"/>
                        </div>
                    </div>
					
					<div class="col-md-4">
                        <div class="input-group">
                            <span id="archivoGraficas" class="input-group-addon">Archivo de Graficas</span>
                            <input  class="form-control input-sm" ng-model="archivoGrafica" value="{{tratamientos.archivoGrafica}}"/>
                        </div>
                    </div>
					
					<div class="col-md-3">
                        <div class="input-group">
                            <span id="enfriamiento" class="input-group-addon">Tipo Enfriamiento:</span>
                            <select ng-show="!mostrar" aria-describedby="Turnos" class="form-control input-sm" ng-model="IdTurno" required>
                                <option ng-selected="IdTipoEnfriamiento == e.IdTipoEnfriamiento" ng-repeat="e in enfriamientos" ng-value="{{e.IdTipoEnfriamiento}}">{{e.Descripcion}}</option>
                            </select>
                            <input ng-show="mostrar" disabled="" class="form-control input-sm" value="{{tratamientos.IdTurno}}"/>
                        </div>
                    </div>
					
                    
					<?php if($IdSubProceso == 21 || $IdSubProceso == 22 ):?>
                    <br><br>
					
					<div class="col-md-3">
                        <div class="input-group">
                            <span id="TempEntradaDeposito" class="input-group-addon">Temp deposito</span>
                            <input  class="form-control input-sm" ng-model="TempEntradaDeposito" value="{{tratamientos.TempEntradaDeposito}}"/>
                        </div>
                    </div>
					
					<div class="col-md-3">
                        <div class="input-group">
                            <span id="TempSalidaDeposito" class="input-group-addon">Temp deposito salida </span>
                            <input  class="form-control input-sm" ng-model="TempSalidaDeposito" value="{{tratamientos.TempSalidaDeposito}}"/>
                        </div>
                    </div>
					
					<div class="col-md-3">
                        <div class="input-group">
                            <span id="TiempoEnfriamiento" class="input-group-addon">Tiempo de enfriamiento </span>
                            <input  class="form-control input-sm" ng-model="TiempoEnfriamiento" value="{{tratamientos.TiempoEnfriamiento}}"/>
                        </div>
                    </div>
				
					<br><br>
					
					<div class="col-md-3">
                        <div class="input-group">
                            <span id="TempPzDepositoIn" class="input-group-addon">Temp pza. deposito</span>
                            <input  class="form-control input-sm" ng-model="TempPzDepositoIn" value="{{tratamientos.TempPzDepositoIn}}"/>
                        </div>
                    </div>
					
					<div class="col-md-3">
                        <div class="input-group">
                            <span id="TempPzDepositoOut" class="input-group-addon">Temp pza deposito salida </span>
                            <input  class="form-control input-sm" ng-model="TempPzDepositoOut" value="{{tratamientos.TempPzDepositoOut}}"/>
                        </div>
                    </div>
					
					
					<?php endif?>
					
					<br><br>
					 <div class="col-md-3">
                        <div class="input-group">
                            <span id="idOperador" class="input-group-addon">Relializo:</span>
                            <select ng-show="!mostrar" aria-describedby="idOperador" class="form-control input-sm" ng-model="idOperador" required>
                                <option ng-selected="tratamientos.idOperador == e.IdEmpleado" ng-repeat="e in empleados" ng-value="{{e.IdEmpleado}}">{{e.NombreCompleto}}</option>
                            </select>
                            <input ng-show="mostrar" disabled="" class="form-control input-sm" value="{{tratamientos.idOperador.ApellidoPaterno}} {{produccion.idEmpleado.ApellidoMaterno}} {{produccion.idEmpleado.Nombre}}"/>
                        </div>
                    </div>
					 <div class="col-md-3">
                        <div class="input-group">
                            <span id="Empleados" class="input-group-addon">Aprobo:</span>
                            <select ng-show="!mostrar" aria-describedby="Empleados" class="form-control input-sm" ng-model="idAprobo" required>
                                <option ng-selected="tratamientos.idAprobo == e.IdEmpleado" ng-repeat="e in empleados" ng-value="{{e.IdEmpleado}}">{{e.NombreCompleto}}</option>
                            </select>
                          
                            <input ng-show="mostrar" disabled="" class="form-control input-sm" value="{{tratamientos.idAprobo.ApellidoPaterno}} {{produccion.idEmpleado.ApellidoMaterno}} {{produccion.idEmpleado.Nombre}}"/>
                        </div>
                    </div>
					 <div class="col-md-3">
                        <div class="input-group">
                            <span id="Empleados" class="input-group-addon">Superviso:</span>
                            <select ng-show="!mostrar" aria-describedby="Empleados" class="form-control input-sm" ng-model="idSuperviso" required>
                                <option ng-selected="tratamientos.idSuperviso == e.IdEmpleado" ng-repeat="e in empleados" ng-value="{{e.IdEmpleado}}">{{e.NombreCompleto}}</option>
                            </select>
                            <input ng-show="mostrar" disabled="" class="form-control input-sm" value="{{tratamientos.idSuperviso.ApellidoPaterno}} {{produccion.idEmpleado.ApellidoMaterno}} {{produccion.idEmpleado.Nombre}}"/>
                        </div>
                    </div>
                    <br><br>
                    <div class="col-md-4">
                        <div class="input-group">
                            <span id="Observaciones" class="input-group-addon">Observaciones:</span>
                            <textarea aria-describedby="Observaciones" class="form-control input-sm" ng-model="Observaciones">{{produccion.Observaciones}}</textarea>
                        </div>
                    </div>
                </div>
                
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-primary" ng-click="addProduccion();mostrar=false" ng-show="mostrar">Nuevo Registro</button>
                        <button class="btn btn-primary" ng-click="SaveTratamientos();mostrar=true" ng-show="!mostrar">Generar</button>
                        <button class="btn btn-success" ng-click="loadProduccion();mostrar=true" ng-show="!mostrar">Cancelar</button>
                        <button class="btn btn-success" ng-click="SaveTratamientos();" ng-show="mostrar">Guardar</button>
                        <button class="btn btn-danger" ng-click="deleteProducciones();" ng-show="mostrar">Eliminar</button>
                        <button class="btn" ng-click="produccion.IdProduccionEstatus=2;saveProduccion();" ng-show="mostrar">Cerrar Captura</button>
                        
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
                    <th>Empleado
                        <br /><input class="form-control" ng-model="filtro.Empleado">
                    </th>
                    <th>Maquina
                        <br /><input class="form-control" ng-model="filtro.Maquina">
                    </th>
                    <th>Producto
                        <br /><input class="form-control" ng-model="filtro.Producto">
                    </th>
                  
                </tr>
            </thead>
            <tbody>
                <tr
                    ng-class="{'info': index == busqueda.index}"
                    ng-repeat="busqueda in busquedas | filter:filtro">
                    <td><button class="btn" ng-click="show(busqueda.index);">Ver</button></td>
                    <td>{{busqueda.Semana}}</td>
                    <td>{{busqueda.Fecha | date:'dd-MMM-yyyy'}}</td>
                    <td>{{busqueda.Empleado}}</td>
                    <td>{{busqueda.Maquina}}</td>
                    <td>{{busqueda.Producto}}</td>
                   
                </tr>
            </tbody>
        </table></div>
    </modal>

</div>