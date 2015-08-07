<div class="panel panel-danger">
    <!-- Default panel contents -->
    <div class="panel-heading"><?=$titulo?></div>
    <div class="panel-body">
        <button class="btn btn-success" ng-show="mostrar" ng-click="addRechazo()">Agregar Defecto</button>
    </div>
    <div id="rechazo" class="scrollable">
        <table class="table table-condensed">
            <thead>
                <tr>
                    <th>Defecto</th>
                    <th class="col-md-1">Cantidad</th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="rechazo in rechazos">
                    <th><select class="form-control" ng-model-options="{updateOn: 'blur'}" ng-model="rechazo.IdDefectoTipo">
                        <option ng-selected="rechazo.IdDefectoTipo == defecto.IdDefectoTipo" ng-repeat="defecto in defectos" value="{{defecto.IdDefectoTipo}}">{{defecto.NombreTipo}}</option>
                    </select></th>
                    <th><input class="form-control" type="number" ng-model-options="{updateOn: 'blur'}" ng-model="rechazo.Rechazadas" value="{{rechazo.Rechazadas}}"/></th>
                    <th>
                        <button class="btn btn-success btn-xs" ng-click="saveRechazo($index)"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
                        <button ng-if="rechazo.IdProduccionDefecto != null" class="btn btn-danger btn-xs" ng-click="delRechazo($index)"><span class="glyphicon glyphicon glyphicon-trash" aria-hidden="true"></span></button>
                    </th>
                </tr>
            </tbody>
        </table>
    </div>
</div>