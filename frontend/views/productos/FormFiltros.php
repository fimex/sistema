<div class="panel panel-default">
    <div class="panel-heading">Filtros</div>
    <div class="panel-body">
        <button class="btn btn-info" ng-disabled="!producto" ng-click="addDato('filtros')">Agregar Filtro</button>
    </div>
    <div id="almas" class="scrollable" style="max-height: 300px">
        <table fixed-table-headers="almas" class="table table-striped table-bordered table-hover table-hovered">
            <thead>
                <tr>
                    <th class="center">Camisa</th>
                    <th class="center">Cantidad</th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="filtro in filtros">
                    <td><select class="form-control" ng-change="saveDatos('filtros',$index);" ng-model-options="{updateOn: 'blur'}" ng-model="filtro.IdFiltroTipo">
                            <option ng-repeat="FiltroTipo in FiltrosTipo" ng-selected="filtro.IdFiltroTipo == FiltroTipo.IdFiltroTipo" value="{{FiltroTipo.IdFiltroTipo}}">{{FiltroTipo.Descripcion}}</option>
                    </select></td>
                    <td><input class="form-control" ng-change="saveDatos('filtros',$index);" ng-model-options="{updateOn: 'blur'}" ng-model="filtro.Cantidad" /></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>