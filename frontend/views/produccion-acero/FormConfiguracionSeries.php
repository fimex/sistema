<div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading">Configuracion Series</div>
    <div class="panel-body">
        <button class="btn btn-success" ng-click="addSerie()">Agregar Serie</button>
    </div>
    <div id="ProductosSeries" class="scrollable">
        <table class="table table-condensed table-striped">
            <thead>
                <tr>
                    <th>No Parte</th>
                    <th style="width: 100px;">Serie</th>
                    <th style="width: 100px;"></th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="series in ProductosSeries" >
                    <th>
                        <select class="form-control"  >
                            <option value="{{producto.IdProducto}}" ng-repeat="producto in productos">{{ producto.Identificacion }}</option>
                        </select>
                    </th>
                    <th style="width: 100px;"><input class="form-control" style="width: 100px;" ng-model-options="{updateOn: 'blur'}" ng-model="series.Serie" value="{{series.Serie}}"/></th>
                    <th><button class="btn btn-danger" ng-click="">Guargar</button></th>
                </tr>
            </tbody>
        </table>
    </div>
</div>
