<h3>Filtros por Dia</h3><br>
<div ng-controller="Pruebas" ng-init="load('data-filtros-dia',{semana:semanaActual,IdArea:<?=$IdArea?>})"></div>
<b style="font-size: 14pt;"></b><input type="week" ng-model="semanaActual" /><button class="btn" ng-click="load('data-filtros-dia',{semana:semanaActual,IdArea:<?=$IdArea?>})">Ver</button>

<table class="table table-bordered">
    <thead>
        <tr>
            <th rowspan="2">Filtro</th>
            <th rowspan="2">Total</th>
            <th rowspan="2">Cantidad por paquete</th>
            <th rowspan="2">Paq. Por pedir</th>
            <th colspan="2">Existencia</th>
            <th colspan="4">Dias</th>
        </tr>
        <tr>
            <th>Pesos</th>
            <th>Dolares</th>
            <th ng-repeat="dia in data[0].dias">{{dia.dia}}</th>
        </tr>
    </thead>
    <tbody>
        <tr ng-repeat="dat in data">
            <td>{{dat.Descripcion}}</td>
            <td>{{dat.total}}</td>
            <td>{{dat.CantidadPorPaquete}}</td>
            <td>{{((dat.total - dat.ExistenciaPesos - dat.ExistenciaDolares) / dat.CantidadPorPaquete) | currency:"":2}}</td>
            <td>{{dat.ExistenciaPesos}}</td>
            <td>{{dat.ExistenciaDolares}}</td>
            <td ng-repeat="dia in dat.dias">{{dia.Requeridas}}</td>
        </tr>
    </tbody>
</table>
