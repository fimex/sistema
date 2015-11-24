<div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading">Control de temperaturas</div>
    <div class="panel-body">
        <button class="btn btn-success" ng-show="mostrar" ng-click="addTemperatura()">Toma de Temperatura</button>
    </div>
    <div id="Temperaturas" class="scrollable">
        <table class="table table-condensed">
            <thead>
                <tr>
                    <?php if($IdSubProceso != 2): ?>
                    <th>Maquina</th>
                    <?php endif;?>
                    <th>Hora</th>
                    <th><?php if($IdSubProceso == 2): ?>Placa Izquierda<?php else:?>Temperatura<?php endif;?></th>
                    <?php if($IdSubProceso == 2): ?>
                    <th>Placa Derecha</th>
                    <?php endif;?>
                    <?php if($IdSubProceso == 10): ?>
                    <th>Hornero / Vaciador</th>
                    <th>Producto</th>
                    <th>Moldes</th>
                    <?php endif;?>
                </tr>
            </thead>
            <tbody>
                <tr 
                    ng-repeat="temperatura in temperaturas"
                    ng-class="{'warning': temperatura.change == true}"
                >
                    <?php if($IdSubProceso != 2): ?>
                    <th><select class="form-control" ng-model-options="{updateOn: 'blur'}" ng-model="temperatura.IdMaquina">
                            <option ng-selected="temperatura.IdMaquina == maquina.IdMaquina" value="{{maquina.IdMaquina}}" ng-repeat="maquina in maquinas">{{maquina.ClaveMaquina}} - {{maquina.Maquina}}</option>
                    </select></th>
                    <?php endif;?>
                    <th><input ng-change="temperatura.change = true" class="form-control" ng-model-options="{updateOn: 'blur'}" ng-model="temperatura.Fecha" value="{{temperatura.Fecha | date:'HH:mm'}}" /></th>
                    <th><input ng-change="temperatura.change = true" class="form-control" ng-model-options="{updateOn: 'blur'}" ng-model="temperatura.Temperatura" value="{{temperatura.Temperatura}}"/></th>
                    <?php if($IdSubProceso == 2): ?>
                    <th><input ng-change="temperatura.change = true" class="form-control" ng-model-options="{updateOn: 'blur'}" ng-model="temperatura.Temperatura2" value="{{temperatura.Temperatura2}}"/></th>
                    <?php endif;?>
                    <?php if($IdSubProceso == 10): ?>
                    <th>
                        <select class="form-control input-sm" ng-model="temperatura.IdEmpleado" required>
                            <option ng-selected="temperatura.IdEmpleado == em.IdEmpleado" ng-repeat="em in empleados" ng-value="{{em.IdEmpleado}}">{{em.NombreCompleto}}</option>
                        </select>
                    </th>
                    <th><select ng-change="temperatura.change = true" class="form-control" ng-model="temperatura.IdProducto" >
                        <option ng-selected="temperatura.IdProducto == detalle.IdProductos" value="{{detalle.IdProductos}}" ng-repeat="detalle in detalles">{{detalle.idProductos.Identificacion}}</option>
                    </select></th>
                    <th><input ng-change="temperatura.change = true" class="form-control" ng-model-options="{updateOn: 'blur'}" ng-model="temperatura.Moldes" value="{{temperatura.Moldes}}"/></th>
                    <?php endif;?>
                    <th class="col-md-2">
                        <button class="btn btn-success btn-xs" ng-click="saveTemperatura($index)"  ng-disabled="temperatura.active"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
                        <button class="btn btn-danger btn-xs" ng-click="deleteTemperatura($index)"><span class="glyphicon glyphicon glyphicon-trash" aria-hidden="true"></span></button>
                    </th>
                </tr>
            </tbody>
        </table>
    </div>
</div>