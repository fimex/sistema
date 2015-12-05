<!--<div class="container-fluid" ng-controller="TiemposMuertos" ng-init="loadTiempos(); loadFallas();" >-->
    <!-- Default panel contents -->
   

    <div id="ciclos" class="scrollable">
        <table class="table table-condensed table-striped">
            <thead>
                <tr>

                    <th style="width: 30px;">idProdCiclo</th>
                    <th style="width: 30px;">Tipo</th>
                    <th style="width: 30px;">Idstatus</th>
                    <th style="width: 30px;">linea</th>
                </tr>
            </thead>
			
            <tbody>
                <tr 
                    ng-repeat="ciclo in ciclos"
                   ng-class="{'info': indexDetalleCiclo == $index}"
                >
                   
                    <th ng-click="selectDetalleCiclo($index);"  >{{ciclo.IdProduccionCiclos}}</th>
                    <th ng-click="selectDetalleCiclo($index);" style="width: 30px;">{{ciclo.tipo}}</th>
                    <th ng-click="selectDetalleCiclo($index);" style="width: 30px;">{{ciclo.estatus}}</th>
                    <th style="width: 30px;"  ng-hide= " ciclo.tipo != 'Molde' " >{{ciclo.Linea}}
					
					<button type="button" ng-click="deleteCiclos($index);" class="btn btn-danger btn-sm">
                        <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                    </button>
					
					</th>
                    
                </tr>
            </tbody>
        </table>
    </div>
	 <div id="ciclosdetalle" class="scrollable">
        <table class="table table-condensed table-striped">
            <thead>
                <tr>

                    <th style="width: 30px;">IdProduccionCiclosDetalle</th>
                    <th style="width: 30px;">producto</th>
                    <th style="width: 30px;">Identificador</th>
					
                </tr>
            </thead>
			
            <tbody>
                <tr 
                    ng-repeat="ciclo in ciclosdetalle"
                   
                >
                   
                    <th style="width: 30px;">{{ciclo.IdProduccionCiclosDetalle}}</th>
                    <th style="width: 30px;">{{ciclo.Identificacion}}</th>
                    <th  style="width: 30px;">{{ciclo.Identificador}}
					
					<button type="button" ng-click="deleteCiclosDetalle($index);" class="btn btn-danger btn-sm">
                        <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                    </button>
					
					</th>
                    
                </tr>
            </tbody>
        </table>
    </div>
	
<!--</div>-->