<div ng-controller="Pruebas" ng-init="load('data-pedidos',{
    IdArea: <?=$IdArea?>,
})">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>OrdenCompra<span><input class="form-control" ng-model="filter.OrdenCompra" /></span></th>
                <th>Productos<span><input class="form-control" ng-model="filter.Producto" /></span></th>
                <th>Casting<span><input class="form-control" ng-model="filter.ProductoCasting" /></span></th>
                <th>Saldo<span><input class="form-control" ng-model="filter.SaldoCantidad" /></span></th>
                <th>Estatus
                    <span><select input class="form-control" ng-model="filter.Estatus">
                        <option value="">Todos</option>
                        <option value="Abierto">Abierto</option>
                        <option value="Cerrado">Cerrado</option>
                    </select></span>
                </th>
            </tr>
        </thead>
        <tbody >
            <tr ng-repeat="dat in data | filter:{
                OrdenCompra:filter.OrdenCompra,
                Producto:filter.Producto,
                ProductoCasting:filter.ProductoCasting,
                SaldoCantidad:filter.SaldoCantidad,
                Estatus:filter.Estatus
            }">
                <td>{{dat.OrdenCompra}}</td>
                <td>{{dat.Producto}}</td>
                <td>{{dat.ProductoCasting}}</td>
                <td>{{dat.SaldoCantidad | currency:"":0}}</td>
                <td>{{dat.Estatus}}</td>
            </tr>
       </tbody>
    </table>
</div>