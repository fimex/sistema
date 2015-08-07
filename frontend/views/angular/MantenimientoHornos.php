<div ng-init="getData()">
    <div class="row">
        <div class="col-md-2">
            <label>Fecha: </label><input type="date" class="form-control" ng-init="mtto.Fecha = Fecha" ng-model="Fecha" format-date>
        </div>
        <div class="col-md-4">
            <label>Horno: </label>
            <select aria-describedby="Maquinas" class="form-control input-sm" ng-model="mtto.IdMaquina" required>
                <option ng-show="{{maquina.Descripcion == 'Vaciado Bronces' ? true : false }}" value="{{maquina.IdMaquina}}" ng-repeat="maquina in maquinas">{{maquina.ClaveMaquina}} - {{maquina.Maquina}}</option>
            </select>
        </div>
        <div class="col-md-3">
            <label>Refractario: </label>
            <input class="form-control" ng-model="mtto.Refractario">
        </div>
        <div class="col-md-3">
            <button class="btn btn-success btn-lg" ng-click="addMtto(mtto)">Agregar</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <label>Observaciones: </label>
            <textarea class="form-control" rows="6" ng-model="mtto.Observaciones"></textarea>
        </div>
    </div>
    <hr>
    <table class="table table-striped table-responsive table-bordered"
        <thead>
            <td>Fecha:
                    <span class="seleccion glyphicon glyphicon-triangle-bottom" ng-click="orden('Fecha',1)" ng-show="mostrarBoton('Fecha',1);" aria-hidden="true"></span>
                    <span class="seleccion glyphicon glyphicon-triangle-top" ng-click="orden('Fecha',2)" ng-show="mostrarBoton('Fecha',2);" aria-hidden="true"></span>
                    <span class="seleccion glyphicon glyphicon glyphicon-remove" ng-click="orden('Fecha',3)" ng-show="mostrarBoton('Fecha',3);" aria-hidden="true"></span><br>
                    <input type="text" class="form-control margin-10" ng-model="date">
            </td>

            <td>Horno:
                    <span class="seleccion glyphicon glyphicon glyphicon-triangle-bottom" ng-click="orden('IdMaquina',1)" ng-show="mostrarBoton('IdMaquina',1);" aria-hidden="true"></span>
                    <span class="seleccion glyphicon glyphicon glyphicon-triangle-top" ng-click="orden('IdMaquina',2)" ng-show="mostrarBoton('IdMaquina',2);" aria-hidden="true"></span>
                    <span class="seleccion glyphicon glyphicon glyphicon-remove" ng-click="orden('IdMaquina',3)" ng-show="mostrarBoton('IdMaquina',3);" aria-hidden="true"></span><br>
                    <input type="text" class="form-control margin-10" ng-model="oven">
            </td>

            <td>Refractario:
                    <span class="seleccion glyphicon glyphicon glyphicon-triangle-bottom" ng-click="orden('Refractario',1)" ng-show="mostrarBoton('Refractario',1);" aria-hidden="true"></span>
                    <span class="seleccion glyphicon glyphicon glyphicon-triangle-top" ng-click="orden('Refractario',2)" ng-show="mostrarBoton('Refractario',2);" aria-hidden="true"></span>
                    <span class="seleccion glyphicon glyphicon glyphicon-remove" ng-click="orden('Refractario',3)" ng-show="mostrarBoton('Refractario',3);" aria-hidden="true"></span><br>
                    <input type="text" class="form-control margin-10" ng-model="refractory">
            </td>
            <td>Consecutivo:
                    <span class="seleccion glyphicon glyphicon glyphicon-triangle-bottom" ng-click="orden('Consecutivo',1)" ng-show="mostrarBoton('Consecutivo',1);" aria-hidden="true"></span>
                    <span class="seleccion glyphicon glyphicon glyphicon-triangle-top" ng-click="orden('Consecutivo',2)" ng-show="mostrarBoton('Consecutivo',2);" aria-hidden="true"></span>
                    <span class="seleccion glyphicon glyphicon glyphicon-remove" ng-click="orden('Consecutivo',3)" ng-show="mostrarBoton('Consecutivo',3);" aria-hidden="true"></span><br>
                    <input type="text" class="form-control margin-10" ng-model="consecutive">
            </td>

            <td>Observaciones:</td>
        </thead>
        <tbody>
            <tr ng-repeat="dato in datos | orderBy:arr | filter:{
                    Fecha:date,
                    IdMaquina:oven,
                    Refractario:refractory,
                    Consecutivo:consecutive
            }">
                    <td >{{dato.Fecha}}</td>
                    <td>{{dato.idMaquina.Identificador}} - {{dato.idMaquina.Descripcion}}</td>
                    <td>{{dato.Refractario}}</td>
                    <td>{{dato.Consecutivo}}</td>
                    <td>{{dato.Observaciones}}</td>
            </tr>
        </tbody>
    </table>
</div>
