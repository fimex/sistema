<div ng-init="load('catalogo-almas',{
    IdPresentacion:<?=$IdArea;?>,
})"></div>
<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="col-md-1">Producto<br/><input class="form-control" ng-model="filtro.Producto"/></th>
            <th class="col-md-1">Tipo Alma</th>
            <th class="col-md-1">Almas x Molde</th>
            <th class="col-md-2">Cavidades</th>
            <th class="col-md-2">Almas x hora</th>
            <th class="col-md-2">Receta arena</th>
            <th class="col-md-2">Tipo caja</th>
        </tr>
    </thead>
    <tbody>
        <tr ng-repeat="dat in data | filter:filtro">
            <td>{{dat.Producto}}</td>
            <td>{{dat.Alma}}</td>
            <td>{{dat.PiezasMolde}}</td>
            <td>{{dat.PiezasCaja}}</td>
            <td>{{dat.TiempoLlenado | currency:"":0}}</td>
            <td>{{dat.AlmaReceta}}</td>
            <td>{{dat.MaterialCaja}}</td>
        </tr>
    </tbody>
</table>