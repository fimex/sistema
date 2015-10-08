<div class="panel panel-danger">
    <!-- Default panel contents -->
    <div class="panel-heading">Probetas</div>
   
    <div id="detalle" class="scrollable">
        <table class="table table-condensed table-striped table-bordered">
            <thead>
                <tr>
                    <th>fecha moldeo</th>
                    <th class="col-md-1">serie</th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="probeta in probetas">
          
                    <th><select class="form-control" ng-model-options="{updateOn: 'blur'}" ng-model="rechazo.IdDefectoTipo">
                        <option ng-selected="rechazo.IdDefectoTipo == defecto.IdDefectoTipo" ng-repeat="defecto in defectos" value="{{defecto.IdDefectoTipo}}">{{defecto.NombreTipo}}</option>
                        </select></th>
					
                    <th><input class="form-control" type="number" ng-model-options="{updateOn: 'blur'}" ng-model="probeta.fechamoldeo" value="{{rechazo.Rechazadas}}"/></th>
                 
                </tr>
            </tbody>
        </table>
    </div>
</div>