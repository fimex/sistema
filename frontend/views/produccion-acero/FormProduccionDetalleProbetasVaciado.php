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
                    <th>Lance</th>
                    <th class="col-md-2">Cantidad</th>
                    <th class="col-md-2">Tipo</th>
                </tr>
            </thead>
            <tbody>
                <tr 
                    ng-class="{'info': indexDetalle == $index, 'warning': detalle.change == true}"
                    ng-click="selectDetalle($index);"
                    ng-repeat="probetadetalle in probetadetalles">
                                     
                    <td class="captura"><input  ng-model-options="{updateOn: 'blur'}"  ng-model="probetadetalle.Cantidad" value="{{probetadetalle.Cantidad}}"/></td>
					<td class="captura">
					<select aria-describedby="Colada" class="form-control"  required>
                        <option  value="Charpy"> Charpy </option>
                        <option  value="Tension"> Tension </option>
                        <option  value="Dureza"> Dureza </option>
                    </select>
					</td>
					
                    <td>
                        <button class="btn btn-success btn-xs" ng-click="saveProbetaDetallevaciado($index)"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
                        <button  class="btn btn-danger btn-xs" ng-click="deleteProbetaDetallevaciado($index)"><span class="glyphicon glyphicon glyphicon-trash" aria-hidden="true"></span></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>