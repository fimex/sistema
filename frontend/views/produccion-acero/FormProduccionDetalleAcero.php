<div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading">Captura de produccion</div>
    <div id="detalle" class="scrollable">
        <table ng-table class="table table-condensed table-striped table-bordered">
                <tr>
                    <th class="width-40" colspan="2" ></th>
                    <th class="width-20 text-center" colspan="2"  >Faltan</th>
                    <th rowspan="{{programacionAceros.length + 2}}"></th>
                    <th colspan="5" class="text-center" >Datos</th>
                    <th rowspan="{{programacionAceros.length + 2}}"></th>
                    <th colspan="4" class="text-center"  >Ciclos</th>
                    <th rowspan="{{programacionAceros.length + 2}}"></th>
                    <th colspan="2" class="text-center"  >Moldes</th>
                    <th rowspan="{{programacionAceros.length + 2}}"></th>
                    <th colspan="4" class="text-center"  >Cerrados</th>
                    <th rowspan="{{programacionAceros.length + 2}}"></th>
                    <th colspan="2" class="text-center"  >Vaciados</th>
                </tr>
                <tr>
                    <th>Pr</th>
                    <th class="width-40">Prg</th>
                    <th class="width-20">Llenada</th>
                    <th class="width-20">Cerrada</th>
                    <th class="width-50">No Parte</th>
                    <th>Aleacion</th>
                    <th>Serie</th>
                    <th>Cic</th>
                    <th class="width-80">Cic Req</th>
                    <th colspan="2" class="width-30">OK</th>
                    <th colspan="2" class="width-30">Rech</th>
                    <!-- Ciclos llenados -->
                    <th class="width-40">Llenados</th>
                    <th class="width-40">Cerrados</th>
                    <th colspan="2" class="width-40">Ok</th>
                    <th colspan="2" class="width-30">Rech</th>
                    <th class="width-40">Ok</th>
                    <th class="width-30">Rech</th>
                </tr>
                <tr ng-class="{'info': indexDetalle == $index}" ng-repeat="detalle in programacionAceros">
                    <th>{{detalle.Prioridad}}</th>
                    <th>{{detalle.Programadas}}</th>
                    <th>{{detalle.Programadas - ((( IdAreaAct != 2 ? detalle.OKMoldeo * 1 : detalle.OKVarel * 1) + (IdAreaAct != 2 ? detalle.REPMoldeo : detalle.REPVarel - detalle.RECCerrado))/detalle.CiclosMolde)}}</th>
                    <th>{{detalle.Programadas - detalle.OKCerrado - detalle.RECCerrado}}</th>
                    <td class="col-md-3">{{detalle.Producto}}</td>

                    <th>{{detalle.Aleacion}}</th>
                    <th>{{detalle.SerieInicio || 'N/A'}}</th>
                    <th>{{detalle.CiclosMolde}}</th>
                    <th>{{ IdAreaAct != 2 ? (detalle.CiclosMolde * detalle.Programadas) - detalle.OKMoldeo + (detalle.REPMoldeo - detalle.RECCerrado) : (detalle.CiclosMolde * detalle.Programadas) - detalle.OKVarel + (detalle.REPVarel - detalle.RECCerrado) }}</th>
                    
                    <th>{{ IdAreaAct != 2 ? detalle.OKMoldeo : detalle.OKVarel}}</th>
                    <th><button type="button" ng-show="IdSubProceso == 6 || IdSubProceso == 7" ng-click="ModelMoldeo($index,1);" class="btn btn-info btn-sm ">+</button></th>
                    <th>{{ IdAreaAct != 2 ? detalle.RECMoldeo : detalle.RECVarel || 0 }}</th>
                    <th><button type="button" ng-show="IdSubProceso == 6 || IdSubProceso == 7" ng-click="ModelMoldeo($index,3);" class="btn btn-danger btn-sm ">-</button></th>
                    
                    <th>{{ IdAreaAct != 2 ? (((detalle.OKMoldeo * 1) + (detalle.REPMoldeo - detalle.RECCerrado))/detalle.CiclosMolde) : (((detalle.OKVarel * 1) + (detalle.REPVarel - detalle.RECCerrado))/detalle.CiclosMolde) }}</th>
                    <th>{{detalle.OKCerrado || 0}}</th>

                    <th>{{detalle.OKCerrado || 0 }}</th>
                    <th><button type="button" ng-show="IdSubProceso == 9" ng-click="ModelMoldeo($index,1);" class="btn btn-info btn-sm ">+</button></th>
                    <th>{{detalle.RECCerrado || 0 }}</th>
                    <th><button type="button" ng-show="IdSubProceso == 9" ng-click="ModelMoldeo($index,3);" class="btn btn-danger btn-sm ">-</button></th>
                    
                    <th>{{detalle.VaciadoOK || 0 }}</th>
                    <th>{{detalle.VaciadoREC || 0 }}</th>
                </tr>
        </table>

        <!--#####################################################
        ########################   Modal ########################
        #########################################################-->

        <!--########################### Ciclos Ok Varel ########################-->
        <modal title="" visible="showModal">
            <h3>{{title}}</h3>
            <div style="height:300px;" >
                <div class="form-group">
                    <label for="producto">No Parte: </label> <label style="color:green;" >{{programacionAceros[index].Producto}}</label>
                    <input type="hidden" class="form-control" ng-model="idproducto" value="idproducto" id="Producto" />
                </div>

                <div style="float:left; width:30%;">
                    <label>Parte del Molde</label><br>
                    <div ng-repeat="parte in partes">
                        <label ng-if="IdAreaAct != '2' || parte.Identificador != 'Cabeza'">
                            <input type="radio" ng-model="IdParteMolde" ng-click="selectParte(parte.IdParteMolde);" name="Parte" ng-value="parte.IdParteMolde" > {{parte.Identificador}}
                        </label><br/>
                    </div>
                </div>

                <div style="float:left; width:60%;" >
                    <label style="text-align:center;" ng-show="programacionAceros[index].SerieInicio" >
                        Serie: 
                        <label ng-show="((IdSubProceso == 6 || IdSubProceso == 7)) && programacionAceros[index].IdParteMolde == IdParteMolde"style="color:green; font-size:15pt;">{{programacionAceros[index].SerieInicio}}</label>
                        <select ng-show="((IdSubProceso != 6 || IdSubProceso != 7)) && programacionAceros[index].IdParteMolde == IdParteMolde" ng-model="indexSerie" ng-change="selectSerie(indexSerie)">
                            <option ng-repeat="serie in listadoSeries" ng-value="$index">{{serie.Serie}}</option>
                        </select>
                    </label>
                    <div class="checkbox">
                        <label>
                            <input id="Reposicion" name="Reposicion" ng-model="Reposicion" ng-change="selectReposicion(Reposicion);" type="checkbox" ng-true-value="'SI'" ng-false-value="'NO'"> Reposici&oacute;n
                        </label>
                    </div>
                    <fieldset id="btn-ciclo">
                        <button class="btn btn-success" data-dismiss="modal" ng-click="saveDetalleAcero();" class="btn btn-default">Agreagar</button>
                    </fieldset>
                </div>
            </div>
        </modal>
        <!--########################### Ciclos Rechazos Varel y Especial ########################-->
        <modal title="Ciclos Rechazados" visible="showModalR">
            <div style="height:400px; " >
                <div class="form-group">
                    <label for="producto">No Parte: </label> <label style="" >{{producto}}  <?php echo $IdSubProceso; ?></label>
                    <input type="hidden" class="form-control" ng-model="idproducto" value="idproducto" id="Producto" />
                </div>

                <div style="float:left; width:30%;">
                    <label>Parte del Molde</label><br>
                    <div ng-repeat="parte in partes">
                        <label ng-if="IdAreaAct != '2' || parte.Identificador != 'Cabeza'">
                            <input type="radio" ng-model="parte.IdParteMolde" ng-change="getSerie({{parte.IdParteMolde}},idproducto,0,<?php echo $IdSubProceso; ?>); " name="ParteM" value="parte.IdParteMolde" > {{parte.Identificador}}
                        </label><br/>
                    </div>
                </div>

                <div style="float:left; width:60%;" >
                    <!--<label style="text-align:center;" >Serie: {{serieproducto.SerieInicio}}</label> <br>-->
                    <fieldset id="showseries" disabled="true">
                        <div class="input-group">
                            <span id="Series" class="input-group-addon">Series:</span>
                            <select ng-show="mostrar" id="series" aria-describedby="Series" ng-change="activaBtnCerrado(2);" ng-model="series.Serie" class="form-control input-sm" required>
                                <option value="{{series.Serie}}" ng-repeat="series in listadoseries">{{series.Serie}}</option>
                            </select>
                        </div>
                    </fieldset>
                    <br>
                    <div id="ContAreaV" class="tab-content">
                        <div class="tab-pane fade active in" id="Step1">
                            <fieldset>
                                <legend style="font-size:14px">Area Rechazo</legend>
                                <div class="form-group">
                                    <?php if($IdAreaAct == 1):?><label><input type="radio" ng-model="area" name="area" value="6" ></label> Moldeo<br/><?php endif; ?>
                                    <label><input type="radio" ng-model="area" name="area" value="8" ></label> Pintado<br/>
                                    <label><input type="radio" ng-model="area" name="area" value="9" ></label> Cerrado
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <label>Comentarios:</label><textarea cols="15" rows="5" class="form-control" ng-model-options="{updateOn: 'blur'}" ng-model="Descripcion" value="{{Descripcion}}"></textarea><br>
                    <!--<button class="btn btn-success" data-dismiss="modal" ng-click="saveDetalleAcero(index, idproducto, serieproducto.SerieInicio, serieproducto.IdConfiguracionSerie, serieproducto.IdParteMolde,'R',FechaMoldeo,'',6,series.Serie,Descripcion);" class="btn btn-default">Agreagar</button>-->
                    <fieldset id="btn-rechazoV" disabled="true">
                        <!--<button class="btn btn-danger" id="" data-dismiss="modal" ng-click="saveDetalleAcero(index, idproducto, serieproducto.SerieInicio, serieproducto.IdConfiguracionSerie, serieproducto.IdParteMolde,area,FechaMoldeo2,'NO',6,series.Serie,Descripcion);" class="btn btn-default">Rechazar</button>-->
                        <button class="btn btn-danger" id="" data-dismiss="modal" ng-click="saveDetalleAcero(index, idproducto, serieproducto.SerieInicio, serieproducto.IdConfiguracionSerie, serieproducto.IdParteMolde,3,FechaMoldeo,'NO',area,series.Serie,Descripcion);" class="btn btn-default">Rechazar</button>
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