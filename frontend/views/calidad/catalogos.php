<div ng-controller="Calidad" ng-init="getCatalogos();">
    <div ng-repeat="catalogo in catalogos">
        <h1 class="info">
            <button class="btn btn-info" ng-click="catalogo.visible = !catalogo.visible">
                <span ng-if="!catalogo.visible" class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                <span ng-if="catalogo.visible" class="glyphicon glyphicon-minus" aria-hidden="true"></span>
            </button>
            {{catalogo.cliente}}
        </h1>
        <table ng-if="catalogo.visible" ng-repeat="producto in catalogo.catPartes" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th colspan="7" class="info">
                        <button class="btn btn-info" ng-click="producto.visible = !producto.visible">
                            <span ng-if="!producto.visible" class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            <span ng-if="producto.visible" class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                        </button>
                        <span style="font-size: 16pt">{{producto.no_parte}}</span>
                    </th>
                </tr>
                <tr ng-if="producto.visible">
                    <th class="text-center col-sm-1" rowspan="2">Operacion</th>
                    <th class="text-center" rowspan="2">Nombre</th>
                    <th class="text-center" colspan="3">Tolerancia</th>
                    <th class="text-center col-sm-1" rowspan="2">Atributo</th>
                    <th class="text-center col-sm-1" rowspan="2">Final</th>
                </tr>
                <tr ng-if="producto.visible">
                    <th class="text-center col-sm-1">Max</th>
                    <th class="text-center col-sm-1">Nominal</th>
                    <th class="text-center col-sm-1">Minima</th>
                </tr>
            </thead>
            <tbody ng-if="producto.visible" ng-repeat="dimencion in producto.catDimensiones">
                <tr>
                    <td class="text-center">{{dimencion.operacion}}</td>
                    <td>{{dimencion.nombre}}</td>
                    <th class="text-center" colspan="3" ng-if="dimencion.atributo == 1">SI</th>
                    <td class="text-center" ng-if="dimencion.atributo == 0">{{dimencion.tol_max | currency:"":2}}</td>
                    <td class="text-center" ng-if="dimencion.atributo == 0">{{dimencion.val_nominal | currency:"":2}}</td>
                    <td class="text-center" ng-if="dimencion.atributo == 0">{{dimencion.tol_min | currency:"":2}}</td>
                    <td class="text-center">{{dimencion.atributo == 0 ? 'NO' : 'SI'}}</td>
                    <td class="text-center">{{dimencion.final == 0 ? 'NO' : 'SI'}}</td>
                </tr>
            </tbody>
        </table>
        <hr />
    </div>
</div>