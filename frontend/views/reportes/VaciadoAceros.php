<style>
    td, td th {
        font-size: 9pt;
        padding: 0 !important;
    }
</style>
<div ng-controller="Pruebas" ng-init="Fecha='<?=date('Y-m-d');?>';load('data-vaciado',{Fecha:Fecha})">
    Fecha: <input type="date" ng-change="load('data-vaciado',{Fecha:Fecha});" ng-model="Fecha" format-date />
    <table class="table table-bordered table-condensed">
        <thead>
            <tr>
                <th style="min-width: 200px">Lance</th>
                <th class="text-center texto" ng-repeat="lance in data.lances">{{lance.Lance}}</th>
            </tr>
            <tr>
                <th>Colada</th>
                <th class="text-center texto" ng-repeat="lance in data.lances">{{lance.Colada}}</th>
            </tr>
            <tr>
                <th>Horno Inducto</th>
                <th class="text-center texto" ng-repeat="lance in data.lances">{{lance.HornoConsecutivo}}</th>
            </tr>
            <tr>
                <th>Aleacion</th>
                <th class="text-center texto" ng-repeat="lance in data.lances">{{lance.Aleacion}}</th>
            </tr>
            <tr>
                <th>Hora Vaciado</th>
                <th class="text-center texto" ng-repeat="lance in data.lances">{{lance.Fin || ""}}</th>
            </tr>
            <tr>
                <th>Temp. Horno</th>
                <th class="text-center texto" ng-repeat="lance in data.lances">{{lance.TempHorno || ""}}</th>
            </tr>
            <tr>
                <th>Temp. Olla 1</th>
                <th class="text-center texto" ng-repeat="lance in data.lances">{{lance.TempOlla || ""}}</th>
            </tr>
            <tr>
                <th>Temp. Olla 2</th>
                <th class="text-center texto" ng-repeat="lance in data.lances">{{lance.TempOlla2 || ""}}</th>
            </tr>
            <tr>
                <th>Temp. Olla 3</th>
                <th class="text-center texto" ng-repeat="lance in data.lances">{{lance.TempOlla3 || ""}}</th>
            </tr>
            <tr>
                <th rowspan="2">No Parte (Diseño)</th>
                <td ng-repeat="lance in data.lances">
                    <table class="table" style="margin: 0">
                        <tr>
                            <th class="text-center texto" style="min-width: 50px">MOL</th>
                            <th class="text-center texto" style="min-width: 50px">PZAS</th>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td ng-repeat="lance in data.lances">
                    <table class="table" style="margin: 0">
                        <tr>
                            <th class="success text-center texto" style="min-width: 25px">OK</th>
                            <th class="danger text-center texto" style="min-width: 25px">REC</th>
                            <th class="success text-center texto" style="min-width: 25px">OK</th>
                            <th class="danger text-center texto" style="min-width: 25px">REC</th>
                        </tr>
                    </table>
                </td>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="producto in data.productos">
                <th>{{producto.Producto}}</th>
                <td ng-repeat="lance in data.lances">
                    <table class="table" style="margin: 0">
                        <tr>
                            <td class="success text-center texto" style="min-width: 25px; max-width: 26px;">{{producto['Lance'+lance.Lance]['MoldesOk'] || "&nbsp;"}}</td>
                            <td class="danger text-center texto" style="min-width: 25px; max-width: 26px;">{{producto['Lance'+lance.Lance]['MoldesRec'] || "&nbsp;"}}</td>
                            <td class="success text-center texto" style="min-width: 25px; max-width: 26px;">{{producto['Lance'+lance.Lance]['PiezasOk'] || "&nbsp;"}}</td>
                            <td class="danger text-center texto" style="min-width: 25px; max-width: 26px;">{{producto['Lance'+lance.Lance]['PiezasRec'] || "&nbsp;"}}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <th>Lingotes</th>
                <th class="text-center texto" ng-repeat="lance in data.lances">{{lance.Lingotes || "NO"}}</th>
            </tr>
            <tr>
                <th>KellBlock</th>
                <th class="text-center texto" ng-repeat="lance in data.lances">{{lance.KellBlock || "NO"}}</th>
            </tr>
            <tr>
                <th>Probetas</th>
                <th class="text-center texto" ng-repeat="lance in data.lances">{{lance.Probetas || "NO"}}</th>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th>Total kilos</th>
                <th class="text-center texto" ng-repeat="lance in data.lances">{{lance.Peso}}</th>
            </tr>
            <tr>
                <th>Vaciador</th>
                <th class="text-center texto" ng-repeat="lance in data.lances">{{lance.Vaciador}}</th>
            </tr>
        </tfoot>
    </table>
    
</div>