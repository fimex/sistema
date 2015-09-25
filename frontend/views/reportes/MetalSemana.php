<h3>Metal por Semana</h3><br>
<div ng-controller="Pruebas" ng-init="load('data-metal',{semana:semanaActual,IdArea:<?=$IdArea?>})"></div>
<b style="font-size: 14pt;"></b><input type="week" ng-model="semanaActual" /><button class="btn" ng-click="load('data-metal',{semana:semanaActual,IdArea:<?=$IdArea?>})">Ver</button>

<table class="table table-bordered">
    <thead>
        <tr>
            <th rowspan="2">Aleacion</th>
            <th rowspan="2">Total Araña</th>
            <th colspan="4">Semanas</th>
        </tr>
        <tr>
            <th ng-repeat="semana in data[0].semanas">{{semana.semana}}</th>
        </tr>
    </thead>
    <tbody>
        <tr ng-repeat="dat in data">
            <td>{{dat.Aleacion}}</td>
            <td>{{dat.total}}</td>
            <td ng-repeat="semana in dat.semanas">{{semana.TonTotales}}</td>
        </tr>
    </tbody>
</table>
