<!--<div class="container-fluid" ng-controller="TiemposMuertos" ng-init="loadTiempos(); loadFallas();" >-->
    <!-- Default panel contents -->
   

    <div id="ciclos" class="scrollable">
        <table class="table table-condensed table-striped">
            <thead>
                <tr>

                    <th style="width: 30px;">Orden hechas</th>
                    
                    <th style="width: 30px;">Estatus</th>
                    <th style="width: 30px;">Fecha</th>
                    <th style="width: 30px;">Tipo Comp</th>
                    <th style="width: 30px;">serie</th>
                </tr>
            </thead>
			
            <tbody>
                <tr 
                    ng-repeat="ciclo in ciclosdetalle"
                >
                   
                    <th>{{ciclo.numeroRegistroConsultado}}</th>
                    <th style="width: 30px;">{{ciclo.estatus}}</th>
                    <th style="width: 30px;">{{ciclo.Fecha}}</th>
                    <th style="width: 30px;">{{ciclo.Identificador}}</th>
                    <th style="width: 30px;"  >{{ciclo.Serie}}
					
					<button type="button" ng-click="deleteCiclos($index);" class="btn btn-danger btn-sm">
                        <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                    </button>
					
					</th>
                    
                </tr>
            </tbody>
        </table>
    </div>
	 
	
<!--</div>-->