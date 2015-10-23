<div class="panel panel-primary" >
	<div class="panel-heading">Captura de Lectura</div>
	<div class="panel-body">
        <button class="btn btn-success" ng-show="mostrar" ng-click="addPruebas()">Agregar Lectura</button>
    </div>
	<div class="scrollabel">
        <table class="table table-condensed">
			<tr>
				<th class="width-50" colspan="6" ></th>
                <th class="text-center" colspan="2">Ranura (Grove)</th>
                <th class="width-20 text-center" colspan="2" >Lecturas Obtenidas</th>
                <th class="width-20 text-center" colspan="2" >Promedio</th>
                <th class="text-center" colspan="3"></th>
			</tr>
			<tr>
				<th># Probeta</th>
				<th class="width-60 text-center" >Colada</th>
				<th class="text-center">Aleacion</th>
				<th>Espesor (Thick)</th>
				<th>Ancho (Wide)</th>
				<th>Largo (Length)</th>
				<th>Prof (Deep)</th>
				<th>Angulo (Angle)</th>
				<th>LB/FT</th>
				<th>Joules</th>
				<th>LB/FT</th>
				<th>Joules</th>
				<th>Temp °C</th>
				<th>Resultado</th>
				<th></th>
				<!--<th></th>-->
			</tr>
			<tr ng-repeat="charpy in datoscharpy" >
				<th class="text-center"> 
					<label ng-if="probetas[$index].IdProbeta == charpy.IdProbeta" > 
						{{$index}}
					</label>
					<label  ng-if="probetas[$index].IdProbeta != null">
						<select aria-describedby="Probetas" class="form-control" ng-model="charpy.IdProbeta" required>
	                        <option ng-selected="charpy.IdProbeta == probeta.IdProbeta" value="{{probeta.IdProbeta}}" ng-repeat="probeta in probetas">Colada {{probeta.Colada}} - Lance {{probeta.Lance}}</option>
	                    </select>  

					</label>
                    <!--<div ng-switch on="probetas[$index].IdProbeta"> pro {{probetas[$index].IdProbeta}} - {{charpy.IdProbeta}}
					      <div class="animate-switch" ng-switch-when="settings">Settings Div</div>
					      <div class="animate-switch" ng-switch-when="home">Home Span</div>
					      <div class="animate-switch" ng-switch-default>default</div>
					</div>-->
                </th>
				<th class="text-center">{{charpy.Colada}}</th>
				<th class="text-center">{{charpy.Aleacion}}</th>
				<th><input class="form-control" type="text" ng-model-options="{updateOn: 'blur'}" ng-model="charpy.Espesor" value="{{charpy.Espesor | limitTo : 4 }}"/></th>
				<th><input class="form-control" type="text" ng-model-options="{updateOn: 'blur'}" ng-model="charpy.Ancho" value="{{charpy.Ancho | limitTo : 4 }}"/></th>
				<th><input class="form-control" type="text" ng-model-options="{updateOn: 'blur'}" ng-model="charpy.Largo" value="{{charpy.Largo | limitTo : 4 }}"/></th>
				<th><input class="form-control" type="text" ng-model-options="{updateOn: 'blur'}" ng-model="charpy.Profundo" value="{{charpy.Profundo | limitTo : 4 }}"/></th>
				<th><input class="form-control" type="text" ng-model-options="{updateOn: 'blur'}" ng-model="charpy.Angulo" value="{{charpy.Angulo}}"/></th>
				<th><input class="form-control" type="text" ng-model-options="{updateOn: 'blur'}" ng-model="charpy.ResultadoLBFT" value="{{charpy.ResultadoLBFT}}"/></th>
				<th>{{ charpy.ResultadoJoules | limitTo : 4 }}</th>
				<th>{{ charpy.num == 3 ? (charpy.PromedioLBFT3/3 | limitTo : 4) : '' }} {{ charpy.num == 6 ? (charpy.PromedioLBFT6/3 | limitTo : 4) : '' }} {{ charpy.num == 9 ? (charpy.PromedioLBFT9/3 | limitTo : 4) : '' }} {{ charpy.num == 12 ? (charpy.PromedioLBF12/3 | limitTo : 4) : '' }}</th>
				<th>{{ charpy.num == 3 ? (charpy.PromedioJoules3/3 | limitTo : 4) : '' }} {{ charpy.num == 6 ? (charpy.PromedioJoules6/3 | limitTo : 4) : '' }} {{ charpy.num == 9 ? (charpy.PromedioJoules9/3 | limitTo : 4) : '' }} {{ charpy.num == 12 ? (charpy.PromedioJoules12/3 | limitTo : 4) : '' }}</th>
				<th><input class="form-control" type="text" ng-model-options="{updateOn: 'blur'}" ng-model="charpy.Temperatura" value="{{charpy.Temperatura}}"/></th>
				<th class="text-center">{{charpy.Resultado}}</th>
				<th><button class="btn btn-success btn-xs" ng-click="SavePruebas($index)"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button></th>
                <!--<th><button class="btn btn-danger btn-xs" ng-click="deletePruebas($index)"><span class="glyphicon glyphicon glyphicon-trash" aria-hidden="true"></span></button></th>-->
			</tr>
		</table>
	</div>
</div>