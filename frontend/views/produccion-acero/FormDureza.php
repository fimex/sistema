<div class="panel panel-primary" >
	<div class="panel-heading">Captura de Dureza</div>
	<div class="panel-body">
        <button class="btn btn-success" ng-show="mostrar" ng-click="addDureza()">Agregar Lectura</button>
    </div>
	<div class="scrollabel">
        <table class="table table-condensed">
			<tr>
				<th>Colada</th>
				<th>Diametro de Huella</th>
				<th>Dureza Brinel HB</th>
				<th>Dureza Rockwell HRC</th>
				<th></th>
				<!--<th></th>-->
			</tr>
			<tr ng-repeat="dureza in datosdureza" >
				<th> 					
					<select aria-describedby="Probetas" class="form-control" ng-model="dureza.IdProbeta" required>
                        <option ng-selected="dureza.IdProbeta == probeta.IdProbeta" value="{{probeta.IdProbeta}}" ng-repeat="probeta in probetas">Colada {{probeta.Colada}} - Lance {{probeta.Lance}}</option>
                    </select>
                </th>
				<th><input class="form-control" type="text" ng-model-options="{updateOn: 'blur'}" ng-model="dureza.DiametroHuella" value="{{dureza.DiametroHuella | number:0}}"/></th>
				<th>{{ dureza.Dureza }}</th>
				<th>{{ dureza.HRC }}</th>
				<th><button class="btn btn-success btn-xs" ng-click="SavePruebasDureza($index)"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button></th>
                <!--<th><button class="btn btn-danger btn-xs" ng-click="deletePruebas($index)"><span class="glyphicon glyphicon glyphicon-trash" aria-hidden="true"></span></button></th>-->
			</tr>
		</table>
	</div>
</div>