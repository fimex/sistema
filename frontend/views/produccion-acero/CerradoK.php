 <div class="panel panel-primary">
        <div class="panel-heading">Cerrado Kloster</div>
        <div class="panel-body">
            <!--<button class="btn btn-success" ng-show="mostrar" ng-click="addDetalleAcero()">Agregar Produccion</button>-->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="width-40" colspan="2" ></th>
                            <th class="width-20 text-center" colspan="2"  >Faltan</th>

                            <th rowspan="2" ></th>
                            
                            <th colspan="4" class="text-center"  >Cerrados</th>
                        </tr>
                        <tr>
                            <th>Pr</th>
                            <th class="width-40">Prg</th>
                            <th class="width-20">Llenada</th>
                            <th class="width-20">Cerrada</th>
                            <th class="width-50">No Parte</th>
                            <th class="width-40">OK</th>
                            <th></th>  
                            <th class="width-30">Rech</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-class="{'info': indexDetalle == $index}"  ng-repeat="detalle in detalles">
                            <th>{{detalle.Prioridad}}</th>
                            <th>{{detalle.Programadas}}</th>
                            <th>{{detalle.Llenadas}}</th>
                            <th>{{detalle.Llenadas - detalle.CiclosOkC}}</th>
                            <!--<th>{{detalle.Programadas - detalle.Llenadas}}</th>
                            <th>{{detalle.Cerradas}}</th>-->

                            <th rowspan="1" ></th>
                            <td class="col-md-3">{{detalle.Producto}}</td>
                            <th>{{detalle.CiclosOkC}}</th>
                            <th class="buttonWidth"><button type="button" ng-click="MostrarSeries(detalle.IdProducto,6);  ModelMoldeo(detalle.Producto, detalle.IdProducto,$index,3);" class="btn btn-info btn-sm ">+</button></th>
                            <th>{{detalle.RechazadasC}}</th>
                            <th class="buttonWidth"><button type="button" ng-click="ModelMoldeo(detalle.Producto, detalle.IdProducto,$index,4);" class="btn btn-danger btn-sm ">-</button></th>
                        </tr>
                    </tbody>
                </table>
            </div>
    </div>
    <!--#####################################################
    ######################## Modal ##########################
    #########################################################-->

    <!--###########################Ciclos Ok########################-->
    <modal title="Captura de Cerrados Kloster" visible="showModalCK">
        <div style="height:350px;">
            <div class="form-group">
                <label for="producto">No Parte: </label> <label style="" >{{producto}}</label>
                <input type="hidden" class="form-control" ng-model="idproducto" value="idproducto" id="Producto" />
            </div>
            <div class="form-group">
                <label><input type="radio" ng-model="linea" ng-value="1" ng-click="activaBtnCerrado(3);" ></label> Linea 1
                <label><input type="radio" ng-model="linea" ng-value="2" ng-click="activaBtnCerrado(3);" ></label> Linea 2
                <label><input type="radio" ng-model="linea" ng-value="3" ng-click="activaBtnCerrado(3);" ></label> Linea 3
            </div>
            <label style="text-align:center;" >Serie: {{serieproducto.SerieInicio}}</label> <br>
                <div class="input-group">
                    <span id="Series" class="input-group-addon">Series:</span>
                    <select id="series" ng-model="series.Serie" aria-describedby="Series" class="form-control input-sm" required>
                        <option value="{{series.Serie}}" ng-repeat="series in listadoseries">{{series.Serie}}</option>
                    </select>
                </div>
            <br>
            <label>Comentarios:</label><textarea cols="15" rows="5" class="form-control" ng-model-options="{updateOn: 'blur'}" ng-model="Descripcion" value="{{Descripcion}}"></textarea><br>
            <fieldset id="btn-cerrado" disabled="true">
                <button class="btn btn-success" data-dismiss="modal" ng-click="saveDetalleAcero(index, idproducto, serieproducto.SerieInicio, serieproducto.IdConfiguracionSerie, serieproducto.IdParteMolde,1,FechaMoldeo2,'',9 ,series.Serie, Descripcion,linea);" class="btn btn-default">Agreagar</button>
            </fieldset>
        </div>
    </modal>
    <!--########################### Ciclos Rechasados ########################-->
    <modal title="Rechazados de Cerrados Kloster" visible="showModalCRK">
        <div style="height:320px;" >
            <div class="form-group">
                <label for="producto">No Parte: </label> <label style="color:green;" >{{producto}}</label>
                <input type="hidden" class="form-control" ng-model="idproducto" value="idproducto" id="Producto" />
            </div>
            <div style="float:left; width:30%;">
                <label>Parte del Molde</label><br>
                <div ng-repeat="parte in partes">
                    <label>
                        <input type="radio" ng-model="parte.IdParteMolde" ng-change="activaBtnCerrado(4); getSerie({{parte.IdParteMolde}},idproducto,1,9);" name="ParteRK" value="parte.IdParteMolde" > {{parte.Identificador}}
                    </label><br/>
                </div>
            </div>
            <div style="float:left; width:60%;" >
                <div class="form-group">
                    <label><input type="radio" ng-model="linea" ng-value="1" ></label> Linea 1
                    <label><input type="radio" ng-model="linea" ng-value="2" ></label> Linea 2
                    <label><input type="radio" ng-model="linea" ng-value="3" ></label> Linea 3
                </div>
                <div class="input-group">
                    <span id="Series" class="input-group-addon">Series:</span>
                    <select id="series" ng-model="series.Serie" aria-describedby="Series" ng-change="activaBtnCerrado(3);" class="form-control input-sm" required>
                        <option value="{{series.Serie}}" ng-repeat="series in listadoseries">{{series.Serie}}</option>
                    </select>
                </div>
                <br>
                <label>Comentarios:</label><textarea cols="15" rows="5" class="form-control" ng-model-options="{updateOn: 'blur'}" ng-model="Descripcion" value="{{Descripcion}}"></textarea><br>
                <fieldset id="btn-rechazoK" disabled="true">
                    <button class="btn btn-danger" data-dismiss="modal" ng-click="saveDetalleAcero(index, idproducto, serieproducto.SerieInicio, serieproducto.IdConfiguracionSerie, serieproducto.IdParteMolde,3,FechaMoldeo2,'NO',9, series.Serie, Descripcion,linea);" class="btn btn-default">Rechazar</button>
                </fieldset>
            </div>
        </div>
    </modal>