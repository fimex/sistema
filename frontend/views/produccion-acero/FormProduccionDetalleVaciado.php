<div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading">Captura de produccion</div>
    <div id="detalle" class="scrollable">
        <table ng-table class="table table-condensed table-striped table-bordered">
            <thead>
                <tr>
                    <th class="width-0" colspan="2" ></th>
                    <th class="width-20 text-center" colspan="3"></th>
                    <th rowspan="2" ></th>
                    <th colspan="2" class="text-center">Datos</th>
                    <th colspan="4" class="text-center">Moldes</th>
                    <th colspan="4" class="text-center">Piezas</th>
                </tr>
                <tr>
                    <th class="width-20">Pr</th>
                    <th class="width-20">Prg</th>
                    <th class="width-20">Mold</th>
                    <th class="width-20">Cerr</th>
                    <th class="width-20">Vac</th>
                    <!--<th class="width-20">Falt</th>-->
                     
                    <th class="width-60">No Parte</th>
                    <th class="width-50">Aleacion</th>

                    <!--<th></th>-->
                    <th class="width-50">OK</th>
                    <th></th>

                    <!--<th></th>-->
                    <th class="width-50">Rech</th>
                    <th></th>

                    <th class="width-30">OK</th>
                    <th class="width-30">Rech</th>
                </tr>
            </thead>
            <tbody>
                <tr ng-class="{'info': indexDetalle == $index}"  ng-repeat="detalle in detalles">
                    <th>{{detalle.Prioridad}}</th>
                    <th>{{detalle.Programadas}}</th>

                    <th>{{1*detalle.Llenadas}}</th>
                    <th>{{detalle.Cerradas}}</th>
                    <th>{{detalle.CantVaciadas}}</th>
                    <!--<th>{{1*detalle.Llenadas - 1*detalle.CantVaciadas}}</th>-->

                    <th rowspan="1" ></th>
                    <td class="col-md-3">{{detalle.Producto}}</td>
                    <th>{{detalle.Aleacion}}</th>

                    <th>
                        <input ng-disabled="detalle.LlevaSerie == 'Si'" type="text" name="Vaciadas" id="Vaciadas" ng-model="detalle.Hechas" ng-value="{{detalle.Hechas}}" >
                    </th>  
                    <th>
                        <button class="btn btn-primary" ng-show="detalle.LlevaSerie == 'Si'" ng-click="MostrarSeries(detalle.IdProducto,9); ModelMoldeo(detalle.Producto, detalle.IdProducto,$index,8,1,1);">Series</button>
                        <button class="btn btn-success btn-xs" ng-show="detalle.LlevaSerie != 'Si'" ng-click="saveDetalleVaciado($index,0,1)"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
                    </th>
                  
                    <th>
                        <input ng-disabled="detalle.LlevaSerie == 'Si'" type="text" name="RechazosV" id="RechazosV" ng-model="detalle.Rechazadas" ng-value="{{detalle.Rechazadas}}" >
                    </th>
                    <th>
                        <button class="btn btn-primary" ng-show="detalle.LlevaSerie == 'Si'" ng-click="MostrarSeries(detalle.IdProducto,9); ModelMoldeo(detalle.Producto, detalle.IdProducto,$index,8,0,0);">Series</button>
                        <button class="btn btn-success btn-xs" ng-show="detalle.LlevaSerie != 'Si'" ng-click="saveDetalleVaciado($index,0,0)"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
                    </th>  

                    <th>{{ 1*detalle.Hechas * detalle.PiezasMolde}}</th>
                    <th>{{detalle.Rechazadas}}</th>
                </tr>
            </tbody>
        </table>
    
    </div>
</div>
<!--#####################################################
######################## Modal ##########################
#########################################################-->


<!--########################### Series ########################-->
<modal title="Series Disponibles" visible="showModalSeries">
    <div style="height:320px; width:330px;" >
        <div class="form-group">
            <label for="producto">No Parte: </label> <label style="color:green;" >{{producto}}</label>
            <input type="hidden" class="form-control" ng-model="idproducto" value="idproducto" id="Producto" />
        </div>
        <div style="float:left; width:30%;">
            <label>Series</label><br>
            <div ng-repeat="series in listadoseries">            
                <input type="checkbox" name="Series[]" ng-model="IdSerie" value="{{series.IdSerie}}"> {{series.Serie}} 
            </div>
        </div>
        <br>
        <div style="float:left; width:60%;" >
            <div style="float:right" >
                <fieldset id="btn-ciclo" ng-if=" listadoseries != '' " >
                    <button class="btn btn-success" data-dismiss="modal" class="btn btn-default" ng-click="saveDetalleVaciado(index,Vaciar,operacion)">Aceptar</button>
                </fieldset>
            </div>
        </div>
    </div>
</modal>


