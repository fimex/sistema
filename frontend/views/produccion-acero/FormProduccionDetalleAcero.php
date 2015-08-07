<div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading">Captura de produccion</div>
    <div id="detalle" class="scrollable">
        <table ng-table class="table table-condensed table-striped table-bordered">
            <thead>
                <tr>
                    <th class="width-40" colspan="2" ></th>
                    <th class="width-20 text-center" colspan="2"  >Faltan</th>

                    <th rowspan="2" ></th>
                    
                    <th colspan="4" class="text-center" >Datos</th>
                    <th colspan="4" class="text-center"  >Ciclos</th>
                    <th colspan="3" class="text-center"  >Moldes</th>
                </tr>
                <tr>
                    <th>Pr</th>
                    <th class="width-40">Prg</th>

                    <th class="width-20">Llenada</th>
                    <th class="width-20">Cerrada</th>
                     
                    <th class="width-50">No Parte</th>
                    <th>Aleacion</th>
                    <th>Cic</th>
                    <th class="width-80">Cic Req</th>

                    <th class="width-30">OK</th>
                    <th></th>
                    <th class="width-30">Rech</th>
                    <th></th>

                    <!-- Ciclos llenados -->
                    <th class="width-40">Llenados</th>
                    
                    <th class="width-40">Cerrados</th>
                    <?php if($IdAreaAct != 1):?><th></th><?php endif;?>
                    
                </tr>
            </thead>
            <tbody>
                <tr ng-class="{'info': indexDetalle == $index}"  ng-repeat="detalle in detalles">
                    <th>{{detalle.Prioridad}}</th>
                    <th>{{detalle.Programadas}}</th>

                    <th>{{detalle.FaltaLlenadas <= 0 ? 0 : detalle.FaltaLlenadas}}</th>
                    <!--<th>{{detalle.Programdas - detalle.Cerradas}}</th>-->
                    <th>{{detalle.FaltaCerradas}}</th>

                    <th rowspan="1" ></th>
                    <td class="col-md-3">{{detalle.Producto}}</td>

                    <th>{{detalle.Aleacion}}</th>
                    <th>{{detalle.CiclosMolde}}</th>
                    <th>{{detalle.CicRequeridos}}</th>
                    <!--<th>{{1*detalle.ProgramadasCic + ((1*detalle.RechazadasM + 1*detalle.RechazadasR)-detalle.CiclosOk)}}</th>-->

                    <!-- Ciclos -->
                    <th>{{detalle.CiclosOk}}</th>
                    <th class="buttonWidth"> <button type="button" ng-click="ModelMoldeo(detalle.Producto, detalle.IdProducto,$index,1);" class="btn btn-info btn-sm ">+</button></th>
                    <th>{{1*detalle.RechazadasP + 1*detalle.RechazadasC}}</th>
                    <th class="buttonWidth"><button type="button" ng-click="MostrarSeries(detalle.IdProducto); ModelMoldeo(detalle.Producto, detalle.IdProducto,$index,2);" class="btn btn-danger btn-sm ">-</button></th>

                    <!-- Ciclos llenados -->
                    <th>{{ 1*detalle.MoldesOK | number:1}}</th>
                    
                    <!-- Moldes Cerrados -->               
                    <th>{{detalle.CiclosOkC}}</th>
                    <?php if($IdAreaAct != 1):?><th class="buttonWidth"><button type="button" ng-click="CerradosOk(detalle.Producto, detalle.IdProducto,$index,3);" class="btn btn-info btn-sm ">+</button></th><?php endif;?>
                                    
                </tr>
            </tbody>
        </table>

        <!--#####################################################
        ########################   Modal ########################
        #########################################################-->

        <!--###########################Ciclos Ok########################-->
        <modal title="Captura de Ciclos" visible="showModal">
            <div style="height:300px;" >
                <div class="form-group">
                    <label for="producto">No Parte: </label> <label style="color:green;" >{{producto}}</label>
                    <input type="hidden" class="form-control" ng-model="idproducto" value="idproducto" id="Producto" />
                </div>

                <div style="float:left; width:30%;">
                    <label>Parte del Molde</label><br>
                    <div ng-repeat="parte in partes">
                        <label ng-if="IdAreaAct != '2' || parte.Identificador != 'Cabeza'">
                            <input type="radio" ng-model="parte.IdParteMolde" ng-change="getSerie({{parte.IdParteMolde}},idproducto,1); activaBtnCerrado(1);" name="Parte" value="parte.IdParteMolde" > {{parte.Identificador}}
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
                    <fieldset id="btn-ciclo" disabled="true">
                        <button class="btn btn-success" data-dismiss="modal" ng-click="saveDetalleAcero(index, idproducto, serieproducto.SerieInicio, serieproducto.IdConfiguracionSerie, serieproducto.IdParteMolde,1,FechaMoldeo2,Reposicion,6,'A');" class="btn btn-default">Agreagar</button>
                    </fieldset>
                </div>
            </div>
        </modal>
        <!--########################### Ciclos Rechazos ########################-->
        <modal title="Captura de Ciclos Rechazados" visible="showModalR">
            <div style="height:390px; " >
                <div class="form-group">
                    <label for="producto">No Parte: </label> <label style="" >{{producto}}</label>
                    <input type="hidden" class="form-control" ng-model="idproducto" value="idproducto" id="Producto" />
                </div>

                <div style="float:left; width:30%;">
                    <label>Parte del Molde</label><br>
                    <div ng-repeat="parte in partes">
                        <label ng-if="IdAreaAct != '2' || parte.Identificador != 'Cabeza'">
                            <input type="radio" ng-model="parte.IdParteMolde" ng-change="getSerie({{parte.IdParteMolde}},idproducto,0); " name="ParteM" value="parte.IdParteMolde" > {{parte.Identificador}}
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
                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane fade active in" id="Step1">
                            <fieldset>
                                <legend style="font-size:14px">Area Rechazo</legend>
                                <div class="form-group">
                                     <label>
                                        <input type="radio" ng-model="area" name="area" value="3" >
                                    </label> Pintado<br/>
                                    <label>
                                        <input type="radio" ng-model="area" name="area" value="4" >
                                    </label> Cerrado
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <label>Comentarios:</label><textarea cols="15" rows="5" class="form-control" ng-model-options="{updateOn: 'blur'}" ng-model="Descripcion" value="{{Descripcion}}"></textarea><br>
                    <!--<button class="btn btn-success" data-dismiss="modal" ng-click="saveDetalleAcero(index, idproducto, serieproducto.SerieInicio, serieproducto.IdConfiguracionSerie, serieproducto.IdParteMolde,'R',FechaMoldeo,'',6,series.Serie,Descripcion);" class="btn btn-default">Agreagar</button>-->
                    <fieldset id="btn-rechazo" disabled="true">
                        <button class="btn btn-danger" id="" data-dismiss="modal" ng-click="saveDetalleAcero(index, idproducto, serieproducto.SerieInicio, serieproducto.IdConfiguracionSerie, serieproducto.IdParteMolde,area,FechaMoldeo2,'NO',6,series.Serie,Descripcion);" class="btn btn-default">Rechazar</button>
                    </fieldset>
                </div>
            </div>
        </modal> 
        <!--#################################   Moldes Rechazos  ##########################################-->
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
                    <button class="btn btn-success" data-dismiss="modal" ng-click="saveDetalleAcero(index, idproducto, serieproducto.SerieInicio, serieproducto.IdConfiguracionSerie, serieproducto.IdParteMolde,5,FechaMoldeo,'',9 ,series.Serie, Descripcion);" class="btn btn-default">Agreagar</button>
                </fieldset>
            </div>
        </modal> 
    </div>
</div>