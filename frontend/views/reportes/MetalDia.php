<h3>Metal por Dia</h3><br>
<div ng-controller="Pruebas" ng-init="load('data-metal-dia',{semana:semanaActual,IdArea:<?=$IdArea?>})"></div>
<b style="font-size: 14pt;"></b><input type="week" ng-model="semanaActual" /><button class="btn" ng-click="load('data-metal-dia',{semana:semanaActual,IdArea:<?=$IdArea?>})">Ver</button>
<table class="table table-bordered">
    <thead>
        <tr>
            <th rowspan="2">Aleacion</th>
            <th rowspan="2">Total Araña</th>
            <th colspan="4">Dias</th>
        </tr>
        <tr>
            <th ng-repeat="dia in data[0].dias">{{dia.dia}}</th>
        </tr>
    </thead>
    <tbody>
        <tr ng-repeat="dat in data">
            <td>{{dat.Aleacion}}</td>
            <td>{{dat.Totales}}</td>
            <td ng-repeat="dia in dat.dias">{{dia.TonTotales}}</td>
        </tr>
    </tbody>
</table>

