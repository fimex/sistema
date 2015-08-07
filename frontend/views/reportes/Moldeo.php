<div ng-init="load('data-produccion',{
    FechaIni:FechaIni,
    FechaFin:FechaFin,
    IdSubProceso:<?=$IdSubProceso;?>,
})"></div>
<div class="row">
    <div class="col-md-2">
        <p class="input-group">
            <input type="text" class="form-control" datepicker-popup="{{format}}" ng-model="FechaIni" is-open="openedFechaIni" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" ng-required="true" close-text="Cerrar" />
            <span class="input-group-btn">
                <button type="button" class="btn btn-default" ng-click="openFechaIni($event);"><i class="glyphicon glyphicon-calendar"></i></button>
            </span>
        </p>
    </div>
    <div class="col-md-2">
        <p class="input-group">
          <input type="text" class="form-control" datepicker-popup="{{format}}" ng-model="FechaFin" is-open="openedFechaFin" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" ng-required="true" close-text="Cerrar" />
          <span class="input-group-btn">
            <button type="button" class="btn btn-default" ng-click="openFechaFin($event)"><i class="glyphicon glyphicon-calendar"></i></button>
          </span>
        </p>
    </div>
    <button ng-click="load('data-produccion',{
        FechaIni:FechaIni,
        FechaFin:FechaFin,
        IdSubProceso:<?=$IdSubProceso;?>,
    })" class="btn btn-default" >Ver</button>
</div>
<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="col-md-1"></th>
            <th class="col-md-1">Fecha</th>
            <th class="col-md-2">Maquina</th>
            <?php if($IdSubProceso == 10):?>
            <th class="col-md-1">Consecutivo Horno</th>
            <th class="col-md-1">Colada</th>
            <th class="col-md-1">Lance</th>
            <?php else:?>
            <th class="col-md-1">Nomina</th>
            <th class="col-md-2">Empleado</th>
            <?php endif;?>
            
        </tr>
    </thead>
    <tbody  ng-repeat="dat in data | orderBy: 'lances.Colada'">
        <tr>
            <td>
                <button ng-if="dat.produccionesDetalles.length > 0 || dat.almasProduccionDetalles.length > 0" class="btn btn-xs" ng-click="dat.show = !dat.show">
                    <span ng-if="!dat.show" class="glyphicon glyphicon glyphicon-plus" aria-hidden="true"></span>
                    <span ng-if="dat.show" class="glyphicon glyphicon glyphicon-minus" aria-hidden="true"></span>
                </button>
                <button ng-if="dat.produccionesDetalles.length == 0 && dat.almasProduccionDetalles.length == 0" class="btn btn-danger btn-xs" ng-click="delete('/fimex/angular/delete-produccion',{
                    IdProduccion:dat.IdProduccion,
                    index:$index,
                })"><span class="glyphicon glyphicon glyphicon-trash" aria-hidden="true"></span></button>
            </td>
            <td>{{dat.Fecha | date:'dd-MMM-yyyy'}}</td>
            <td>{{dat.idMaquina.Identificador}} - {{dat.idMaquina.Descripcion}}</td>
            <?php if($IdSubProceso == 10):?>
            <td>{{dat.lances.HornoConsecutivo}}</td>
            <td>{{dat.lances.Colada}}</td>
            <td>{{dat.lances.Lance}}</td>
            <?php else:?>
            <td>{{dat.idEmpleado.Nomina}}</td>
            <td>{{dat.idEmpleado.Nombre}} {{dat.idEmpleado.ApellidoPaterno}} {{dat.idEmpleado.ApellidoMaterno}}</td>
            <?php endif;?>
        </tr>
        <tr ng-if="dat.produccionesDetalles.length > 0 && dat.show">
            <td colspan="4">
                <table class="table table-striped table-bordered table-hover">
                    <tr>
                        <th>Producto</th>
                        <th>Inicio</th>
                        <th>Fin</th>
                        <th>Hechas</th>
                        <th>Rechazadas</th>
                    </tr>
                    <tr ng-repeat="detalles in dat.produccionesDetalles">
                        <td>{{detalles.idProductos.Identificacion}}</td>
                        <td>{{detalles.Inicio}}</td>
                        <td>{{detalles.Fin | date:'hh:mm'}}</td>
                        <td>{{detalles.Hechas}}</td>
                        <td>{{detalles.Rechazadas}}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr ng-if="dat.almasProduccionDetalles.length > 0 && dat.show">
            <td colspan="4">
                <table class="table table-striped table-bordered table-hover">
                    <tr>
                        <th>Alma</th>
                        <th>Inicio</th>
                        <th>Fin</th>
                        <th>Hechas</th>
                        <th>Rechazadas</th>
                    </tr>
                    <tr ng-repeat="almas in dat.almasProduccionDetalles">
                        <td>{{almas.idProducto.Identificacion}}/{{almas.idAlmaTipo.Descripcion}}</td>
                        <td>{{almas.Inicio}}</td>
                        <td>{{almas.Fin | date:'hh:mm'}}</td>
                        <td>{{almas.Hechas}}</td>
                        <td>{{almas.Rechazadas}}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>