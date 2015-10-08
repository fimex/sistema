<div class="panel panel-primary" >
	<div class="panel-heading">Captura de Tension y Dureza</div>
	<div class="panel-body">
        <button class="btn btn-success" ng-show="mostrar" ng-click="addTension()">Agregar Lectura</button>
    </div>
	<div class="scrollabel">
        <table class="table table-condensed">
        	<tr>
        		<th colspan="2"></th>
        		<th rowspan="{{datostension.length + 2}}"></th>
        		<th class="text-center" colspan="6">Datos Tension</th>
        		<th rowspan="{{datostension.length + 2}}"></th>
        		<th class="text-center" colspan="3">Datos Dureza</th>
        		<th></th>
        	</tr>
			<tr>
				<th class="width-60" >Colada</th>
				<th>Aleacion</th>
				<th>Psi Tens Strength</th>
				<th>Mpa Tens Strengh</th>
				<th>Psi Yield Strength</th>
				<th>Mpa Yield Strengh</th>
				<th>Elongaci&oacute;n</th>
				<th>Red de area</th>
				<th>Diam Huella</th>
				<th>Dureza</th>
				<th>HRC</th>
				<th></th>
				<!--<th></th>-->
			</tr>
			<tr ng-repeat="tension in datostension" >
				<th>   
					<select aria-describedby="Probetas" class="form-control" ng-model="tension.IdProbeta" required>
                        <option ng-selected="tension.IdProbeta == probeta.IdProbeta" value="{{probeta.IdProbeta}}" ng-repeat="probeta in probetas">Colada {{probeta.Colada}} - Lance {{probeta.Lance}}</option>
                    </select>     
                </th>
				<th>{{tension.Aleacion}}</th>
				<th><input class="form-control" type="text" ng-model-options="{updateOn: 'blur'}" ng-model="tension.PsiTensileStrength" value="{{tension.PsiTensileStrength}}"/></th>
				<th>{{ tension.MpaTensileStrengh | limitTo : 4 }}</th>
				<th><input class="form-control" type="text" ng-model-options="{updateOn: 'blur'}" ng-model="tension.PsiYieldStrength" value="{{tension.PsiYieldStrength | currency:'':2}}"/></th>
				<th>{{ tension.MpaYieldStrengh | limitTo : 4 }}</th>
				<th><input class="form-control" type="text" ng-model-options="{updateOn: 'blur'}" ng-model="tension.Elongacin" value="{{tension.Elongacin | number:0}}"/></th>
				<th><input class="form-control" type="text" ng-model-options="{updateOn: 'blur'}" ng-model="tension.ReduccionArea" value="{{tension.ReduccionArea | number:0}}"/></th>
				<th><input class="form-control" type="text" ng-model-options="{updateOn: 'blur'}" ng-model="tension.DiametroHuella" value="{{tension.DiametroHuella | number:0}}"/></th>
				<th>{{ tension.Dureza }}</th>
				<th>{{ tension.HRC }}</th>
				<th><button class="btn btn-success btn-xs" ng-click="SavePruebasTension($index)"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button></th>
                <!--<th><button class="btn btn-danger btn-xs" ng-click="deletePruebas($index)"><span class="glyphicon glyphicon glyphicon-trash" aria-hidden="true"></span></button></th>-->
			</tr>
		</table>
	</div>
</div>