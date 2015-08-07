<?php
	use yii\helpers\Html;
	use yii\helpers\URL;
	$this->title = $title;
?>

<div ng-controller="ProduccionAceros" ng-init="
		countProduccionesAceros(<?=$IdSubProceso?>);
	    IdSubProceso = <?=$IdSubProceso?>;
	    IdAreaAct = 1;
	    loadMaquinas();
	    loadPartesMolde();
	    <?php if($IdSubProceso == 6):?>
	        loadEmpleados(['1-2']);
	    <?php endif?>
		">
	<h3>Cerrado Kloster</h3>
	<section class="row">
		<article class="col-md-4">
			<div class="input-group">
                <span class="input-group-addon">Fecha:</span>
                <input ng-show="!mostrar" class="form-control input-sm" type="date" ng-change="produccion.Fecha = Fecha;loadProgramacion();" ng-model="Fecha"/>
                <input ng-show="mostrar" disabled="" class="form-control input-sm" value="{{produccion.Fecha}}"/>
            </div>
		</article>
		<article class="col-md-4">
			<div class="input-group">
                <span id="Empleados" class="input-group-addon">Empleado:</span>
                <select ng-show="!mostrar" aria-describedby="Empleados" class="form-control input-sm" ng-model="IdEmpleado" required>
                    <option ng-selected="produccion.IdEmpleado == e.IdEmpleado" ng-repeat="e in empleados" ng-value="{{e.IdEmpleado}}">{{e.NombreCompleto}}</option>
                </select>
                <input ng-show="mostrar" disabled="" class="form-control input-sm" value="{{produccion.idEmpleado.ApellidoPaterno}} {{produccion.idEmpleado.ApellidoMaterno}} {{produccion.idEmpleado.Nombre}}"/>
            </div>
		</article>
		<article class="col-md-4">
			<div class="input-group">
            	<span id="Observaciones" class="input-group-addon">Observaciones:</span>
                <textarea aria-describedby="Observaciones" class="form-control input-sm" ng-model="produccion.Observaciones">{{produccion.Observaciones}}</textarea>
            </div>
        </article>
	</section>
	<section>
		<button title="Primer Registro" class="btn btn-primary" ng-click="First();" ng-disabled="!mostrar">|<</button>
        <button title="Registro Anterior" class="btn btn-primary" ng-click="Prev();" ng-disabled="!mostrar"><</button>
        <button class="btn btn-primary" ng-click="addProduccion();mostrar=false" ng-show="mostrar">Nuevo Registro</button>
        <button class="btn btn-primary" ng-click="saveProduccion();mostrar=true" ng-show="!mostrar">Generar</button>
        <button class="btn btn-success" ng-click="updateProduccion();" ng-show="mostrar">Guardar</button>
        <button class="btn" ng-click="produccion.IdProduccionEstatus=2;saveProduccion();" ng-show="mostrar">Cerrar Captura</button>
        <button title="Siguiente Registro" class="btn btn-primary" ng-click="Next();" ng-disabled="!mostrar">></button>
        <button title="Ultimo Registro" class="btn btn-primary" ng-click="Last();" ng-disabled="!mostrar">>|</button>
        <b>Semana: {{produccion.Semana}}</b>
	</section>
	<hr>
	<section class="panel panel-primary width-40p">
		<section class="panel-heading">Cerrado Kloster</section>
		<section class="panel-body">
			<button class="btn btn-success" ng-show="mostrar" ng-click="addDetalleAcero()">Agregar Produccion</button>
			<section class="scrollable">
				<table class="table table-striped">
					<thead>
		                <tr>
		                    <th class="width-40" colspan="2" ></th>
		                    <th class="width-20 text-center" colspan="2"  >Faltan</th>

		                    <th rowspan="2" ></th>
		                    
		                    <th colspan="4" class="text-center"  >Cerrados</th>
		                </tr>
		                <tr>
		                    <th>Pr</th>
		                    <th class="width-40">Prg</th>
		                    <th class="width-20">Llenada</th>
		                    <th class="width-20">Cerrada</th>
		                	<th class="width-50">No Parte</th>
		                    <th class="width-40">OK</th>
		                    <th></th>
		                    <th class="width-30">Rech</th>
		                    <th></th>
		                </tr>
		            </thead>
		            <tbody>
		            	<tr ng-class="{'info': indexDetalle == $index}"  ng-repeat="detalle in detalles">
                    		<th>{{detalle.Prioridad}}</th>
                    		<th>{{detalle.Programadas}}</th>
                    		<th>{{detalle.Programadas - detalle.Llenadas}}</th>
                    		<th>{{detalle.Cerradas}}</th>

                    		<th rowspan="1" ></th>
                    
                    		<td class="col-md-3">
		                        <select ng-if="!detalle.Producto" class="form-control" ng-init="detalle.IdProducto" ng-model="detalle.IdProducto" ng-change="DetallesDia(detalle.IdProducto,$index);">
		                            <option ng-selected="detalle.IdProducto == producto.IdProducto" ng-init="producto.Producto" value="{{producto.IdProducto}}" ng-repeat="producto in productosdia">{{ producto.Producto }}</option>
		                        </select>
	                        	<input ng-if="detalle.Producto" disabled="" class="form-control input-sm" ng-model = "detalle.Producto" >
                    		</td>
	                        <th>{{detalle.Cerradas}}</th>
	                        <th class="buttonWidth"><button type="button" ng-click="ModelMoldeo(detalle.Producto, detalle.IdProducto,1,5);" class="btn btn-info btn-sm ">+</button></th>
	                        <th>{{detalle.RechazadasC}}</th>
	                        <th class="buttonWidth"><button type="button" ng-click="ModelMoldeo(detalle.Producto, detalle.IdProducto,1,6);" class="btn btn-danger btn-sm ">-</button></th>
                		</tr>
            		</tbody>
		       	</table>
			</section>
		</section>
	</section>
		<!--#####################################################
        ######################## Modal ##########################
        #########################################################-->

        <!--###########################Ciclos Ok########################-->
        <modal title="Captura de Cerrados Kloster" visible="showModalCK">
            lol
        </modal>
        <!--########################### Ciclos Rechasados ########################-->
        <modal title="Captura de Cerrados Kloster Rechazados" visible="showModalCRK">
            lol2
        </modal>
</div>

