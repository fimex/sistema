<style type="text/css">
    .third-elm{
        color:red;
    }
</style>
<div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading">Captura de Reposiciones</div>
    <div id="detalle">
        <table ng-table class="table table-condensed table-striped table-bordered">
            <tr>
                <th class="width-20">Producto</th>
                <th class="width-20">Componente</th>
                <th>Fecha de Creacion</th>
                <th></th>
            </tr> 
            <tr ng-repeat="detalle in Componentes">
                <th>{{detalle.Producto}}</th>
                <th>{{detalle.Componente}}</th>
                <th>{{detalle.FechaCreacion}}</th>
                <th> 
                    <button type="button" ng-click="selectComponente(detalle.IdComponente); saveReposicion($index,10);" class="btn btn-info btn-sm">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </button>
                </th>
            </tr>
        </table>
    </div>
</div>