<div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading">Control de fallas</div>
    <div class="panel-body">
        <button class="btn btn-success" ng-show="mostrar" ng-click="addTiempo()">Agregar Falla</button>
    </div>
    <div id="TMuerto" class="scrollable">
        <table class="table table-condensed table-striped">
            <thead>
                <tr>
                    <th>Causa</th>
                    <th style="width: 100px;">Inicio</th>
                    <th style="width: 100px;">Fin</th>
                    <th style="width: 400px;">Observaciones</th>
                </tr>
            </thead>
            <tbody>
                <tr 
                    ng-repeat="tiempos in TiemposMuertos"
                    ng-class="{'warning': tiempos.change == true}"
                >
                    <th><select ng-change="tiempos.change = true" class="form-control" ng-model-options="{updateOn: 'blur'}" ng-model="tiempos.IdCausa">
                            <optgroup ng-repeat="falla in fallas" label="{{falla.Descripcion}}">
                                <option ng-selected="tiempos.IdCausa == causa.IdCausa" ng-repeat="causa in falla.causas" value="{{causa.IdCausa}}">{{causa.Descripcion}}</option>
                            </optgroup>
                    </select></th>
                    <th style="width: 100px;"><input ng-change="tiempos.change = true;tiempos.Fin = tiempos.Fin == '00:00' ? tiempos.Inicio : tiempos.Fin" class="form-control" style="width: 100px;" ng-model-options="{updateOn: 'blur'}" ng-model="tiempos.Inicio" value="{{tiempos.Inicio | date:'HH:mm'}}"/></th>
                    <th style="width: 100px;"><input ng-change="tiempos.change = true" class="form-control" style="width: 100px;" ng-model-options="{updateOn: 'blur'}" ng-model="tiempos.Fin" value="{{tiempos.Fin | date:'HH:mm'}}"/></th>
                    <th style="width: 400px;"><textarea ng-change="tiempos.change = true" cols="15" class="form-control" ng-model-options="{updateOn: 'blur'}" ng-model="tiempos.Descripcion" value="{{tiempos.Descripcion}}"></textarea></th>
                    <th>
                        <button class="btn btn-success btn-xs" ng-click="saveTiempo($index)"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
                        <button ng-if="tiempos.IdTiempoMuerto" class="btn btn-danger btn-xs" ng-click="deleteTiempo($index)"><span class="glyphicon glyphicon glyphicon-trash" aria-hidden="true"></span></button>
                    </th>
                </tr>
            </tbody>
        </table>
    </div>
</div>