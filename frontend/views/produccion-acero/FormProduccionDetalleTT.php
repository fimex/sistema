<div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading">Carga de tratamiento</div>
    <div class="panel-body">
        <button class="btn btn-success" ng-show="mostrar" ng-click="addDetalle()">Agregar </button>
    </div>
    <div id="detalle" class="scrollable">
        <table ng-table class="table table-condensed table-striped table-bordered">
            <thead>
                <tr>
                    <th>Producto</th>
                    
                    <th class="col-md-2">Fecha Moldeo</th>
                    <th class="col-md-2">Cantidad</th>
                    
                </tr>
            </thead>
            <tbody>
                <tr 
                    ng-class="{'info': indexDetalle == $index, 'warning': detalle.change == true}"
                    ng-click="selectDetalle($index);"
                    ng-repeat="detalle in detalles">
                    <td class="col-md-4">
					<select aria-describedby="productos" class="form-control" ng-model="detalle.IdProductos" required>
                        <option ng-selected="detalle.IdProducto == programado.IdProducto" value="{{programado.IdProducto}}" ng-repeat="programado in programadosTT"> {{programado.Identificacion}}   {{programado.Descripcion}} </option>
                    </select>     
					</td>
                    
                    <td class="captura"><input  ng-model-options="{updateOn: 'blur'}" ng-model="detalle.FechaMoldeo"  value="{{detalle.FechaMoldeo}}"</td>
                                       
                    <td class="captura"><input  ng-model-options="{updateOn: 'blur'}"  ng-model="detalle.Hechas" value="{{detalle.Hechas}}"/></td>
                    
                    <td>
                        <button class="btn btn-success btn-xs" ng-click="saveDetalle($index)"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
                        <button ng-if="detalle.IdProduccionDetalle != null" class="btn btn-danger btn-xs" ng-click="deleteDetalle($index)"><span class="glyphicon glyphicon glyphicon-trash" aria-hidden="true"></span></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>