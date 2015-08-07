<div ng-controller="Pruebas" ng-init="load('data-ete',{
    IdArea: 3,
    IdSubProceso: 2,
    FechaIni:FechaIni,
    FechaFin:FechaFin,
})">
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
        <button ng-click="load('data-ete',{
            FechaIni:FechaIni,
            FechaFin:FechaFin,
            IdArea: 3,
            IdSubProceso: 2,
        })" class="btn btn-default" >Ver</button>
    </div>
    <table class="table able-bordered table-striped">
        <thead ng-init="semana = 0">
            <tr>
                <th>Fecha</th>
                <th>Nombre</th>
                <th>Maquina</th>
                <th>Alma</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>T Tot</th>
                <th>T Disp</th>
                <th>SU</th>
                <th>MC</th>
                <th>MP</th>
                <th>TT</th>
                <th>MI</th>
                <th>MPRO</th>
                <th>DISPO</th>
                <th>P Esp</th>
                <th>P Real</th>
                <th>EFIC</th>
                <th>Rec</th>
                <th>OK</th>
                <th>CAL</th>
                <th>ETE</th>
            </tr>
        </thead>
        <tbody ng-repeat="dat in data">
            <tr ng-repeat="almas in dat.almasProduccionDetalles">
                <td>{{dat.Fecha}}</td>
                <td>{{dat.idEmpleado.ApellidoPaterno}} {{dat.idEmpleado.ApellidoMaterno}} {{dat.idEmpleado.Nombre}}</td>
                <td>{{dat.idMaquina.Identificador}} - {{dat.idMaquina.Descripcion}}</td>
                <td>{{almas.idProducto.Identificacion}}/{{almas.idAlmaTipo.Descripcion}}</td>
                <td>{{almas.Inicio}}</td>
                <td>{{almas.Fin}}</td>
                <td>{{almas.Minutos}}</td>
                <td>{{almas.TiempoDisponible = (almas.Minutos - almas.SU - almas.TT)}}</td>
                <td>{{almas.SU}}</td>
                <td>{{almas.MC}}</td>
                <td>{{almas.MP}}</td>
                <td>{{almas.TT}}</td>
                <td>{{almas.MI}}</td>
                <td>{{almas.MPRO}}</td>
                <td>{{almas.Disponibilidad = ((almas.TiempoDisponible - almas.MC - almas.MP - almas.MI - almas.MPRO) / almas.TiempoDisponible) * 100 | currency:"":0}}%</td>
                <td>{{almas.ProduccionEsperada = almas.Minutos * (almas.PiezasHora /60 | currency:"":0)}}</td>
                <td>{{almas.Total = (almas.Hechas + almas.Rechazadas) | currency:"":0}}</td>
                <td>{{almas.Eficiencia = (almas.Total / almas.ProduccionEsperada) * 100 | currency:"":0}}%</td>
                <td>{{almas.Rechazadas}}</td>
                <td>{{almas.Hechas}}</td>
                <td>{{almas.Calidad = (almas.Hechas / almas.Total) * 100 | currency:"":0}}%</td>
                <td>{{(almas.Calidad * almas.Eficiencia * almas.Disponibilidad)/10000 | currency:"":0}}%</td>
            </tr>
       </tbody>
    </table>
</div>