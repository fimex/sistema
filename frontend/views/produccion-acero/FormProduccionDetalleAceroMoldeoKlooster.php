<style type="text/css">
    .third-elm{
        color:red;
    }
</style>
<div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading">Captura de produccion</div>
    <div id="detalle">
        <table ng-table class="table table-condensed table-striped table-bordered">
            <tr>
                <th class="width-40" colspan="2" ></th>
                <th class="width-20 text-center" colspan="2"  >Faltan</th>
                <th rowspan="{{programacionAceros.length + 2}}"></th>
                <th colspan="5" class="text-center" >Datos</th>
                <th rowspan="{{programacionAceros.length + 2}}"></th>
                <th colspan="6" class="text-center">Ciclos</th>
                <th rowspan="{{programacionAceros.length + 2}}"></th>
                <th colspan="2" class="text-center"  >Moldes</th>
                <th rowspan="{{programacionAceros.length + 2}}"></th>
                <th rowspan="{{programacionAceros.length + 2}}"></th>
                <th colspan="4" class="text-center"  >Cerrados</th>
                <th rowspan="{{programacionAceros.length + 2}}"></th>
                <th colspan="2" class="text-center"  >Vaciados</th>
            </tr>
            <tr>
                <th>Pr</th>
                <th class="width-40">Prg</th>
                <th class="width-20">Llenado</th>
                <th class="width-20">Cerrado</th>
                <th class="width-50">No Parte</th>
                <th>Aleacion</th>
                <th>Serie</th>
                <th>CxM</th>
                <th class="width-80">Cic Req</th>   
                <th colspan="2" class="width-30">OK</th>
                <th colspan="2" class="width-30">Rech</th>
                <th colspan="2">Reposicion</th>
                <th class="width-40">OK</th>
                <th class="width-40">RECH</th>
                <th colspan="2" class="width-40">Ok</th>
                <th colspan="2" class="width-30">Rech</th>
                <th class="width-40">Ok</th>
                <th class="width-30">Rech</th>
            </tr> 
            <tr ng-class="{'info': indexDetalle == $index}" ng-repeat="detalle in programacionAceros">
                <th>{{detalle.Prioridad}}</th>
                <th>{{detalle.Programadas}}</th>
                <th>{{detalle.Programadas - detalle.Llenadas | currency:"":1}}</th>
                <th>{{detalle.OKMoldeo - detalle.Cerradas}}</th>
                <td class="col-md-3">{{detalle.Producto}}</td>
                <th>{{detalle.Aleacion}}</th>
                <th ng-class="{'danger':!detalle.SerieInicio && detalle.LlevaSerie}">{{detalle.SerieInicio || '--'}}</th>
                <th>{{detalle.CiclosMolde}}</th>
                <th>{{ IdAreaAct == 1 ? (detalle.CiclosMolde * detalle.Programadas) - detalle.OKMoldeo + (detalle.REPMoldeo - detalle.RECCerrado) : ( IdAreaAct == 2 ? (detalle.CiclosMolde * detalle.Programadas) - (detalle.OKVarel*1) + (detalle.RECVarel*1) + (detalle.REPVarel - detalle.RECCerrado) : (detalle.CiclosMolde * detalle.Programadas) - (detalle.Llenadas*1) + (detalle.Rechazadas*1) + (detalle.REPEspecial - detalle.RECCerrado) ) }}</th>
                <th colspan="4" ng-show="!detalle.SerieInicio && detalle.LlevaSerie">Configurar serie para poder capturar</th>
                <th ng-show="!(!detalle.SerieInicio && detalle.LlevaSerie)">
                    <button type="button" ng-click="saveDetalleAcero($index,1);" class="btn btn-success btn-sm">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </button>
                </th>
                <th ng-show="!(!detalle.SerieInicio && detalle.LlevaSerie)">{{ IdAreaAct == 1 ? detalle.OKMoldeo  : (IdAreaAct == 2 ? (detalle.OKVarel - detalle.RECVarel) : (detalle.Llenadas - detalle.Rechazadas) ) }}</th>
                <th ng-show="!(!detalle.SerieInicio && detalle.LlevaSerie)">
                    <button type="button" ng-click="activaBtnCerrado(16);ModelMoldeo($index,4); MostrarSeries(detalle.IdProducto,<?= $IdSubProceso; ?>);" class="btn btn-danger btn-sm">
                        <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                    </button>
                </th>
                <th ng-show="!(!detalle.SerieInicio && detalle.LlevaSerie)">{{ IdAreaAct == 1 ? detalle.RECMoldeo : ( IdAreaAct == 2 ? detalle.RECVarel || 0 : detalle.Rechazadas*1 || 0 )  }}</th>
                <th>
                    <button type="button" ng-click="activaBtnCerrado(15);ModelMoldeo($index,9);" class="btn btn-info btn-sm">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </button>
                </th>
                <th>{{detalle.REPMoldeo}}</th>
                <th>{{detalle.Llenadas | currency:"":1}}</th>
                <th>{{detalle.OKCerrado || 0}}</th>
                
                <th></th>
                <th>{{detalle.Cerradas | currency:"":1}}</th>
                <th></th>
                <th>{{detalle.RECCerrado | currency:"":1}}</th>

                <th>{{detalle.VaciadoOK || 0}}</th>
                <th>{{detalle.VaciadoREC || 0}}</th>
            </tr>
        </table>

        <!--#####################################################
        ########################   Modal ########################
        #########################################################-->

        <!--########################### CICLOS REPOSICION KLOOSTER ########################-->
        <modal title="" visible="showModalREP">
            <h3>{{title}}</h3>
            <div style="height: 500px;">
                <div class="form-group">
                    <label for="producto">No Parte: </label> <label style="color:green;" >{{programacionAceros[index].Producto}}</label>
                    <input type="hidden" class="form-control" ng-model="idproducto" value="idproducto" id="Producto" />
                </div>

                <div style="float:left; width:30%;">
                    <label>Parte del Molde</label><br>
                    <div ng-repeat="parte in partes">
                        <label>
                            <input type="radio" name="Parte" ng-model="IdParteMolde" ng-click="activaBtnCerrado(1);selectParte(parte.IdParteMolde);" ng-value="parte.IdParteMolde"> {{parte.Identificador}}
                        </label><br/>
                    </div>
                </div>

                <div style="float:left; width:60%;" >
                    <label style="text-align:center;" ng-show="programacionAceros[index].SerieInicio && showserie" >
                        Serie: 
                        <label style="color:green; font-size:15pt;">{{programacionAceros[index].SerieInicio}}</label>

                        <select ng-model="indexSerie" ng-change="selectSerie(indexSerie)">
                            <option ng-value="$index" ng-repeat="serie in listadoseries">{{serie.Serie}}</option>
                        </select>
                    </label>

                    <fieldset id="btn-ciclo" disabled="true">
                        <button class="btn btn-success" data-dismiss="modal" ng-click="saveDetalleAcero(index,10);" class="btn btn-default">Agregar</button>
                    </fieldset>
                </div>
            </div>
        </modal>
        
        <!--########################### CICLOS RECHAZADOS KLOSTER ########################-->
        <modal title="Ciclos Rechazados Kloster" visible="showModalCRK">
           <div style="height:300px;" >
                <div class="form-group">
                    <label for="producto">No Parte: </label> <label style="color:green;" >{{programacionAceros[index].Producto}}</label>
                    <input type="hidden" class="form-control" ng-model="idproducto" value="idproducto" id="Producto" />
                </div>  
                <div style="float:left; width:30%;">
                    <label>Parte del Molde</label><br>
                    <div ng-repeat="parte in partes">
                        <label>
                            <input type="radio" ng-model="programacionAceros[index].IdPartesMoldes" ng-click="activaBtnCerrado(4);getSerie(parte.IdParteMolde,programacionAceros[index].IdConfiguracionSerie,1);" name="ParteR" ng-value="parte.IdParteMolde"> {{parte.Identificador}} 
                        </label><br/>
                    </div>
                </div>

                <div style="float:left; width:60%;" >
                    <div id="lb-serie" > 
                        <label style="text-align:center;" ng-show="showserie" >
                            Serie: 
                            <label style="color:red; font-size:15pt;">{{programacionAceros[index].SerieInicio}}</label>
                        </label><br>
                    </div>
                    <fieldset id="btn-rechazoK" disabled="true">
                        <button class="btn btn-danger" data-dismiss="modal" ng-click="saveDetalleAcero(index, 3);" class="btn btn-default">Rechazar</button>
                    </fieldset>
                </div>
            </div>
        </modal>
    </div>
</div>

