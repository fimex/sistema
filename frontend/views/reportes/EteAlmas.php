<div ng-controller="Pruebas" ng-init="load('data-ete',{
    IdArea: 3,
    IdSubProceso: 2,
    FechaIni:FechaIni,
    FechaFin:FechaFin,
});
">
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
                <th>Pzas x Min</th>
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
            <tr ng-class="{danger:almas.Total == 0}" ng-repeat="almas in dat.almasProduccionDetalles">
                <td>{{dat.Fecha}}</td>
                <td>{{dat.idEmpleado.ApellidoPaterno}} {{dat.idEmpleado.ApellidoMaterno}} {{dat.idEmpleado.Nombre}}</td>
                <td>{{dat.idMaquina.Identificador}} - {{dat.idMaquina.Descripcion}}</td>
                <td>{{almas.idProducto.Identificacion}}/{{almas.idAlmaTipo.Descripcion}}</td>
                <td>{{almas.PiezasHora / 60 | currency:"":2 }}</td>
                <td>{{almas.Inicio}}</td>
                <td>{{almas.Fin}}</td>
                <td>{{almas.Minutos}}</td>
                <td>{{almas.TiempoDisponible = (almas.Minutos - almas.MP - almas.TT)}}</td>
                <td ng-class="{danger:almas.SU < 0}">{{almas.SU}}</td>
                <td ng-class="{danger:almas.MC < 0}">{{almas.MC}}</td>
                <td ng-class="{danger:almas.MP < 0}">{{almas.MP}}</td>
                <td ng-class="{danger:almas.TT < 0}">{{almas.TT}}</td>
                <td ng-class="{danger:almas.MI < 0}">{{almas.MI}}</td>
                <td ng-class="{danger:almas.MPRO < 0}">{{almas.MPRO}}</td>
                <td ng-init="almas.TotalDisponible = (almas.TiempoDisponible - almas.MC - almas.SU - almas.MI - almas.MPRO)">{{almas.Disponibilidad = ((almas.TiempoDisponible - almas.MC - almas.SU - almas.MI - almas.MPRO) / almas.TiempoDisponible) * 100 | currency:"":0}}%</td>
                <td>{{almas.ProduccionEsperada = (almas.TiempoDisponible - almas.MC - almas.SU - almas.MI - almas.MPRO) * (almas.PiezasHora /60) | currency:"":0}}</td>
                <td>{{almas.Total = (almas.Hechas + almas.Rechazadas) | currency:"":0}}</td>
                <td>{{almas.Eficiencia = (almas.Total / almas.ProduccionEsperada) * 100 | currency:"":0}}%</td>
                <td>{{almas.Rechazadas}}</td>
                <td>{{almas.Hechas}}</td>
                <td>{{almas.Calidad = (almas.Hechas / almas.Total) * 100 | currency:"":0}}%</td>
                <td>{{(almas.Calidad * almas.Eficiencia * almas.Disponibilidad)/10000 | currency:"":0}}%</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="7" style="text-align: right;">Total:</th>
                <th>{{Resumen('almasProduccionDetalles','Minutos')}}</th>
                <th>{{Resumen('almasProduccionDetalles','TiempoDisponible')}}</th>
                <th>{{Resumen('almasProduccionDetalles','SU')}}</th>
                <th>{{Resumen('almasProduccionDetalles','MC')}}</th>
                <th>{{Resumen('almasProduccionDetalles','MP')}}</th>
                <th>{{Resumen('almasProduccionDetalles','TT')}}</th>
                <th>{{Resumen('almasProduccionDetalles','MI')}}</th>
                <th>{{Resumen('almasProduccionDetalles','MPRO')}}</th>
                <th>{{
                    ((
                        Resumen('almasProduccionDetalles','TiempoDisponible') - 
                        Resumen('almasProduccionDetalles','MC') - 
                        Resumen('almasProduccionDetalles','MP') - 
                        Resumen('almasProduccionDetalles','MI') - 
                        Resumen('almasProduccionDetalles','MPRO')) / Resumen('almasProduccionDetalles','TiempoDisponible')) * 100 | currency:"":0
                }}%</th>
                <th>{{Resumen('almasProduccionDetalles','ProduccionEsperada') | currency:"":0}}</th>
                <th>{{Resumen('almasProduccionDetalles','Total')}}</th>
                <th>{{(Resumen('almasProduccionDetalles','Total') / Resumen('almasProduccionDetalles','ProduccionEsperada')) * 100 | currency:"":0}}%</th>
                <th>{{Resumen('almasProduccionDetalles','Rechazadas')}}</th>
                <th>{{Resumen('almasProduccionDetalles','Hechas')}}</th>
                <th>{{(Resumen('almasProduccionDetalles','Hechas') / Resumen('almasProduccionDetalles','Total')) * 100 | currency:"":0}}%</th>
                <th>{{(
                    (
                        (Resumen('almasProduccionDetalles','TiempoDisponible') - 
                        Resumen('almasProduccionDetalles','MC') - 
                        Resumen('almasProduccionDetalles','MP') - 
                        Resumen('almasProduccionDetalles','MI') - 
                        Resumen('almasProduccionDetalles','MPRO')) / Resumen('almasProduccionDetalles','TiempoDisponible')) * 
                        (Resumen('almasProduccionDetalles','Total') / Resumen('almasProduccionDetalles','ProduccionEsperada')) *
                    Resumen('almasProduccionDetalles','Hechas') / Resumen('almasProduccionDetalles','Total') 
                ) * 100 | currency:"":0}}%</th>
            </tr>
        </tfoot>
    </table>
</div>