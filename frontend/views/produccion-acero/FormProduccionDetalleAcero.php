<style type="text/css">
    .third-elm{
        color:red;
    }
</style>
<div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading">Captura de produccion {{IdSubProceso}}</div>
    <div id="detalle">
        <table ng-table class="table table-condensed table-striped table-bordered">
                <tr>
                    <th class="width-40" colspan="2" ></th>
                    <th class="width-20 text-center" colspan="2"  >Faltan</th>
                    <th rowspan="{{programacionAceros.length + 2}}"></th>
                    <th colspan="5" class="text-center" >Datos</th>
                    <th rowspan="{{programacionAceros.length + 2}}"></th>
                    <th colspan="4" class="text-center" ng-show="IdSubProceso != 17">Ciclos</th>
                    <th colspan="4" class="text-center" ng-show="IdSubProceso == 17">Moldes</th>
                    <th rowspan="{{programacionAceros.length + 2}}"></th>
                    <?php if($IdSubProceso != 17): ?>
                    <th colspan="2" class="text-center"  >Moldes</th>
                    <th rowspan="{{programacionAceros.length + 2}}"></th>
                    <th colspan="4" class="text-center" ng-show="IdSubProceso == 8">Pintado</th>
                    <th rowspan="{{programacionAceros.length + 2}}"></th>
                    <th colspan="4" class="text-center"  >Cerrados</th>
                    <th rowspan="{{programacionAceros.length + 2}}"></th>
                    <?php endif ?>
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
                    <?php if($IdSubProceso != 17): ?>
                    <!-- Ciclos llenados -->
                    <th class="width-40">OK</th>
                    <th class="width-40">RECH</th>
                    <th colspan="2" class="width-40" ng-show="IdSubProceso == 8">Ok</th>
                    <th colspan="2" class="width-30" ng-show="IdSubProceso == 8">Rech</th>
                    <th colspan="2" class="width-40">Ok</th>
                    <th colspan="2" class="width-30">Rech</th>
                    <?php endif ?>
                    <th class="width-40">Ok</th>
                    <th class="width-30">Rech</th>
                </tr>   
                <tr ng-class="{'info': indexDetalle == $index}" ng-repeat="detalle in programacionAceros">
                    <th>{{detalle.Prioridad}}</th>
                    <th>{{detalle.Programadas}}</th>
                    <th>{{detalle.Programadas - detalle.Llenadas}}</th>
                    <th>{{detalle.OKMoldeo - detalle.Cerradas}}</th>
                    <td class="col-md-3">{{detalle.Producto}}</td>

                    <th>{{detalle.Aleacion}}</th>
                    <th ng-class="{'danger':!detalle.SerieInicio && detalle.LlevaSerie}">{{detalle.SerieInicio || '--'}}</th>

                    <th>{{detalle.CiclosMolde}}</th>
                    <th>{{ IdAreaAct == 1 ? (detalle.CiclosMolde * detalle.Programadas) - detalle.OKMoldeo + (detalle.REPMoldeo - detalle.RECCerrado) : ( IdAreaAct == 2 ? (detalle.CiclosMolde * detalle.Programadas) - (detalle.OKVarel*1) + (detalle.RECVarel*1) + (detalle.REPVarel - detalle.RECCerrado) : (detalle.CiclosMolde * detalle.Programadas) - (detalle.Llenadas*1) + (detalle.Rechazadas*1) + (detalle.REPEspecial - detalle.RECCerrado) ) }}</th>
                    <!--<th>{{ IdAreaAct != 2 ? (detalle.CiclosMolde * detalle.Programadas) - detalle.OKMoldeo + (detalle.REPMoldeo - detalle.RECCerrado) : (detalle.CiclosMolde * detalle.Programadas) - (detalle.OKVarel*1) + (detalle.RECVarel*1) + (detalle.REPVarel - detalle.RECCerrado) }}</th>-->

                    <th colspan="4" ng-show="!detalle.SerieInicio && detalle.LlevaSerie">Configurar serie para poder capturar</th>
                    <th ng-show="!(!detalle.SerieInicio && detalle.LlevaSerie)"><button type="button" ng-show="(IdSubProceso == 6 || IdSubProceso == 7 || IdSubProceso == 17)" ng-click="ModelMoldeo($index,1);" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button></th>
                    <th ng-show="!(!detalle.SerieInicio && detalle.LlevaSerie)">{{ IdAreaAct == 1 ? detalle.OKMoldeo  : (IdAreaAct == 2 ? (detalle.OKVarel - detalle.RECVarel) : (detalle.Llenadas - detalle.Rechazadas) ) }}</th>
                    <!--<th ng-show="!(!detalle.SerieInicio && detalle.LlevaSerie)">{{ IdAreaAct != 2 ? detalle.OKMoldeo  : (IdAreaAct == 3 ? (detalle.OKVarel - detalle.RECVarel) : detalle.OKEspecial ) }}</th>-->
                    <th ng-show="!(!detalle.SerieInicio && detalle.LlevaSerie)">
                    <button type="button" ng-show="IdSubProceso == 6" ng-click="ModelMoldeo($index,3); MostrarSeries(detalle.IdProducto,<?= $IdSubProceso; ?>);" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span></button>
                    <button type="button" ng-show="IdSubProceso == 7 || IdSubProceso == 17" ng-click="ModelMoldeo($index,3);" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span></button></th>
                    <th ng-show="!(!detalle.SerieInicio && detalle.LlevaSerie)">{{ IdAreaAct == 1 ? detalle.RECMoldeo : ( IdAreaAct == 2 ? detalle.RECVarel || 0 : detalle.Rechazadas*1 || 0 )  }}</th>
                    <!--<th ng-show="!(!detalle.SerieInicio && detalle.LlevaSerie)">{{ IdAreaAct != 2 ? detalle.RECMoldeo : detalle.RECVarel || 0 }}</th>-->

                    <th ng-show="IdSubProceso != 17">{{detalle.Llenadas | currency:"":1}}</th>
                    <th ng-show="IdSubProceso != 17">{{detalle.OKCerrado || 0}}</th>
                    
                    <th ng-show="IdSubProceso == 8 && (detalle.Llenada - detalle.Cerradas) > 0 "><button type="button" ng-click="ModelMoldeo($index,1);" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button></th>
                    <th ng-show="IdSubProceso == 8">{{detalle.OKPintura || 0}}</th>
                    <th ng-show="IdSubProceso == 8 && (detalle.Llenada - detalle.Cerradas) > 0 "><button type="button" ng-click="ModelMoldeo($index,3);" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span></button></th>
                    <th ng-show="IdSubProceso == 8">{{detalle.RECPintura || 0}}</th>

                    <?php if($IdSubProceso != 17): ?>
                    <th><button type="button" ng-show="(IdSubProceso == 9) && (detalle.SerieInicio && detalle.LlevaSerie == 'Si')" ng-click="ModelMoldeo($index,1);" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
                    <button type="button" ng-show="(IdSubProceso == 9) && (detalle.LlevaSerie != 'Si')" ng-click="saveDetalleAcero($index,1);" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button></th>
                    <th>{{detalle.Cerradas | currency:"":1}}</th>
                    <th><button type="button" ng-show="IdSubProceso == 9" ng-disabled="(detalle.Llenada - detalle.Cerradas) > 0" ng-click="ModelMoldeo($index,3);" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span></button></th>
                    <th>{{detalle.RECCerrado || 0}}</th>
                    <?php endif ?>

                    <th>{{detalle.VaciadoOK || 0}}</th>
                    <th>{{detalle.VaciadoREC || 0}}</th>
                </tr>
        </table>

        <!--#####################################################
        ########################   Modal ########################
        #########################################################-->

        <!--########################### Ciclos Ok Varel ########################-->
        <modal title="" visible="showModal">
            <h3>{{title}}</h3>
            <div style="height: 500px;">
                <div class="form-group">
                    <label for="producto">No Parte: </label> <label style="color:green;" >{{programacionAceros[index].Producto}}</label>
                    <input type="hidden" class="form-control" ng-model="idproducto" value="idproducto" id="Producto" />
                </div>

                <div style="float:left; width:30%;">
                    <label>Parte del Molde</label><br>
                    <div ng-repeat="parte in partes" ng-show="((IdSubProceso == 6 || IdSubProceso == 7 || IdSubProceso == 17))">
                        <label ng-if="IdAreaAct != '2' || parte.Identificador != 'Cabeza'">
                            <?php if($IdAreaAct != 2): ?>
                                <input checked="true" type="checkbox" name="Parte" ng-model="IdParteMolde" ng-click="selectParte(parte.IdParteMolde);"  ng-value="parte.IdParteMolde"> {{parte.Identificador}} <?php endif ?>
                            <?php if($IdAreaAct == 2): ?>
                                <!--<input type="checkbox" name="Parte" ng-model="IdParteMolde" ng-click="selectParte(parte.IdParteMolde);" ng-checked="true" ng-value="parte.IdParteMolde" id="{{parte.Identificador}}1" > {{parte.Identificador}} -->
                                <label ng-if="parte.Num <= programacionAceros[index].CiclosMolde " >{{parte.Num }}<input type="checkbox" ng-checked="true"  name="Parte" ng-model="IdParteMolde" ng-click="selectParte(parte.IdParteMolde);" ng-value="parte.IdParteMolde" id="{{parte.Identificador}}" > {{parte.Identificador}} </label>
                            <?php endif ?>
                        </label><br/>
                    </div>
                </div>

                <div style="float:left; width:60%;" >
                    <label style="text-align:center;" ng-show="programacionAceros[index].SerieInicio" >
                        Serie: 
                        <label ng-show="((IdSubProceso == 6 && programacionAceros[index].IdParteMolde == IdParteMolde)) || IdSubProceso == 7 || IdSubProceso == 17"style="color:green; font-size:15pt;">{{programacionAceros[index].SerieInicio}}</label>

                        <select ng-show="((IdSubProceso != 6 && IdSubProceso != 7 && IdSubProceso != 17))" ng-model="indexSerie" ng-change="selectSerie(indexSerie)">
                            <option ng-value="$index" ng-repeat="serie in listadoseries">{{serie.Serie}}</option>
                        </select>
                    </label>

                    <div ng-show="IdSubProceso != 9" class="checkbox">
                        <label>
                            <input id="Reposicion" name="Reposicion" ng-model="Reposicion" ng-change="selectReposicion(Reposicion);" type="checkbox" ng-true-value="'SI'" ng-false-value="'NO'"> Reposici&oacute;n
                        </label>
                    </div>
                    <fieldset id="btn-ciclo">
                        <button class="btn btn-success" data-dismiss="modal" ng-show="(IdSubProceso == 6 || IdSubProceso == 7 || IdSubProceso == 17)" ng-click="saveDetalleAcero(index,estatus);" class="btn btn-default">Agregar</button>
                        <button class="btn btn-success" data-dismiss="modal" ng-disabled="programacionAceros[index].LlevaSerie == 'Si' && indexSerie == null" ng-show="!(IdSubProceso == 6 || IdSubProceso == 7 || IdSubProceso == 17)" ng-click="indexSerie=null;saveDetalleAcero(index,estatus);" class="btn btn-default">Agregar</button>
                    </fieldset>
                </div>
            </div>
        </modal>
        <!--########################### Ciclos Rechazos Varel y Especial ########################-->
        <modal title="Ciclos Rechazados" visible="showModalR">
            <div style="height: 500px;">
                <div class="form-group">
                    <label for="producto">No Parte: </label> <label style="" >{{programacionAceros[index].Producto}}</label>
                    <input type="hidden" class="form-control" ng-model="idproducto" value="{{programacionAceros[index].IdProducto}}" id="Producto" />
                </div>

                <div style="float:left; width:30%;">
                    <label>Parte del Molde</label><br>
                    <div ng-repeat="parte in partes">
                        <label ng-if="IdAreaAct != '2' || parte.Identificador != 'Cabeza'">
                            <input type="radio" ng-model="IdParteMolde" name="ParteR" ng-value="parte.IdParteMolde" ng-change="getSerie({{parte.IdParteMolde}},{{programacionAceros[index].IdProducto}},0,<?= $IdSubProceso; ?>); "> {{parte.Identificador}}
                        </label><br/>
                    </div>
                </div>

                <div style="float:left; width:60%;" >
                    <!--<label style="text-align:center;" >Serie: {{serieproducto.SerieInicio}}</label> <br>-->
                    <div class="input-group">
                        <span id="Series" class="input-group-addon">Series:</span>
                        <!--<select id="series" aria-describedby="Series" ng-model="serie.Serie" class="form-control input-sm" required>
                            <option value="{{series.Serie}}" name="Serie" ng-repeat="series in listadoseries">{{series.Serie}}</option>
                        </select>-->
                        <select ng-model="indexSerie" ng-change="selectSerie(indexSerie);indexSerie=null;"  class="form-control input-sm" >
                            <option ng-value="$index"  ng-repeat="serie in listadoseries">{{serie.Serie}}</option>
                        </select>
                    </div>
                    <br>
                    <label>Comentarios:</label><textarea cols="15" rows="5" class="form-control" ng-model-options="{updateOn: 'blur'}" ng-model="Descripcion" value="{{Descripcion}}"></textarea><br>
                    <!--<button class="btn btn-success" data-dismiss="modal" ng-click="saveDetalleAcero(index, idproducto, serieproducto.SerieInicio, serieproducto.IdConfiguracionSerie, serieproducto.IdParteMolde,'R',FechaMoldeo,'',6,series.Serie,Descripcion);" class="btn btn-default">Agreagar</button>-->
                    <fieldset id="btn-rechazoV" >
                        <!--<button class="btn btn-danger" id="" data-dismiss="modal" ng-click="saveDetalleAcero(index, idproducto, serieproducto.SerieInicio, serieproducto.IdConfiguracionSerie, serieproducto.IdParteMolde,area,FechaMoldeo2,'NO',6,series.Serie,Descripcion);" class="btn btn-default">Rechazar</button>-->
                        <button class="btn btn-danger" id="" data-dismiss="modal" ng-click="saveDetalleAcero(index,estatus);" class="btn btn-default">Rechazar</button>
                    </fieldset>
                </div>
            </div>
        </modal> 
        <!--########################### Ciclos Ok Kloster ########################-->
        <modal title="Captura de Ciclos" visible="showModalK">
            <div style="height:300px;" >
                <div class="form-group">
                    <label for="producto">No Parte: </label> <label style="color:green;" >{{producto}}</label>
                    <input type="hidden" class="form-control" ng-model="idproducto" value="idproducto" id="Producto" />
                </div>

                <div style="float:left; width:30%;">
                    <label>Parte del Molde</label><br>
                    <div ng-repeat="parte in partes">
                        <label ng-if="IdAreaAct != '2' || parte.Identificador != 'Cabeza'">
                            <input type="checkbox"  name="Partes[]" value="{{parte.IdParteMolde}}" ng-model="IdParteMolde"  ng-change="getSerie({{parte.IdParteMolde}},idproducto,0); " > {{parte.Identificador}}
                        </label><br/>
                    </div>
                </div>

                <div style="float:left; width:60%;" >
                    <label style="text-align:center;" ng-show="serieproducto.SerieInicio" >Serie: <label style="color:green; font-size:15pt;">{{serieproducto.SerieInicio}}</label></label>
                    <div class="checkbox">
                        <label>
                            <input id="Reposicion" name="Reposicion" ng-model="Reposicion" type="checkbox" ng-true-value="'SI'" ng-false-value="'NO'"> Reposici&oacute;n
                        </label>
                    </div>
                    <fieldset >
                        <button class="btn btn-success" data-dismiss="modal" ng-click="saveDetalleAcero(index, idproducto, serieproducto.SerieInicio, serieproducto.IdConfiguracionSerie, serieproducto.IdParteMolde,1,FechaMoldeo2,Reposicion,6,'A');" class="btn btn-default">Agreagar</button>
                    </fieldset>
                </div>
            </div>
        </modal>
        <!--########################### Ciclos Rechazo Kloster ########################-->
        <modal title="Ciclos Rechazados Kloster" visible="showModalCRK">
           <div style="height:300px;" >
                <div class="form-group">
                    <label for="producto">No Parte: </label> <label style="color:green;" >{{producto}}</label>
                    <input type="hidden" class="form-control" ng-model="idproducto" value="idproducto" id="Producto" />
                </div>
                <div style="float:left; width:30%;">
                    <label>Parte del Molde</label><br>
                    <div ng-repeat="parte in partes">
                        <label>
                            <input type="radio" ng-model="parte.IdParteMolde" ng-change="activaBtnCerrado(4); getSerie({{parte.IdParteMolde}},idproducto,1);" name="ParteRK" value="parte.IdParteMolde" > {{parte.Identificador}}
                        </label><br/>
                    </div>
                </div>

                <div style="float:left; width:60%;" >
                    <div id="lb-serie" > 
                        <label style="text-align:center;" ng-show="serieproducto.SerieInicio" >Serie: <label style="color:red; font-size:15pt;">{{serieproducto.SerieInicio}}</label></label><br>
                    </div>
                    <fieldset id="btn-rechazoK" disabled="true">
                        <!--<button class="btn btn-danger" data-dismiss="modal" ng-click="saveDetalleAcero(index, idproducto, serieproducto.SerieInicio, serieproducto.IdConfiguracionSerie, serieproducto.IdParteMolde,7,FechaMoldeo2,'NO',6,'A');" class="btn btn-default">Rechazar</button>-->
                        <button class="btn btn-danger" data-dismiss="modal" ng-click="saveDetalleAcero(index, idproducto, serieproducto.SerieInicio, serieproducto.IdConfiguracionSerie, serieproducto.IdParteMolde,4,FechaMoldeo2,'NO',6,'A');" class="btn btn-default">Rechazar</button>
                    </fieldset>
                </div>
            </div>
        </modal>
        <!--#################################   Moldes Cerrados  ##########################################-->
        <modal title="Captura de Cerrado Ok" visible="showModalCK">
            <div style="height:300px;">
                <div class="form-group">
                    <label for="producto">No Parte: </label> <label style="" >{{producto}}</label>
                    <input type="hidden" class="form-control" ng-model="idproducto" value="idproducto" id="Producto" />
                </div>
                <label style="text-align:center;" >Serie: {{serieproducto.SerieInicio}}</label> <br>
                    <div class="input-group">
                        <span id="Series" class="input-group-addon">Series:</span>
                        <select id="series" ng-model="series.Serie" aria-describedby="Series" ng-change="activaBtnCerrado(3);" class="form-control input-sm" required>
                            <option value="{{series.Serie}}" ng-repeat="series in listadoseries">{{series.Serie}}</option>
                        </select>
                    </div>
                <br>
                <label>Comentarios:</label><textarea cols="15" rows="5" class="form-control" ng-model-options="{updateOn: 'blur'}" ng-model="Descripcion" value="{{Descripcion}}"></textarea><br>
                <fieldset id="btn-cerrado" disabled="true">
                <!--<button class="btn btn-success" data-dismiss="modal" ng-click="saveDetalleAcero(index, idproducto, serieproducto.SerieInicio, serieproducto.IdConfiguracionSerie, serieproducto.IdParteMolde,5,FechaMoldeo,'',9 ,series.Serie, Descripcion);" class="btn btn-default">Agreagar</button>-->
                    <button class="btn btn-success" data-dismiss="modal" ng-click="saveDetalleAcero(index, idproducto, serieproducto.SerieInicio, serieproducto.IdConfiguracionSerie, serieproducto.IdParteMolde,1,FechaMoldeo,Reposicion,9 ,series.Serie, Descripcion);" class="btn btn-default">Agreagar</button>
                </fieldset>
            </div>
        </modal> 
    </div>
</div>