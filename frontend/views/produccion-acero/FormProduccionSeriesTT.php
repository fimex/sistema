<div class="panel panel-danger">
    <!-- Default panel contents -->
    <div class="panel-heading">Series de productos</div>
    <div class="panel-body">
        <button class="btn btn-success" ng-show="mostrar" ng-click="addSerie()">Agregar </button>
    </div>
    <div id="detalle" class="scrollable">
        <table class="table table-condensed">
            <thead>
                <tr>
                    <th>num serie</th>
                    <th class="col-md-1">status</th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="serie in series">
          
                    <td>
						<select aria-describedby="series" class="form-control"  ng-model="serie.serie" required>
							<option ng-selected="serie.serie == lserie.serie" value="{{serie.serie}}" ng-repeat="serie in lseries"> {{serie.serie}}   </option>
						</select>
					</td>
                    <td><input class="form-control"  ng-model-options="{updateOn: 'blur'}" ng-model="serie.status" value="{{rechazo.Rechazadas}}" diasabled /></th>
                 <td>
					 <button class="btn btn-success btn-xs" ng-click="saveSeriett($index)"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
                     <button ng-if="detalle.IdProduccionDetalle != null" class="btn btn-danger btn-xs" ng-click="deleteDetalle($index)"><span class="glyphicon glyphicon glyphicon-trash" aria-hidden="true"></span></button>
				 </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>