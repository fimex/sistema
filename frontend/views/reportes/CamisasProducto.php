<div ng-controller="Pruebas" ng-init="load('data-camisas-producto',{semana:semanaActual,IdArea:<?=$IdArea;?>})"></div>
<b style="font-size: 14pt;"></b><input type="week" ng-model="semanaActual" /><button class="btn" ng-click="load('data-camisas-producto',{semana:semanaActual,IdArea:<?=$IdArea;?>})">Ver</button>

<table class="table table-bordered table-striped">
    <tbody ng-repeat="dat in data">
        <tr class="info">
            <td colspan="4">
                <button class="btn btn-info" ng-click="dat.show = !dat.show">
                    <span ng-if="!dat.show" class="glyphicon glyphicon glyphicon-plus" aria-hidden="true"></span>
                    <span ng-if="dat.show" class="glyphicon glyphicon glyphicon-minus" aria-hidden="true"></span>
                </button>
                {{dat.Producto}}
            </td>
        </tr>
        <tr ng-if="dat.show">
            <th>Marca</th>
            <th>Tamaño</th>
            <th>Requeridas</th>
            <th>Observaciones</th>
        </tr>
        <tr ng-if="dat.show" ng-repeat="camisa in dat.Camisas">
            <td>{{camisa.Descripcion}}</td>
            <td>{{camisa.Tamano}}</td>
            <td>{{camisa.Requeridas}}</td>
            <td style="width: 70%">{{camisa.Observaciones}}</td>
        </tr>
    </tbody>
</table>