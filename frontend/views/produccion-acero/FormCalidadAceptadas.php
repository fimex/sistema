    <div class="panel panel-primary">
        <div id="capturaAceptadas">
            <div class="panel-heading">Captura de series Aceptadas</div>
            <div class="contenido" id="contenido" ng-model="contenido" ng-style="bgColor={'background':'#ffffff'}">
                <div class="form-group left">
                    <div class="box-header">
                        Disponibles: {{dSeries.length}}
                    </div><div class="box-header">
                        <!--Aceptadas: {{aSeries.length}} de {{datos.Aceptadas}}
                        <input type="hidden" ng-model="comparacion" ng-value="comparacion = aSeries.length < datos.Aceptadas ? true : false">-->
                        Aceptadas: {{aSeries.length}}
                    </div>
                </div>
                <div class="form-group left">
                    <div class="repetido">
                        <div class="noScroll">
                            <div class="con-series" ng-repeat="seried in dSeries">
                                <!--<div ng-if="comparacion" ng-click="saveSeriesAceptadas(seried.IdSerie, datos.IdCentroTrabajoDestino);">{{seried.Serie}}</div>
                                <div ng-if="!comparacion">{{seried.Serie}}</div>-->
                                <div ng-click="saveSeriesAceptadas(seried.IdSerie, datos.IdCentroTrabajoDestino);">{{seried.Serie}}</div>
                            </div>
                        </div>
                    </div><div class="repetido">
                        <div class="noScroll">
                            <div class="con-series" ng-repeat="seriea in aSeries">
                                <div ng-click="saveSeriesAceptadas(seriea.IdSerie, IdAreaAct);">{{seriea.Serie}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>