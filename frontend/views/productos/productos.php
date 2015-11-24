<style>
    .scrollable {
        margin: auto;
        height: 300px;
        border: 2px solid #ccc;
        overflow-y: scroll; /* <-- here is what is important*/
    }
</style>
<div ng-controller="Productos" ng-init="IdPresentacion = <?=$area ?>;loadProductos();">
    <div class="row">
        <div class="panel panel-info">
            <div ng-click="Mostrar = !Mostrar;" class="panel-heading"><span>Listado de productos <span class="seleccion glyphicon " ng-class="{'glyphicon-triangle-top':!Mostrar,'glyphicon-triangle-bottom':Mostrar}" aria-hidden="true"></span></span></div>
            <div class="panel-body" style="overflow: hidden" ng-show="!Mostrar">
                <div id="productos" class="scrollable">
                <table fixed-table-headers="productos" class="table table-striped table-bordered table-hover table-hovered">
                    <thead>
                        <tr class="active">
                            <th>
                                <ordenamiento title="Cliente" arreglo="arr" element="Marca"></ordenamiento>
                                <input class="form-control" ng-model="filtro.Marca" />
                            </th>
                            <th>
                                <ordenamiento title="Producto" arreglo="arr" element="Identificacion"></ordenamiento>
                                <input class="form-control" ng-model="filtro.Identificacion" />
                            </th>
                            <th>
                                <ordenamiento title="Casting" arreglo="arr" element="ProductoCasting"></ordenamiento>
                                <input class="form-control" ng-model="filtro.ProductoCasting" />
                            </th>
                            <th>
                                <ordenamiento title="Aleacion" arreglo="arr" element="Aleacion"></ordenamiento>
                                <input class="form-control" ng-model="filtro.Aleacion" />
                            </th>
                            <th>
                                <ordenamiento title="Peso Araña" arreglo="arr" element="PesoAraniaA"></ordenamiento>
                                <input class="form-control" ng-model="filtro.PesoAraniaA" />
                            </th>
                            <th>
                                <ordenamiento title="Peso Casting" arreglo="arr" element="PesoCasting"></ordenamiento>
                                <input class="form-control" ng-model="filtro.ProductoCasting" />
                            </th>
                            <th>
                                <ordenamiento title="Ensamble" arreglo="arr" element="Ensamble"></ordenamiento>
                                <input class="form-control" ng-model="filtro.Ensamble" />
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="p in productos | filter:filtro | orderBy:arr" ng-click="selectProducto(p)" ng-class="{'info': producto.IdProducto == p.IdProducto}">
                            <td>{{p.Marca}}</td>
                            <td>{{p.Identificacion}}</td>
                            <td>{{p.ProductoCasting}}</td>
                            <td>{{p.Aleacion}}</td>
                            <td>{{p.PesoAraniaA}}</td>
                            <td>{{p.PesoCasting}}</td>
                            <td>{{p.Ensamble}}</td>
                        </tr>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
    <h3>Producto :: {{producto.Identificacion}}</h3>
    <div class="row">
        <div class="col-md-12">
            <?= $this->render('FormMoldeo');?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= $this->render('FormAlmas');?>
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-md-4">
            <?= $this->render('FormCajas');?>
        </div>
        <div class="col-md-4">
            <?= $this->render('FormCamisas');?>
        </div>
        <div class="col-md-4">
            <?= $this->render('FormFiltros');?>
        </div>
    </div>
</div>