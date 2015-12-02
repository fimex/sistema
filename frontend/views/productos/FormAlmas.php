<div class="panel panel-default">
    <div class="panel-heading">Almas</div>
    <div class="panel-body">
        <button class="btn btn-info" ng-disabled="!producto" ng-click="addDato('almas')">Agregar Alma</button>
        <button class="btn btn-info"  onclick="window.location='./programacion-almas/re-programa'">Actualiza Programacion</button>
    </div>
    <div id="almas" class="scrollable" style="max-height: 200px">
        <table fixed-table-headers="almas" class="table table-striped table-bordered table-hover table-hovered">
            <thead>
                <tr>
                    <th class="center" style="min-width: 100px;" rowspan="3">Tipo Alma</th>
                    <th class="center" style="min-width: 100px;" rowspan="3">Material Caja</th>
                    <th class="center" style="min-width: 100px;" rowspan="3">Receta</th>
                    <th class="center" style="min-width: 50px;" rowspan="3">Existencia</th>
                    <th class="center" style="min-width: 50px;" rowspan="3">Cavidades</th>
                    <th class="center" style="min-width: 50px;" rowspan="3">Piezas por molde</th>
                    <th class="center" style="min-width: 100px;" rowspan="3">Peso</th>
                    <th class="center" colspan="4">Tiempo</th>
                </tr>
                <tr>
                    <th class="center" rowspan="2">Llenado</th>
                    <th class="center" rowspan="2">Fraguado</th>
                    <th class="center" style="min-width: 50px;" colspan="2">Gaseo</th>
                </tr>
                <tr>
                    <th class="center" style="min-width: 50px;">Directo</th>
                    <th class="center" style="min-width: 50px;">Indirecto</th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="alma in almas">
                    <td><select class="form-control" ng-change="saveDatos('almas',$index);" ng-model-options="{updateOn: 'blur'}" ng-model="alma.IdAlmaTipo">
                            <option ng-repeat="tipo in AlmasTipo" ng-selected="alma.IdAlmaTipo == tipo.IdAlmaTipo" value="{{tipo.IdAlmaTipo}}">{{tipo.Descripcion}}</option>
                    </select></td>
                    <td><select class="form-control" ng-change="saveDatos('almas',$index);" ng-model-options="{updateOn: 'blur'}" ng-model="alma.IdAlmaMaterialCaja">
                            <option ng-repeat="caja in AlmasMaterialCaja" ng-selected="alma.IdAlmaMaterialCaja == caja.IdAlmaMaterialCaja" value="{{caja.IdAlmaMaterialCaja}}">{{caja.Descripcion}}</option>
                    </select></td>
                    <td><select class="form-control" ng-change="saveDatos('almas',$index);" ng-model-options="{updateOn: 'blur'}" ng-model="alma.IdAlmaReceta">
                            <option ng-repeat="receta in AlmasRecetas" ng-selected="alma.IdAlmaReceta == receta.IdAlmaReceta" value="{{receta.IdAlmaReceta}}">{{receta.Descripcion}}</option>
                    </select></td>
                    <td><input class="form-control" ng-change="saveDatos('almas',$index);" ng-model-options="{updateOn: 'blur'}" ng-model="alma.Existencia" /></td>
                    <td><input class="form-control" ng-change="saveDatos('almas',$index);" ng-model-options="{updateOn: 'blur'}" ng-model="alma.PiezasCaja" /></td>
                    <td><input class="form-control" ng-change="saveDatos('almas',$index);" ng-model-options="{updateOn: 'blur'}" ng-model="alma.PiezasMolde" /></td>
                    <td><input class="form-control" ng-change="saveDatos('almas',$index);" ng-model-options="{updateOn: 'blur'}" ng-model="alma.Peso" /></td>
                    <td><input class="form-control" ng-change="saveDatos('almas',$index);" ng-model-options="{updateOn: 'blur'}" ng-model="alma.TiempoLlenado" /></td>
                    <td><input class="form-control" ng-change="saveDatos('almas',$index);" ng-model-options="{updateOn: 'blur'}" ng-model="alma.TiempoFraguado" /></td>
                    <td><input class="form-control" ng-change="saveDatos('almas',$index);" ng-model-options="{updateOn: 'blur'}" ng-model="alma.TiempoGaseoDirecto" /></td>
                    <td><input class="form-control" ng-change="saveDatos('almas',$index);" ng-model-options="{updateOn: 'blur'}" ng-model="alma.TiempoGaseoIndirecto" /></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>