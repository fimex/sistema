<h1>Control de inventarios</h1>
<div ng-controller="Inventarios" ng-init="IdArea = <?=$IdArea?>;loadExistencias();">
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-info">
                <div class="panel-heading">Existencias</div>
                <table class="table table-bordered table-striped table-hovered">
                    <thead>
                        <tr>
                            <th class="text-center">SubProceso</th>
                            <th class="text-center">Almacen</th>
                            <th class="text-center">Producto</th>
                            <th class="text-center">Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="existencia in Existencias">
                            <td>{{existencia.SubProceso}}</td>
                            <td>{{existencia.Descripcion}}</td>
                            <td>{{existencia.Identificacion}}</td>
                            <td class="text-center">{{existencia.Cantidad}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-info">
                <div class="panel-heading">Ajuste de inventario</div>
                <div class="panel-body">
                    <div class="col-md-3">
                        <div class="input-group">
                            <span class="input-group-addon">Fecha:</span>
                            <input class="form-control input-sm" type="date" ng-model="Fecha"/>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <span class="input-group-addon">Producto:</span>
                            <select class="form-control input-sm" >
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <span class="input-group-addon">Cantidad</span>
                            <input class="form-control input-sm" type="number" ng-model="Cantidad"/>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <span class="input-group-addon">Tipo</span>
                            <select class="form-control input-sm" >
                                <option value="E">Entrada</option>
                                <option value="E">Salida</option>
                            </select>
                        </div>
                    </div><br /><br /><br />
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">Origen:</span>
                            <select class="form-control input-sm" ng-model="Origen">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">Destino:</span>
                            <select class="form-control input-sm" ng-model="Destino">
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <h4>Movimientos por afectar</h4>
            </div>
        </div>
    </div>
</div>