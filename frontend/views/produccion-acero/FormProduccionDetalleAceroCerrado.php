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
                    <th colspan="2" class="text-center" >Datos</th>
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
                    <th class="width-20">Llenado</th>
                    <th class="width-20">Cerrado</th>
                    <th class="width-50">No Parte</th>
                    <th>Aleacion</th>
                    <th class="width-40">OK</th>
                    <th class="width-40">RECH</th>
                    <th colspan="2" >Ok</th>
                    <th colspan="2" >Rech</th>
                    <th class="width-40">Ok</th>
                    <th class="width-30">Rech</th>
                </tr> 
                <tr ng-class="{'info': indexCiclo == $index}" ng-init="resetResumen()" ng-repeat="detalle in programacionAceros" ng-mousedown="selectCiclo($index);">
                    <th>{{detalle.Prioridad}}</th>
                    <th>{{detalle.Programadas}}</th>
                    <th>
                        <span>{{detalle.FaltanLlenadasV | currency:"":1}} </span>
                    </th>
                    <th>
                        <span>{{detalle.FaltaNCerradasV | currency:"":1}}</span>
                    </th>
                    <td class="col-md-3">{{detalle.Producto}}</td>
                    <th>{{detalle.Aleacion}}</th>

                    <!--<th>
                        <span ng-if="IdAreaAct != 2" >{{detalle.OkMoldesMoldeo - detalle.RecMoldesCerrado}}</span>
                        <span ng-if="IdAreaAct == 2" >{{detalle.OkMoldesMoldeo - detalle.RecMoldesCerrado - detalle.RecMoldesMoldeo }}</span>
                    </th>
                    <th>{{detalle.RecMoldesMoldeo + detalle.RecMoldesCerrado | currency:"":1}}</th>-->

                    <th ng-init=" resumen('OkMoldesMoldeo',detalle.OkMoldesMoldeo)" >{{detalle.OkMoldesMoldeo | currency:"":2}}</th>
                    <th ng-init=" resumen('RecMoldesMoldeo',detalle.RecMoldesMoldeo)" >{{detalle.RecMoldesMoldeo | currency:"":2 }}</th>
                    <!--<th><button type="button" ng-disabled="detalle.OkMoldesMoldeoRound > detalle.OkMoldesCerrados ? false : true" ng-click="activaBtnCerrado(13);ModelMoldeo($index,1);" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button></th>-->
                    <th><button type="button" ng-click="activaBtnCerrado(13);ModelMoldeo($index,1);" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button></th>
                    <th ng-init=" resumen('OkMoldesCerrados',detalle.OkMoldesCerrados)" >{{detalle.OkMoldesCerrados | currency:"":1}}</th>
                    <th>
                        <button type="button" ng-click="activaBtnCerrado(14);ModelMoldeo($index,3);" class="btn btn-danger btn-sm">
                            <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                        </button>
                    </th>
                    <th ng-init=" resumen('RecMoldesCerrado',detalle.RecMoldesCerrado)">{{detalle.RecMoldesCerrado | currency:"":1}}</th>

                    <th ng-init=" resumen('OkMoldesVaciados',detalle.OkMoldesVaciados)">{{detalle.OkMoldesVaciados || 0}}</th>
                    <th ng-init=" resumen('RecMoldesVaciados',detalle.RecMoldesVaciados)">{{detalle.RecMoldesVaciados || 0}}</th>
                </tr>
				<tr>
					<td colspan="8"></td>
					<td >{{OkMoldesMoldeo}}</td>
					<td >{{RecMoldesMoldeo}}</td>
					<td></td>
					<td colspan="2">{{OkMoldesCerrados}}</td>
					<td colspan="2">{{RecMoldesCerrado}}</td>
					<td></td>
					<td>{{OkMoldesVaciados}}</td>
					<td colspan="2">{{RecMoldesVaciados}}</td>
					

				</tr>
        </table>

        <!--#####################################################
        ########################   Modal ########################
        #########################################################-->


        <!--########################### Cerrado Ok ########################-->
        <modal title="" visible="showModalCerrado">
            <h3>Captura de Cerrado OK</h3> 
            <div style="height: 500px;">
                <div class="form-group">
                    <label for="producto">No Parte: </label> <label style="color:green;" >{{programacionAceros[index].Producto}}</label>
                    <input type="hidden" class="form-control" ng-model="idproducto" value="idproducto" id="Producto" />
                </div>
                <div style="float:left; width:70%;">
                    <div class="input-group col-md-5">
                        <span id="Empleados" class="input-group-addon">Empleado:</span>
                        <select aria-describedby="Empleados" class="form-control input-sm" ng-change="activaBtnCerrado(12); selectEmpleado(IdEmpleado);" ng-model="IdEmpleado" required>
                            <option ng-selected="produccion.IdEmpleado == e.IdEmpleado" ng-repeat="e in empleados" ng-value="{{e.IdEmpleado}}">{{e.NombreCompleto}}</option>
                        </select>
                    </div><br>
                    <div class="form-group">
                        <label><input type="radio" id="LineaOK1" ng-model="programacionAceros[index].Linea" ng-change="activaBtnCerrado(11);" ng-value="1" ></label> Linea 1
                        <label><input type="radio" id="LineaOK2" ng-model="programacionAceros[index].Linea" ng-change="activaBtnCerrado(11);" ng-value="2" ></label> Linea 2
                        <label><input type="radio" id="LineaOK3" ng-model="programacionAceros[index].Linea" ng-change="activaBtnCerrado(11);" ng-value="3" ></label> Linea 3
                    </div>
                    <div ng-show="programacionAceros[index].LlevaSerie == 'Si' && showserie" class="input-group col-md-5">
                        <span id="Series" class="input-group-addon">Series:</span>
                        <select id="series" ng-model="series.Serie" aria-describedby="Series" ng-change="activaBtnCerrado(10);" class="form-control input-sm" required>
                            <option value="{{series.Serie}}" ng-repeat="series in listadoseries">{{series.Serie}}</option>
                        </select>
                    </div><br>
               
                    <div class="input-group">
                        <span id="Series" class="input-group-addon">Comentarios:</span>
                       <textarea id="ComentariosOK" cols="15" rows="5" class="form-control" ng-model-options="{updateOn: 'blur'}" ng-model="programacionAceros[index].Descripcion" value="{{Descripcion}}"></textarea>
                    </div><br>
                    <div style="float:right; width:20%;" >
                        <fieldset id="btn-cerradoOK" disabled="true">
                            <button 
                                class="btn btn-success" 
                                data-dismiss="modal" 
                                ng-click="saveDetalleAcero(index,estatus);" 
                                class="btn btn-default">
                                Agregar
                            </button>
                        </fieldset>
                    </div>
                </div>
            </div>
        </modal>

        <!--########################### Cerrado Rechazo ########################-->
        <modal title="" visible="showModalCerradoR">
            <h3>Captura de Cerrado</h3> 
            <div style="height: 500px;">
                <div class="form-group">
                    <label for="producto">No Parte: </label> <label style="color:red;" >{{programacionAceros[index].Producto}}</label>
                    <input type="hidden" class="form-control" ng-model="idproducto" value="idproducto" id="Producto" />
                </div>
                <div class="input-group col-md-4">
                    <span id="Empleados" class="input-group-addon">Empleado:</span>
                    <select aria-describedby="Empleados" class="form-control input-sm" ng-change="selectEmpleado(IdEmpleado);" name="IdEmpleadoR" ng-model="IdEmpleado" required>
                        <option ng-selected="produccion.IdEmpleado == e.IdEmpleado" ng-repeat="e in empleados" ng-value="{{e.IdEmpleado}}">{{e.NombreCompleto}}</option>
                    </select>
                </div><br>
                <div class="form-group">
                    <label><input type="radio" id="Linea1"  ng-model="programacionAceros[index].Linea" ng-change="activaBtnCerrado(9);" ng-value="1" ></label> Linea 1
                    <label><input type="radio" id="Linea2"  ng-model="programacionAceros[index].Linea" ng-change="activaBtnCerrado(9);" ng-value="2" ></label> Linea 2
                    <label><input type="radio" id="Linea3"  ng-model="programacionAceros[index].Linea" ng-change="activaBtnCerrado(9);" ng-value="3" ></label> Linea 3
                </div>
                <!--<div ng-show="estatus == 3 && showpartes" style="float:left; width:30%;">-->
                <div style="float:left; width:30%;">
                    <label>Seleccione un componente</label><br>
                    <!--<div ng-repeat="parte in partes">
                        <label ng-if="parte.Num <= programacionAceros[index].CiclosMolde">
                            <input type="radio" ng-model="programacionAceros[index].IdPartesMoldes" name="ParteR" ng-value="programacionAceros[index].IdParteMolde"> {{parte.Identificador}} 
                        </label><br/>
                    </div>-->
                
                    <div ng-repeat="parte in partes" ng-show="IdAreaAct == 2">
                        <label ng-if="parte.Num <= programacionAceros[index].CiclosMolde">
                            <input type="radio" id="radioRechazo" ng-model="programacionAceros[index].IdParteMolde" ng-value="parte.IdParteMolde" ng-change="getSerie({{parte.IdParteMolde}},{{programacionAceros[index].IdConfiguracionSerie == null ? 1 : programacionAceros[index].IdConfiguracionSerie}},0,<?= $IdSubProceso; ?>); "> {{parte.Identificador}}
                        </label><br/>
                    </div>
                    <div ng-repeat="parte in partes" ng-show="IdAreaAct != 2">
                        <label>
                            <input 
                                    type="radio" 
                                    ng-model="programacionAceros[index].IdParteMolde" 
                                    ng-value="parte.IdParteMolde" 
                                    disabled="true"
                                    id="radioRechazo" 
                                    ng-change="getSerie({{parte.IdParteMolde}},{{ programacionAceros[index].IdConfiguracionSerie == null ? 1 : programacionAceros[index].IdConfiguracionSerie }},0,<?= $IdSubProceso; ?>);"> {{parte.Identificador}}
                        </label><br/>
                    </div>
                </div><br>
                <div style="float:right; width:70%;">
                    <div ng-show="programacionAceros[index].LlevaSerie == 'Si' && showserie" class="input-group">
                        <span id="Series" class="input-group-addon">Series:</span>
                        <select id="seriesR" ng-model="series.Serie" aria-describedby="Series" ng-change="activaBtnCerrado(8);" class="form-control input-sm" required>
                            <option value="{{series.Serie}}" ng-repeat="series in listadoseries">{{series.Serie}}</option>
                        </select>
                    </div><br>
                    <div class="input-group">
                        <span  id="Series" class="input-group-addon">Comentarios:</span>
                       <textarea id="ComentariosC" cols="15" rows="5" class="form-control" ng-model-options="{updateOn: 'blur'}" ng-model="programacionAceros[index].Descripcion" value="{{Descripcion}}"></textarea>
                    </div><br>
                    <div style="float:right; width:20%;" >
                        <fieldset id="btn-cerradoR" disabled="true">
                            <button class="btn btn-danger" data-dismiss="modal" ng-click="saveDetalleAcero(index,estatus);" class="btn btn-default">Agregar</button>
                        </fieldset>
                    </div>
                </div>
            </div>
        </modal>
    </div>
</div>

