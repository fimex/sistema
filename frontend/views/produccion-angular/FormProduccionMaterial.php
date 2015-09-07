<div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading">Materia Prima Utilizada</div>
    <div class="panel-body">
        <button class="btn btn-success" ng-show="mostrar" ng-click="addConsumo()">Agregar Consumo</button>
    </div>
    <table class="table table-condensed" >
        <thead >
            <tr>
                <th>Material</th>
                <th>Cantidad</th>
            </tr>
        </thead>
    </table>
    <div class="div-table-content2">
        <table class="table table-condensed">
        <tbody>
            <tr ng-repeat="consumo in consumos">
                <th><select class="form-control" ng-model-options="{updateOn: 'blur'}" ng-change="saveConsumo({{$index}})" ng-model="consumo.IdMaterial">
                        <option ng-selected="consumo.IdMaterial == material.IdMaterial" ng-repeat="material in materiales" value="{{material.IdMaterial}}">{{material.Descripcion}}</option>
                </select></th>
                <th><input class="form-control" type="number" ng-model-options="{updateOn: 'blur'}" ng-change="saveConsumo({{$index}})" ng-model="consumo.Cantidad" value="{{consumo.Cantidad}}"/></th>
                <th><button class="btn btn-danger" ng-show="delete" ng-click="deleteConsumo({{$index}})">Eliminar</button></th>
            </tr>
        </tbody>
        </table>
    </div>
    <table class="table table-condensed">
        <tfoot>
            <tr>
                <th colspan="2">&nbsp;</th>
            </tr>
        </tfoot>
    </table>
</div>