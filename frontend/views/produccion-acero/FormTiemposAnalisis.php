<div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading">Tiempo de Analisis</div>
    <div class="panel-body">
        <button class="btn btn-success" ng-show="mostrar" ng-click="addTiempoAnalisis()">Tomar Tiempo</button>
    </div>
    <div id="Temperaturas" class="scrollable">
        <table class="table table-condensed">
            <thead>
                 <tr>
                    <th>Tipo</th>
                    <th>Tiempo</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="tiempo in tiempoanalisis" ng-class="{'warning': tiempo.change == true}">
                    <th>
                         <select class="form-control input-sm" ng-model="tiempo.Tipo" required>
                            <option ng-value="Ajuste">Ajuste</option>
                            <option ng-value="Preliminar">Preliminar</option>
                        </select>
                    </th>
                    <th><input ng-change="tiempo.change = true" class="form-control" ng-model-options="{updateOn: 'blur'}" ng-model="tiempo.Tiempo" value="{{tiempo.Tiempo}}"/></th>
                    <th class="col-md-2">
                        <button class="btn btn-success btn-xs" ng-click="SaveTiempoAnalisis($index)"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
                        <button class="btn btn-danger btn-xs" ng-click="deleteTiempoAnalisis($index)"><span class="glyphicon glyphicon glyphicon-trash" aria-hidden="true"></span></button>
                    </th>
                </tr>
            </tbody>
        </table>
    </div>
</div>