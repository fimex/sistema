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
                <th colspan="7" class="text-center">Ciclos</th>
                <th rowspan="{{programacionAceros.length + 2}}"></th>
                <th colspan="2" class="text-center"  >Moldes</th>
                <th rowspan="{{programacionAceros.length + 2}}"></th>
                <th rowspan="{{programacionAceros.length + 2}}"></th>
                <th colspan="2" class="text-center"  >Cerrados</th>
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
                <th colspan="1" class="width-30">Total</th>
                <th colspan="2" class="width-30">Ok</th>
                <th colspan="2" class="width-30">Rech</th>
                <th colspan="2">Reposicion</th>
                <th class="width-40">OK</th>
                <th class="width-40">RECH</th>
                <th class="width-40">Ok</th>
                <th class="width-30">Rech</th>
                <th class="width-40">Ok</th>
                <th class="width-30">Rech</th>
            </tr> 
            <tr ng-class="{'info': indexDetalle == $index}" ng-repeat="detalle in programacionAceros">
                <th>{{detalle.Prioridad}}</th>
                <th>{{detalle.Programadas}}</th>
                <th><span>{{detalle.FaltanLlenadasV | currency:"":1}} </span></th>
                <th><span>{{detalle.FaltaNCerradasV | currency:"":1}}</span></th>
                <td class="col-md-3">{{detalle.Producto}}</td>
                <th>{{detalle.Aleacion}}</th>
                <th ng-class="{'danger':!detalle.SerieInicio && detalle.LlevaSerie}">
                    {{detalle.SerieInicio || '--'}}
                </th>
                <th>{{detalle.CiclosMolde}}</th>
                <th>{{detalle.CiclosRequeridosMoldeo}}</th>
                <th>{{detalle.CiclosTotal}}</th>
                <th colspan="4" ng-show="!detalle.SerieInicio && detalle.LlevaSerie">Configurar serie para poder capturar</th>
                <th ng-show="!(!detalle.SerieInicio && detalle.LlevaSerie)">
                    <button type="button" ng-click="saveDetalleAcero($index,1);" class="btn btn-success btn-sm">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </button>
                </th>
                <th ng-show="!(!detalle.SerieInicio && detalle.LlevaSerie)">{{detalle.OkCiclosMoldeo}}</th>
                <th ng-show="!(!detalle.SerieInicio && detalle.LlevaSerie)">
                    <button type="button" ng-click="activaBtnCerrado(17);ModelMoldeo($index,3);" class="btn btn-danger btn-sm">
                        <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                    </button>
                </th>
                <th ng-show="!(!detalle.SerieInicio && detalle.LlevaSerie)">{{detalle.RecCiclosMoldeo}}</th>
                <th>
                    <button type="button" ng-click="activaBtnCerrado(15);ModelMoldeo($index,10);" class="btn btn-info btn-sm">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </button>
                </th>
                <th>{{detalle.RepCiclosMoldeo}}</th>
                <th>{{detalle.OkMoldesMoldeo | currency:"":2}}</th>
                <th>{{detalle.RecMoldesMoldeo | currency:"":2 }}</th>
                     
                <th>{{detalle.OkMoldesCerrados | currency:"":2 || 0}}</th>
                <th>{{detalle.RecMoldesCerrado | currency:"":2 || 0}}</th>

                <th>{{detalle.OkMoldesVaciados || 0}}</th>
                <th>{{detalle.RecMoldesVaciados || 0}}</th>
            </tr>
        </table>

        <!--########################### CICLOS REPOSICION VAREL ########################-->
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
                        <label ng-if="parte.Identificador != 'Cabeza'">
                            <label ng-if="parte.Num <= programacionAceros[index].CiclosMolde">
                                <input 
                                type="radio" 
                                name="Parte" 
                                ng-model="IdParteMolde" 
                                ng-click="activaBtnCerrado(1);selectParte(parte.IdParteMolde);" 
                                ng-value="parte.IdParteMolde" 
                                id="{{parte.Identificador}}"> 
                                {{parte.Identificador}} 
                            </label>
                        </label><br/>
                    </div>
                </div>

                <div style="float:left; width:60%;" >
                    <label style="text-align:center;" ng-show="programacionAceros[index].SerieInicio && showserie" >
                        Serie: 
                        <label ng-show="programacionAceros[index].IdParteMolde == IdParteMolde"style="color:green; font-size:15pt;">{{programacionAceros[index].SerieInicio}}</label>
                    </label>

                    <fieldset id="btn-ciclo" disabled="true">
                        <button class="btn btn-success" data-dismiss="modal" ng-click="saveDetalleAcero(index,10);" class="btn btn-default">Agregar</button>
                    </fieldset>
                </div>
            </div>
        </modal>
        <!--########################### CICLOS RECHAZADOS VAREL FUNCIONAL ########################-->
        <modal title="Ciclos Rechazados" visible="showModalCRV">
            <div style="height: 500px;">
                <div class="form-group">
                    <label for="producto">No Parte: </label> <label style="" >{{programacionAceros[index].Producto}}</label>
                    <input type="hidden" class="form-control" ng-model="idproducto" value="{{programacionAceros[index].IdProducto}}" id="Producto" />
                </div>

                <div style="float:left; width:30%;">
                    <label>Parte del Molde</label><br>
                    <div ng-repeat="parte in partes">
                        <label ng-if="parte.Num <= programacionAceros[index].CiclosMolde">
                            <input 
                                type="radio" 
                                ng-model="parte.IdPartesMoldes" 
                                ng-click="activaBtnCerrado(6);getSerie(parte.IdParteMolde,programacionAceros[index].IdConfiguracionSerie,1);" 
                                name="ParteR" 
                                ng-value="parte.IdParteMolde"
                            > {{parte.Identificador}} 
                        </label><br/>
                    </div>
                </div>

                <div style="float:left; width:60%;" >
                    <div ng-show="programacionAceros[index].LlevaSerie == 'Si' && showserie" class="input-group">
                        <span id="Series" class="input-group-addon">Series:</span>
                        <select id="seriesR" ng-model="series.Serie" aria-describedby="Series" ng-change="selectSerie($indexSerie);"  class="form-control input-sm" required >
                            <option value="{{series.Serie}}"  ng-repeat="series in listadoseries">{{series.Serie}}</option>
                        </select>
                    </div><br>
                    <div class="input-group">
                        <span class="input-group-addon">Comentarios:</span>
                       <textarea cols="15" rows="5" class="form-control" ng-model-options="{updateOn: 'blur'}" ng-model="programacionAceros[index].Descripcion" value="{{Descripcion}}"></textarea>
                    </div><br>
                    <fieldset id="btn-cicloV" disabled="true">
                        <button class="btn btn-danger" id="" data-dismiss="modal" ng-click="saveDetalleAcero(index, 3);" class="btn btn-default">Rechazar</button>
                    </fieldset>
                </div>
            </div>
        </modal> 
    </div>
</div>

