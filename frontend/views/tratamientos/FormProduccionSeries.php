<div class="panel panel-danger">
    <!-- Default panel contents -->
    <div class="panel-heading">Series</div>
   
    <div id="detalle" class="scrollable">
        <table class="table table-condensed">
            <thead>
                <tr>
                    <th>fecha moldeo</th>
                    <th class="col-md-1">serie</th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="serie in series">
          
                    <th><input class="form-control" type="number" ng-model-options="{updateOn: 'blur'}" ng-model="serie.serie" value="{{rechazo.Rechazadas}}"/></th>
                    <th><input class="form-control" type="number" ng-model-options="{updateOn: 'blur'}" ng-model="serie.fechamoldeo" value="{{rechazo.Rechazadas}}"/></th>
                 
                </tr>
            </tbody>
        </table>
    </div>
</div>