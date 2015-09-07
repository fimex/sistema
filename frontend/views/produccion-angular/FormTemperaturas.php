<div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading">Control de temperaturas</div>
    <div class="panel-body">
        <button class="btn btn-success" ng-show="mostrar" ng-click="addTemperatura()">Toma de Temperatura</button>
    </div>
    <table class="table table-condensed" >
        <thead >
            <tr>
                <th>Maquina</th>
                <th>Temperatura 1</th>
                <th>Temperatura 2</th>
            </tr>
        </thead>
    </table>
    <div class="div-table-content2">
        <table class="table table-condensed">
        <tbody>
            <tr ng-repeat="temperatura in temperaturas">
                <th><select class="form-control" ng-model-options="{updateOn: 'blur'}" ng-change="saveTemperatura({{$index}})" ng-model="temperatura.IdMaquina">
                        <option ng-selected="temperatura.IdMaquina == maquina.IdMaquina" value="{{maquina.IdMaquina}}" ng-repeat="maquina in maquinas">{{maquina.ClaveMaquina}} - {{maquina.Maquina}}</option>
                </select></th>
                <th><input class="form-control" type="number" ng-model-options="{updateOn: 'blur'}" ng-change="saveTemperatura({{$index}})" ng-model="temperatura.Temperatura" value="{{temperatura.Temperatura}}"/></th>
                <th><input class="form-control" type="number" ng-model-options="{updateOn: 'blur'}" ng-change="saveTemperatura({{$index}})" ng-model="temperatura.Temperatura2" value="{{temperatura.Temperatura2}}"/></th>
                <th><button class="btn btn-danger" ng-show="delete" ng-click="deleteTemperatura({{$index}})">Eliminar</button></th>
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