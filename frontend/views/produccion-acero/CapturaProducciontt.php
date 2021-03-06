
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
    countProduccionesAceros(<?=$IdSubProceso?>,<?=$IdArea?>);
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
	loadprogramadostt();
    loadProbetas();
	loadLances();
    loadMaquinas(produccion.IdCentroTrabajo,<?=$IdSubProceso?>,<?=$IdArea?>);
">
    <div id="encabezado" class="row">
        <div class="col-md-10">
            <form class="form-horizontal" name="editableForm" onaftersave="saveProduccion()">
                <div class="row">
                   <!-- <div  class="col-md-3" style="position:absolute; " >
                        <img ng-src="../frontend/assets/img/{{produccion.idTratamientosTermicos.ArchivoGrafica}}" width="860" height="620" >
                    </div>-->
                    <div class="col-md-6" >
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">Fecha:</span>
                                    <input ng-show="!mostrar" class="form-control input-sm" type="date" ng-value="{{produccion.Fecha}}" ng-change="produccion.Fecha = Fecha;loadProgramacion();" ng-model="Fecha" format-date/>
                                    <input ng-show="mostrar" disabled="" class="form-control input-sm" value="{{produccion.Fecha}}"/>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span id="Maquinas" class="input-group-addon"><?php if($IdSubProceso == 10):?>Horno:<?php else:?>Maquina:<?php endif;?></span>
                                    <select id="aleacion" aria-describedby="Maquinas" class="form-control input-sm" ng-change="selectMaquina();loadProgramacion();" ng-model="IdMaquina" required>
                                        <option ng-selected="produccion.IdMaquina == maquina.IdMaquina" value="{{maquina.IdMaquina}}" ng-repeat="maquina in maquinas">{{maquina.ClaveMaquina}} - {{maquina.Maquina}}</option>
                                    </select>
                                    <!--<input ng-show="mostrar" disabled="" class="form-control input-sm" value="{{produccion.idMaquina.Identificador}} - {{produccion.idMaquina.Descripcion}}"/>-->                               
                                </div>
                            </div>
                            <br><br>
                            <div class="col-md-6">                  
                                <div class="input-group">
                                    <span class="input-group-addon">Turno:</span>
                                    <select ng-disabled="mostrar" id="turnos" aria-describedby="Turnos" ng-change="loadProgramaciones()" class="form-control" ng-model="IdTurno" required>
                                        <option ng-selected="IdTurno == turno.IdTurno" value="{{turno.IdTurno}}" ng-repeat="turno in turnos">{{turno.IdTurno}} - {{turno.Descripcion}}</option>
                                    </select>                    
                                </div>
                            </div> 

                            <div class="col-md-6">
                                <div class="input-group">
                                    <span id="Maquinas" class="input-group-addon">Tipo Tratamiento:</span>
                                    <select id="aleacion" aria-describedby="Maquinas" class="form-control input-sm" ng-change="selectMaquina();loadMaquinas();showcampostt();" ng-model="IdCentroTrabajo" required>
                                        <option ng-selected="produccion.IdCentroTrabajo == centro.IdCentroTrabajo" value="{{centro.IdCentroTrabajo}}" ng-repeat="centro in centros">{{centro.Descripcion}}</option>
                                    </select>
                                    <!--<input ng-show="mostrar" disabled="" class="form-control input-sm" value="{{produccion.idCentroTrabajo.Descripcion}}"/>-->
                                </div>
                            </div>
                            <br><br>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span  class="input-group-addon">Num Trat:</span>
                                    <!--<input ng-show="mostrar" class="form-control" ng-model="produccion.idTratamientosTermicos.NoTT" ng-value="{{produccion.idTratamientosTermicos.NoTT}}"  />-->
                                    <input class="form-control input-sm" value="{{produccion.idTratamientosTermicos.NoTT}}" ng-model="produccion.idTratamientosTermicos.NoTT"/>
                                </div>
                            </div> 
                           
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span  class="input-group-addon">kw ini:</span>
                                    <input class="form-control" ng-model="produccion.idTratamientosTermicos.KWIni" value="{{produccion.idTratamientosTermicos.KWIni}}"/>
                                    <!--<input ng-show="!mostrar" class="form-control input-sm" value="{{produccion.idTratamientosTermicos.KWIni}}"/>-->
                                </div>
                            </div>
                             <br><br>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">kw fin:</span>
                                    <input class="form-control" ng-model="produccion.idTratamientosTermicos.KWFin" value="{{produccion.idTratamientosTermicos.KWFin}}"/>
                                    <!--<input ng-show="!mostrar" class="form-control input-sm" value="{{produccion.idTratamientosTermicos.KWFin}}"/>-->
                                </div>
                            </div>
                         
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span  class="input-group-addon">Tiempo ini:</span>
                                    <input class="form-control" ng-model="produccion.idTratamientosTermicos.HoraInicio" value="{{produccion.idTratamientosTermicos.HoraInicio}}"/>
                                    <!--<input ng-show="!mostrar" class="form-control input-sm" value="{{produccion.idTratamientosTermicos.HoraInicio}}"/>-->
                                </div>
                            </div>
                             <br><br>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span  class="input-group-addon">Tiempo fin:</span>
                                    <input class="form-control" ng-model="produccion.idTratamientosTermicos.HoraFin" value="{{produccion.idTratamientosTermicos.HoraFin}}"/>
                                    <!--<input ng-show="!mostrar" class="form-control input-sm" value="{{produccion.idTratamientosTermicos.HoraFin}}"/>-->
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span  class="input-group-addon">Temp1 Cº</span>
                                    <input class="form-control" ng-model="produccion.idTratamientosTermicos.Temp1" value="{{produccion.idTratamientosTermicos.Temp1}}"/>
                                    <!--<input ng-show="!mostrar" class="form-control input-sm" value="{{produccion.idTratamientosTermicos.Temp1}}"/>-->
                                </div>
                            </div>
                             <br><br>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span  class="input-group-addon">Temp2 Cº</span>
                                    <input class="form-control" ng-model="produccion.idTratamientosTermicos.Temp2" value="{{produccion.idTratamientosTermicos.Temp2}}"/>
                                    <!--<input ng-show="!mostrar" class="form-control input-sm" value="{{produccion.idTratamientosTermicos.Temp2}}"/>-->
                                </div>
                            </div>
                  
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span  class="input-group-addon">Ecofuel Consumido</span>
                                    <input class="form-control" ng-model="produccion.idTratamientosTermicos.Ecofuel" value="{{produccion.idTratamientosTermicos.Ecofuel}}"/>
                                    <!--<input ng-show="!mostrar" class="form-control input-sm" value="{{produccion.idTratamientosTermicos.Ecofuel}}"/>-->
                                </div>
                            </div>
                             <br><br>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span  class="input-group-addon">Total KG Piezas</span>
                                    <input class="form-control" ng-model="produccion.idTratamientosTermicos.TotalKG" value="{{produccion.idTratamientosTermicos.TotalKG}}"/>
                                    <!--<input ng-show="!mostrar" class="form-control input-sm" value="{{produccion.idTratamientosTermicos.TotalKG}}"/>-->
                                </div>
                            </div>
                                                
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span id="enfriamiento" class="input-group-addon">Tipo Enfriamiento:</span>
                                    <select aria-describedby="Turnos" class="form-control input-sm" ng-model="IdTipoEnfriamiento" required>
                                        <option ng-selected="IdTipoEnfriamiento == e.IdTipoEnfriamiento" ng-repeat="e in enfriamientos" ng-value="{{e.IdTipoEnfriamiento}}">{{e.Descripcion}}</option>
                                    </select>
                                    <!--<input ng-show="mostrar" class="form-control input-sm" value="{{produccion.idTratamientosTermicos.idTipoEnfriamiento.Descripcion}}"/>-->
                                </div>
                            </div>
                             <br><br>
                            <div ng-show = "campostt" class="col-md-6">
                                 <div class="input-group">
                                    <span  class="input-group-addon">Te Deposito</span>
                                    <input ng-show="mostrar" class="form-control" ng-model="produccion.idTratamientosTermicos.TempEntradaDeposito" ng-value="{{produccion.idTratamientosTermicos.TempEntradaDeposito}}"/>
                                    <input ng-show="!mostrar" class="form-control input-sm" value="{{produccion.idTratamientosTermicos.TempEntradaDeposito}}"/>
                                </div>
                            </div>
                    
                            <div ng-show = "campostt" class="col-md-6">
                                 <div class="input-group">
                                    <span  class="input-group-addon">Te Deposito Salida </span>
                                    <input class="form-control" ng-model="produccion.idTratamientosTermicos.TempSalidaDeposito" value="{{produccion.idTratamientosTermicos.TempSalidaDeposito}}"/>
                                    <!--<input ng-show="!mostrar" class="form-control input-sm" value="{{produccion.idTratamientosTermicos.TempSalidaDeposito}}"/>-->
                                </div>
                            </div>
                             <br><br>
                            <div ng-show = "campostt" class="col-md-6">
                                 <div class="input-group">
                                    <span  class="input-group-addon">Tie de Enfriamiento  </span>
                                    <input class="form-control" ng-model="produccion.idTratamientosTermicos.TiempoEnfriamiento" value="{{produccion.idTratamientosTermicos.TiempoEnfriamiento}}"/>
                                    <!--<input ng-show="!mostrar" class="form-control input-sm" value="{{produccion.idTratamientosTermicos.TiempoEnfriamiento}}"/>-->
                                </div>
                            </div>                          
                            
                            <div ng-show = "campostt" class="col-md-6">
                                 <div class="input-group">
                                    <span  class="input-group-addon">Te pza. Deposito  </span>
                                    <input class="form-control" ng-model="produccion.idTratamientosTermicos.TempPzDepositoIn" value="{{produccion.idTratamientosTermicos.TempPzDepositoIn}}"/>
                                    <!--<input ng-show="!mostrar" class="form-control input-sm" value="{{produccion.idTratamientosTermicos.TempPzDepositoIn}}"/>-->
                                </div>
                            </div>
                             <br><br>
                            <div ng-show = "campostt" class="col-md-6">
                                 <div class="input-group">
                                    <span  class="input-group-addon">Te pza. Deposito Salida  </span>
                                    <input class="form-control" ng-model="produccion.idTratamientosTermicos.TempPzDepositoOut" value="{{produccion.idTratamientosTermicos.TempPzDepositoOut}}"/>
                                    <!--<input ng-show="!mostrar" class="form-control input-sm" value="{{produccion.idTratamientosTermicos.TempPzDepositoOut}}"/>-->
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="input-group">
                                    <span id="idOperador" class="input-group-addon">Relializo:</span>
                                    <select aria-describedby="produccion.idTratamientosTermicos.idOperador" class="form-control input-sm" ng-model="produccion.idTratamientosTermicos.idOperador.IdEmpleado" required>
                                        <option ng-selected="produccion.idTratamientosTermicos.idOperador.IdEmpleado == e.IdEmpleado" ng-repeat="e in empleados" ng-value="{{e.IdEmpleado}}">{{e.NombreCompleto}}</option>
                                    </select>
                                    <!--<input ng-show="mostrar" disabled="" class="form-control input-sm" value="{{produccion.idTratamientosTermicos.idOperador.ApellidoMaterno  + produccion.idTratamientosTermicos.idOperador.Nombre}}"/>-->
                                </div>
                            </div>
                            <br><br>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span id="Empleados" class="input-group-addon">Aprobo:</span>
                                    <select aria-describedby="Empleados" class="form-control input-sm" ng-model="produccion.idTratamientosTermicos.idAprobo.IdEmpleado" required>
                                        <option ng-selected="produccion.idTratamientosTermicos.idAprobo.IdEmpleado == e.IdEmpleado" ng-repeat="e in empleados" ng-value="{{e.IdEmpleado}}">{{e.NombreCompleto}}</option>
                                    </select>
                                    <!--<input ng-show="mostrar" disabled="" class="form-control input-sm" value="{{ produccion.idTratamientosTermicos.idAprobo.ApellidoMaterno  + produccion.idTratamientosTermicos.idAprobo.Nombre }}"/>-->
                                </div>
                            </div> 
                             <div class="col-md-6">
                                <div class="input-group">
                                    <span id="Empleados" class="input-group-addon">Superviso:</span>
                                    <select aria-describedby="Empleados" class="form-control input-sm" ng-model="produccion.idTratamientosTermicos.idSuperviso.IdEmpleado" required>
                                        <option ng-selected="produccion.idTratamientosTermicos.idSuperviso.IdEmpleado == e.IdEmpleado" ng-repeat="e in empleados" ng-value="{{e.IdEmpleado}}">{{e.NombreCompleto}}</option>
                                    </select>
                                    <!--<input ng-show="mostrar" disabled="" class="form-control input-sm" value="{{produccion.idTratamientosTermicos.idSuperviso.ApellidoMaterno  + produccion.idTratamientosTermicos.idSuperviso.Nombre}}"/>-->
                                </div>
                            </div>
                             <br><br>
                            <div  class="col-md-12">
                                 <div class="input-group">
                                    <span class="input-group-addon">Observaciones </span>
                                    <textarea aria-describedby="Observaciones" class="form-control input-sm" ng-model="Observaciones">hola {{produccion.Observaciones}}</textarea>
                                    <!--<input ng-show="!mostrar" class="form-control input-sm" ng-model="Observaciones" />
                                    <input ng-show="mostrar" disabled="" class="form-control input-sm" ng-model="produccion.idTratamientosTermicos.Observaciones" />-->
                                </div>
                            </div> 
                   
                    </div>

                    <div class="col-md-6" >
                         <div  class="col-md-6">
                            <span>Seleccione Imagen </span>
                            <input ng-show="!mostrar" class="file" ng-file-select="onFileSelect($files)" ng-value="{{produccion.idTratamientosTermicos.ArchivoGrafica}}" type="file" ng-model="imagen" id="imagen" name="file" >
                            <input ng-show="mostrar" class="file" type="file" name="file" ng-value="{{produccion.idTratamientosTermicos.ArchivoGrafica}}" >
                        </div>
                        <img ng-src="../frontend/assets/img/{{produccion.idTratamientosTermicos.ArchivoGrafica}}" width="760" height="520" >
                    </div>
                    
                    <div class="row" style="margin-top:65px">
                        <div class="col-md-12">
                            <button class="btn btn-primary" ng-click="addTratamientos();mostrar=false" ng-show="mostrar">Nuevo Registro</button>
                            <button class="btn btn-primary" ng-click="SaveTratamientos();mostrar=true" ng-show="!mostrar">Generar</button>
                            <button class="btn btn-success" ng-click="loadProduccion();mostrar=true" ng-show="!mostrar">Cancelar</button>
                            <button class="btn btn-success" ng-click="SaveTratamientos();" ng-show="mostrar">Guardar</button>
                            <button class="btn btn-primary" ng-click="updateTratamientos();" ng-show="mostrar">Editar</button>
                            <button class="btn btn-danger" ng-click="deleteProducciones();" ng-show="mostrar">Eliminar</button>
                            <button class="btn" ng-click="produccion.IdProduccionEstatus=2;saveProduccion();" ng-show="mostrar">Cerrar Captura</button>
                            <button title="Buscar" class="btn" ng-click="buscar();" >Buscar</button>
                        </div>
                </div>
                <div class="row" style="margin-bottom:15px">
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
   
    
       <div class= 'row'>
		
			 <div class="col-md-5">
            <?= $this->render('FormProduccionDetalleTT',[
                'IdSubProceso'=>$IdSubProceso,
            ]);?>
			</div>
			<div class="col-md-3">
            <?= $this->render('FormProduccionSeriesTT',[
                'IdSubProceso'=>$IdSubProceso,
            ]);?>
			</div>
	   </div>
		
	   <div class= 'row'>
		
			 <div class="col-md-5">
            <?= $this->render('FormProduccionDetalleprobetas',[
                'IdSubProceso'=>$IdSubProceso,
            ]);?>
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