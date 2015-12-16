<div ng-init="load('data-tiempos-muertos',{
    FechaIni:FechaIni,
    FechaFin:FechaFin,
    Filtro:Filtro,
    IdSubProceso:<?=$IdSubProceso;?>,
    IdTurno:IdTurno,
    IdArea:<?=$IdArea;?>,
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
    <div class="col-md-2">
        <p class="input-group">
            <span id="Turnos" class="input-group-addon">Turno:</span>
            <select aria-describedby="Aleaciones"  class="form-control" ng-model="IdTurno">
                <option ng-selected="IdTurno == 1" value="1">Dia</option>
                <option ng-selected="IdTurno == 3" value="3">Noche</option>
            </select>
        </p>
    </div>
    <div class="col-md-1" ng-if="IdArea == 3">
          <input type="checkbox" ng-model="Filtro"/> TM ETE
    </div>
    <button ng-click="load('data-tiempos-muertos',{
        FechaIni:FechaIni,
        FechaFin:FechaFin,
        IdSubProceso:<?=$IdSubProceso;?>,
        Filtro:Filtro,
        IdTurno:IdTurno,
        IdArea:<?=$IdArea;?>,
    })" class="btn btn-default" >Ver</button>
</div>
<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Maquina<br>
                <input class="form-control" ng-model="filter.Identificador"/>
            </th>
            <th>Descripcion<br>
                <input class="form-control" ng-model="filter.Descripcion"/>
            </th>
            <th>Causa<br>
                <input class="form-control" ng-model="filter.Causa"/>
            </th>
            <th>Tipo<br>
                <input class="form-control" ng-model="filter.Tipo"/>
            </th>
            <th>Inicio</th>
            <th>Fin</th>
            <th>Minutos</th>
            <th>Observaciones</th>
        </tr>
    </thead>
    <tbody>
        <tr ng-repeat="dat in data | filter:{
            Identificador: filter.Identificador,
            Descripcion: filter.Descripcion,
            Causa: filter.Causa,
            Tipo: filter.Tipo,
        }" ng-if="dat.Minutos != 0">
            <td>{{dat.Fecha | date:'dd-MMM-yyyy'}}</td>
            <td>{{dat.Identificador}}</td>
            <td>{{dat.Descripcion}}</td>
            <td>{{dat.Causa}}</td>
            <td>{{dat.Tipo}}</td>
            <td>{{dat.Inicio}}</td>
            <td>{{dat.Fin}}</td>
            <td>{{dat.Minutos}}</td>
            <td>{{dat.Observaciones}}</td>
        </tr>
    </tbody>
    <tfoot>
        <td colspan="6"></td>
        <th>Total:</th>
        <th>{{totalFiltro('Minutos')}}</th>
    </tfoot>
</table>