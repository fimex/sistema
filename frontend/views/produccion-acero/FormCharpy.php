<div class="panel panel-primary" >
	<div class="panel-heading">Captura de Lectura</div>
	<div class="panel-body">
        <button class="btn btn-success" ng-show="mostrar" ng-click="addPruebas()">Agregar Lectura</button>
    </div>
	<div class="scrollabel">
        <table class="table table-condensed">
			<tr>
				<th class="width-40" colspan="4" ></th>
                <th class="text-center" colspan="2">Ranura (Grove)</th>
                <th class="width-20 text-center" colspan="2" >Lecturas Obtenidas</th>
                <th class="width-20 text-center" colspan="2" >Promedio</th>
                <th class="text-center" colspan="4"></th>
			</tr>
			<tr>
				<th>Colada</th>
				<th>Espesor (Thick)</th>
				<th>Ancho (Wide)</th>
				<th>Largo (Length)</th>
				<th>Prof (Deep)</th>
				<th>Angulo (Angle)</th>
				<th>LB/FT</th>
				<th>Joulas</th>
				<th>LB/FT</th>
				<th>Joules</th>
				<th>Temp °C</th>
				<th>Resultado</th>
				<th></th>
				<th></th>
			</tr>
			<tr ng-repeat="charpy in datoscharpy" >
				<th>{{charpy.lances.Colada}}</th>
				<th><input class="form-control" type="text" ng-model-options="{updateOn: 'blur'}" ng-model="charpy.Espesor" value="{{charpy.Espesor}}"/></th>
				<th><input class="form-control" type="text" ng-model-options="{updateOn: 'blur'}" ng-model="charpy.Ancho" value="{{charpy.Ancho | currency:'':2}}"/></th>
				<th><input class="form-control" type="text" ng-model-options="{updateOn: 'blur'}" ng-model="charpy.Largo" value="{{charpy.Largo | number:0}}"/></th>
				<th><input class="form-control" type="text" ng-model-options="{updateOn: 'blur'}" ng-model="charpy.Profundo" value="{{charpy.Profundo | number:0}}"/></th>
				<th><input class="form-control" type="text" ng-model-options="{updateOn: 'blur'}" ng-model="charpy.Angulo" value="{{charpy.Angulo}}"/></th>
				<th><input class="form-control" type="text" ng-model-options="{updateOn: 'blur'}" ng-model="charpy.ResultadoLBFT" value="{{charpy.ResultadoLBFT}}"/></th>
				<th>{{ charpy.ResultadoJoules }}</th>
				<th>{{ charpy.PromedioLBFT }}</th>
				<th></th>
				<th><input class="form-control" type="text" ng-model-options="{updateOn: 'blur'}" ng-model="charpy.Temperatura" value="{{charpy.Temperatura}}"/></th>
				<th></th>
				<th><button class="btn btn-success btn-xs" ng-click="SavePruebas($index)"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button></th>
                <th><button class="btn btn-danger btn-xs" ng-click="deletePruebas($index)"><span class="glyphicon glyphicon glyphicon-trash" aria-hidden="true"></span></button></th>
			</tr>
		</table>
	</div>
</div>