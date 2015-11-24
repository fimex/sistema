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
    </thead>
    <tbody  ng-repeat="dat in data">
        <tr>
            <th>{{dat.Fecha | date:'dd-MMM-yyyy'}} Turno: {{dat.Turno}}</th>
        </tr>
        <tr>
            <td>
                <table class="table table-striped table-bordered table-hover">
                    <tr>
                        <th>Identificador</th>
                        <th>Material</th>
                        <th>Cantidad</th>
                    </tr>
                    <tr ng-repeat="material in dat.Material" ng-if="material.Cantidad > 0">
                        <td class="col-md-1">{{material.Identificador}}</td>
                        <td class="col-md-3">{{material.Material}}</td>
                        <td>{{material.Cantidad}}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>