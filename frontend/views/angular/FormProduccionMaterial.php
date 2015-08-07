<div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading">Materia Prima Utilizada</div>
    <div class="panel-body">
    </div>
    <table class="table table-condensed">
        <thead >
            <tr>
                <th>Material</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="consumo in consumos">
                <th><select class="form-control" ng-model-options="{updateOn: 'blur'}" ng-disabled="true" ng-change="saveConsumo($index)" ng-model="consumo.IdMaterial">
                        <option ng-selected="consumo.IdMaterial == material.IdMaterial" ng-repeat="material in materiales" value="{{material.IdMaterial}}">{{material.Descripcion}}</option>
                </select></th>
                <th><input class="form-control" type="text" ng-model-options="{updateOn: 'blur'}" ng-change="saveConsumo($index)" ng-model="consumo.Cantidad" value="{{consumo.Cantidad | currency:'':'2'}}"/></th>
            </tr>
        </tbody>
    </table>
</div>