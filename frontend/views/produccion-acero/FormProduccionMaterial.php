
<div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading">Materia Prima Utilizada</div>
    <div class="panel-body">
         <button class="btn btn-success" ng-show="mostrar" ng-click="addConsumo()">Agregar Material</button>
    </div>
    <div id="Temperaturas" class="scrollable">
        <table class="table table-condensed">
            <thead >
                <tr>
                    <th>Material</th>
                    <th>Cantidad</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="consumo in consumos">
                    <th><select class="form-control" ng-model-options="{updateOn: 'blur'}" ng-disabled="false" ng-model="consumo.IdMaterial">
                            <option ng-selected="consumo.IdMaterial == material.IdMaterial" ng-repeat="material in materiales" value="{{material.IdMaterial}}">{{material.Descripcion}}</option>
                    </select></th>
                    <th><input class="form-control" type="text" ng-model-options="{updateOn: 'blur'}" ng-model="consumo.Cantidad" value="{{consumo.Cantidad | currency:'':'2'}}"/></th>
                    <th>
                        <button class="btn btn-success btn-xs" ng-click="saveConsumo($index)"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
                        <button class="btn btn-danger btn-xs" ng-click="deleteConsumo($index)"><span class="glyphicon glyphicon glyphicon-trash" aria-hidden="true"></span></button>
                    </th>
                </tr>
            </tbody>
        </table>
    </div>
</div>