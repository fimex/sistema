<div class="panel panel-default">
    <div class="panel-heading">Camisas</div>
    <div class="panel-body">
        <button class="btn btn-info" ng-disabled="!producto" ng-click="addDato('camisas')">Agregar Camisa</button>
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
                <tr ng-repeat="camisa in camisas">
                    <td><select class="form-control" ng-change="saveDatos('camisas',$index);" ng-model-options="{updateOn: 'blur'}" ng-model="camisa.IdCamisaTipo"> 
                            <option ng-repeat="camisaTipo in CamisasTipo" ng-selected="camisa.IdCamisaTipo == camisaTipo.IdCamisaTipo" value="{{camisaTipo.IdCamisaTipo}}">{{camisaTipo.Descripcion}} - {{camisaTipo.Tamano}}</option>
                    </select></td>
                    <td><input class="form-control" ng-change="saveDatos('camisas',$index);" ng-model-options="{updateOn: 'blur'}" ng-model="camisa.Cantidad" /></td>
                    <td><textarea class="form-control" ng-change="saveDatos('camisas',$index);" ng-model-options="{updateOn: 'blur'}" ng-model="camisa.Observaciones"> <textarea/></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>