<div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading">Captura de produccion</div>
    <div class="panel-body">
        <button class="btn btn-success" ng-show="mostrar" ng-click="addDetalle()">Agregar Produccion</button>
    </div>
    <div id="detalle" class="scrollable">
        <table ng-table class="table table-condensed table-striped table-bordered">
            <thead>
                <tr>
                    <th>Producto</th>
                    <?php if($IdSubProceso == 6):?>
                    <th class="col-md-1">MolXHrs</th>
                    <th class="col-md-1">PzaXMol</th>
                    <?php endif?>
                    <?php if($IdSubProceso != 10):?>
                    <th class="col-md-2">Inicio</th>
                    <th class="col-md-2">Fin</th>
                    <?php endif?>
                    <th class="col-md-2">OK</th>
                    <?php if($IdSubProceso != 10):?>
                    <th class="col-md-2">Rech</th>
                    <?php endif?>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr 
                    ng-class="{'info': indexDetalle == $index}"
                    ng-click="selectDetalle($index);"
                    ng-repeat="detalle in detalles">
                    <td class="col-md-3">{{detalle.idProductos.Identificacion}}</td>
                    <?php if($IdSubProceso == 6):?>
                    <td class="captura">{{detalle.CiclosMolde}}</td>
                    <td class="captura">{{detalle.PiezasMolde}}</td>
                    <?php endif?>
                    <?php if($IdSubProceso != 10):?>
                    <td class="captura"><input ng-model-options="{updateOn: 'blur'}" placeholder="Inicio" ng-focus="selectDetalle({{$index}})" ng-change="saveDetalle({{$index}})" ng-model="detalle.Inicio" value="{{detalle.Inicio | date:'HH:mm'}}"/></td>
                    <td class="captura"><input ng-model-options="{updateOn: 'blur'}" placeholder="Fin" ng-focus="selectDetalle({{$index}})" ng-change="saveDetalle({{$index}})" ng-model="detalle.Fin" value="{{detalle.Fin | date:'HH:mm'}}"/></td>
                    <?php endif?>
                    <td class="captura"><input ng-model-options="{updateOn: 'blur'}" placeholder="OK" ng-change="saveDetalle({{$index}})" ng-model="detalle.Hechas" value="{{detalle.Hechas}}"/></td>
                    <?php if($IdSubProceso != 10):?>
                    <td class="captura">{{detalle.Rechazadas}}</td>
                    <?php endif?>
                    <td><button class="btn btn-danger" ng-click="deleteDetalle($index)">Eliminar</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>