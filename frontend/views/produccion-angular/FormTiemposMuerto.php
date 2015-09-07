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
                <tr ng-repeat="tiempos in TiemposMuertos">
                    <th><select class="form-control" ng-model-options="{updateOn: 'blur'}" ng-change="saveTiempo({{$index}})" ng-model="tiempos.IdCausa">
                            <optgroup ng-repeat="falla in fallas" label="{{falla.Descripcion}}">
                                <option ng-selected="tiempos.IdCausa == causa.IdCausa" ng-repeat="causa in falla.causas" value="{{causa.IdCausa}}">{{causa.Descripcion}}</option>
                            </optgroup>
                    </select></th>
                    <th style="width: 100px;"><input class="form-control" style="width: 100px;" ng-model-options="{updateOn: 'blur'}" ng-change="saveTiempo({{$index}})" ng-model="tiempos.Inicio" value="{{tiempos.Inicio | date:'HH:mm'}}"/></th>
                    <th style="width: 100px;"><input class="form-control" style="width: 100px;" ng-model-options="{updateOn: 'blur'}" ng-change="saveTiempo({{$index}})" ng-model="tiempos.Fin" value="{{tiempos.Fin | date:'HH:mm'}}"/></th>
                    <th style="width: 400px;"><textarea cols="15" class="form-control" ng-model-options="{updateOn: 'blur'}" ng-change="saveTiempo({{$index}})" ng-model="tiempos.Descripcion" value="{{tiempos.Descripcion}}"></textarea></th>
                    <th><button class="btn btn-danger" ng-click="deleteTiempo($index)">Eliminar</button></th>
                </tr>
            </tbody>
        </table>
    </div>
</div>