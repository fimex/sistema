<style type="text/css">
    .third-elm{
        color:red;
    }
</style>
<div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading">Captura de produccion</div>
    <div id="detalle">
        <table ng-table class="table table-condensed table-striped table-bordered">
            <tr>
                <th class="width-20">Producto</th>
                <th class="width-20">Componente</th>
                <th>Fecha rechazo</th>
                <th></th>
            </tr> 
            <tr ng-class="{'info': indexDetalle == $index}" ng-repeat="detalle in Componentes">
                <th>{{detalle.Producto}}</th>
                <th>{{detalle.Componente}}</th>
                <th>{{detalle.Dia}}</th>
                <th></th>
            </tr>
        </table>
    </div>
</div>

