<div class="panel panel-default">
    <div class="panel-heading">Cajas</div>
    <div class="panel-body">
        <button class="btn btn-info" ng-disabled="!producto" ng-click="addDato('cajas')">Agregar Caja</button>
    </div>
    <div id="cajas" class="scrollable" style="max-height: 300px">
        <table fixed-table-headers="cajas" class="table table-striped table-bordered table-hover table-hovered">
            <thead>
                <tr>
                    <th class="center">Caja</th>
                    <th class="center">Pza x Caja</th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="caja in cajas">
                    <td><select class="form-control" ng-change="saveDatos('cajas',$index);" ng-model-options="{updateOn: 'blur'}" ng-model="caja.IdTipoCaja"> 
                            <option ng-repeat="CajaTipo in CajasTipo" ng-selected="caja.IdTipoCaja == CajaTipo.IdTipoCaja" value="{{CajaTipo.IdTipoCaja}}">{{CajaTipo.Tamano}}</option>
                    </select></td>
                    <td><input class="form-control" ng-change="saveDatos('cajas',$index);" ng-model-options="{updateOn: 'blur'}" ng-model="caja.PiezasXCaja" /></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>