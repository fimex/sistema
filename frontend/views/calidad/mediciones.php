<div ng-controller="Calidad" ng-init="getMediciones();">
    <table class="table table-bordered table-striped">
        <thead>
            <tr class="primary">
                <th rowspan="2" class="col-md-1"></th>
                <th class="col-md-1">CLIENTE:</th>
                <th class="col-md-1">NO PARTE:</th>
                <th class="col-md-1">FECHA:</th>
                <th class="col-md-1">MAQUINA:</th>
                <th class="col-md-1">ORDEN:</th>
                <th class="col-md-1">OPERACION:</th>
            </tr>
            <tr>
                <th><input class="form-control" ng-model="filtro.cliente" /></th>
                <th><input class="form-control" ng-model="filtro.no_parte" /></th>
                <th><input class="form-control" ng-model="filtro.fecha" /></th>
                <th><input class="form-control" ng-model="filtro.maquina" /></th>
                <th><input class="form-control" ng-model="filtro.orden_fabricacion" /></th>
                <th><input class="form-control" ng-model="filtro.operacion" /></th>
            </tr>
        </thead>
        <tbody ng-repeat="medida in medidas | filter:filtro" ng-init="getCapturas($index,medida.folio)">
            <tr class="primary">
                <th>
                    <button class="btn btn-info" ng-click="medida.visible = !medida.visible">
                        <span ng-if="!medida.visible" class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        <span ng-if="medida.visible" class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                    </button>
                </th>
                <th class="col-md-2">{{medida.cliente}}</th>
                <th>{{medida.no_parte}}</th>
                <th>{{medida.fecha}}</th>
                <th>{{medida.maquina}}</th>
                <th>{{medida.orden_fabricacion}}</th>
                <th>{{medida.operacion}}</th>
            </tr>
            <tr ng-if="medida.visible">
                <td colspan="7">
                    <div style="width: 1700px;overflow: auto">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="info" colspan="4">Fecha</th><td class="col-md-1" ng-repeat="captura in medida.capturas">{{captura.fecha}}</td>
                            </tr>
                            <tr>
                                <th colspan="4">Tipo</th><td class="col-md-1" ng-repeat="captura in medida.capturas">{{captura.inspeccion}}</td>
                            </tr>
                            <tr>
                                <th colspan="4">Inspector</th><td class="col-md-1" ng-repeat="captura in medida.capturas">{{captura.usuario}}</td>
                            </tr>
                            <tr>
                                <th colspan="4">Serie</th><td class="col-md-1" ng-repeat="captura in medida.capturas">{{captura.serie}}</td>
                            </tr>
                            <tr>
                                <th colspan="4">Observaciones</th><td class="col-md-1" ng-repeat="captura in medida.capturas">{{captura.observaciones}}</td>
                            </tr>
                            <tr>
                                <th colspan="4">Archivo</th><td class="col-md-1" ng-repeat="captura in medida.capturas">{{captura.file}}</td>
                            </tr>
                            <tr>
                                <th>Medida</th>
                                <th>Minimo</th>
                                <th>Nominal</th>
                                <th>Maximo</th>
                                <th class="col-md-1" ng-repeat="captura in medida.capturas">
                                    <table class="table">
                                        <tr>
                                            <td class="col-md-1" ng-repeat="piezas in captura.medicionesDimenciones">Pieza {{piezas.pieza}}</td>
                                        </tr>
                                    </table>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="dimencion in medida.dimenciones">
                                <th class="info col-md-3">{{dimencion.nombre}}</th>
                                <th class="info text-center" colspan="3" ng-if="dimencion.atributo == 1">SI</th>
                                <th class="info col-md-1 text-center" ng-if="dimencion.atributo == 0">{{dimencion.tol_min | currency:"":2}}</th>
                                <th class="info col-md-1 text-center" ng-if="dimencion.atributo == 0">{{dimencion.val_nominal | currency:"":2}}</th>
                                <th class="info col-md-1 text-center" ng-if="dimencion.atributo == 0">{{dimencion.tol_max | currency:"":2}}</th>
                                <td ng-repeat=""></td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>