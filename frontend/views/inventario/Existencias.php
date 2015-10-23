<table class="table table-bordered table-striped table-hovered">
     <thead>
         <tr>
             <th class="text-center">SubProceso</th>
             <th class="text-center">Almacen</th>
             <th class="text-center">Producto</th>
             <th rowspan="2" class="text-center vertical-ad">Cantidad</th>
         </tr>
         <tr>
             <th class="text-center"><input class="form-control" ng-model="filter.SubProceso"/></th>
             <th class="text-center"><input class="form-control" ng-model="filter.Descripcion"/></th>
             <th class="text-center"><input class="form-control" ng-model="filter.Identificacion"/></th>
         </tr>
     </thead>
     <tbody>
         <tr ng-repeat="existencia in Existencias | filter:filter">
             <td>{{existencia.SubProceso}}</td>
             <td>{{existencia.Descripcion}}</td>
             <td>{{existencia.Identificacion}}</td>
             <td class="text-center">{{existencia.Cantidad}}</td>
         </tr>
     </tbody>
 </table>