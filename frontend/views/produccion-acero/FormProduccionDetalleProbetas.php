<div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading">Carga de Probetas</div>
    <div class="panel-body">
        <button class="btn btn-success" ng-show="mostrar" ng-click="addProbetaDetalle()">Agregar </button>
    </div>
    <div id="detalle" class="scrollable">
        <table ng-table class="table table-condensed table-striped table-bordered">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th class="col-md-2">Cantidad</th>
                </tr>
            </thead>
            <tbody>
                <tr 
                    ng-class="{'info': indexDetalle == $index, 'warning': detalle.change == true}"
                    ng-click="selectDetalle($index);"
                    ng-repeat="probetadetalle in probetadetalles">
                    <td class="col-md-5">
					<select aria-describedby="Colada" class="form-control"  ng-model="probetadetalle.IdLance" required>
                        <option ng-selected="probetadetalle.IdLance == Lance.IdLance" value="{{Lance.IdLance}}" ng-repeat="Lance in lances"> Colada: {{Lance.Colada}} - Lance: {{Lance.Lance}} </option>
                    </select>     
					</td>                     
                    <td class="captura"><input  ng-model-options="{updateOn: 'blur'}"  ng-model="probetadetalle.Cantidad" value="{{probetadetalle.Cantidad}}"/></td>
                    <td>
                        <button class="btn btn-success btn-xs" ng-click="saveProbetaDetalle($index)"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
                        <button  class="btn btn-danger btn-xs" ng-click="deleteProbetaDetalle($index)"><span class="glyphicon glyphicon glyphicon-trash" aria-hidden="true"></span></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>