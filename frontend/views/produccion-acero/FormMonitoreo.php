<style type="text/css">
    .third-elm{
        color:red;  
    }
</style>
<div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading" style="height:30px;" >Captura de produccion</div>
    <div id="detalle" style="height: 600px; overflow:auto" >
        <table ng-table class="table table-condensed table-striped table-bordered">
            <tr style="color:#FFF; text-align: center;">
                <th class="width-100" colspan="8"></th>
                <th rowspan="{{monitoreos.length + 2}}"></th>
                <th bgcolor="6F3198" class="width-40" height="25" colspan="3">Desarrollo</th>
                <th rowspan="{{monitoreos.length + 2}}"></th>
                <th bgcolor="FF5050" class="width-40" colspan="3">Almas</th>
                <th rowspan="{{monitoreos.length + 2}}"></th>
                <th bgcolor="00B7EF" class="width-40" colspan="3">Modelos</th>
                <th rowspan="{{monitoreos.length + 2}}"></th>
                <th bgcolor="0072BC" class="width-40" colspan="3">Cajas Almas</th>
                <th rowspan="{{monitoreos.length + 2}}"></th>
                <th bgcolor="00B7EF" class="width-40" colspan="3">Modelos</th>
                <th rowspan="{{monitoreos.length + 2}}"></th>
                <th bgcolor="0072BC" class="width-40" colspan="3">Cajas Almas</th>
            </tr>
            <tr>
                <th class="width-10">Pr</th>
                <th class="width-40">Cliente</th>
                <th class="width-20">Aleacion</th>
                <th class="width-20">Código Cliente</th>
                <th class="width-50">No Parte</th>
                <th class="width-80">Descripción</th>
                <th class="width-10">Area</th>
                <th class="width-10">Prg</th>
                <!--<th class="width-10">H K</th>-->

                <!--Desarrollo-->
                <th class="width-50">Estatus</th>
                <th class="width-10"></th>
                <th class="width-50">Comentarios</th>
                <!--Datos-->
                
                <!--Almas-->
                <th class="width-30">Estatus</th>
                <th class="width-10"></th>
                <th class="width-50">Comentarios</th>
                <!--Modelos Estatus-->
                <th class="width-30">Estatus</th>
                <th class="width-10"></th>
                <th class="width-50">Comentarios</th>
                <!--Cajas Almas estatus-->
                <th class="width-30">Estatus</th>
                <th class="width-10"></th>
                <th class="width-50">Comentarios</th>
                <!--Modelos Ubicacion-->
                <th class="width-30">Ubicacion</th>
                <th class="width-10"></th>
                <th class="width-10">Posicion</th>
                <!--Cajas Almas Ubicacion-->
                <th class="width-30">Ubicacion</th>
                <th class="width-10"></th>
                <th class="width-10">Posicion</th>
            </tr> 
            <tr ng-class="{'info': indexDetalle == $index}" ng-repeat="detalle in monitoreos">
                <th>{{detalle.Prioridad}}</th>
                <th>{{detalle.Cliente}}</th>
                <th>{{detalle.Aleacion}}</th>
                <th>{{detalle.CodigoCliente}}</th>
                <th>{{detalle.Producto}}</th>
                <th>{{detalle.Descripcion}}</th>

                <th>{{detalle.AreaActual}}</th>
                <th>{{detalle.Programadas}}</th>
                <!--<th>{{detalle.Programadas}}</th>-->

                <!--Desarrollo-->
                <th>{{detalle.EstatusDesarrollo}}</th>
                <th>
                    <button type="button" ng-click="MostrarEstatus(2,1); ModalEstatus($index,1,2);" class="btn btn-success btn-sm">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </button>
                </th>
                <th>{{detalle.ComentDesarrollo}}</th>

                <!--Almas-->
                <th>{{detalle.EstatusAlmas}}</th>
                <th>
                    <button type="button" ng-click="MostrarEstatus(3,1); ModalEstatus($index,2);" class="btn btn-success btn-sm">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </button>
                </th>
                <th>{{detalle.ComentAlmas}}</th>

                <!--Modelos Estatus-->
                <th>{{detalle.EstatusModelos}}</th>
                <th>
                    <button type="button" ng-click="MostrarEstatus(1,1); ModalEstatus($index,3);" class="btn btn-success btn-sm">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </button>
                </th>
                <th>{{detalle.ComentModelos}}</th>

                <!--Almas Cajas Estatus-->
                <th>{{detalle.EstatusCajas}}</th>
                <th>
                    <button type="button" ng-click="MostrarEstatus(4,1); ModalEstatus($index,4);" class="btn btn-success btn-sm">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </button>
                </th>
                <th>{{detalle.ComentCajas}}</th>

                <!--Modelos Ubicacion-->
                <th>{{detalle.UbicModelos}}</th>
                <th>
                    <button type="button" ng-click="MostrarEstatus(1,2); ModalEstatus($index,5);" class="btn btn-success btn-sm">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </button>
                </th>
                <th>{{detalle.ComentUbicModelos}}</th>

                <!--Almas Cajas Ubicacion-->
                <th>{{detalle.UbicCajas}}</th>
                <th>
                    <button type="button" ng-click="MostrarEstatus(4,2); ModalEstatus($index,6);" class="btn btn-success btn-sm">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </button>
                </th>
                <th>{{detalle.ComentUbicCajas}}</th>

            </tr>
        </table>

        <!--########################### CICLOS REPOSICION VAREL ########################-->
        <modal title="" visible="showModal">
            <div style="background:{{colorestatus}}; color:#FFF; height:50px; text-align:center; padding-top:1px;" ><h3>{{title}}</h3></div>
            
            <div style="height: 450px;">
                <div class="form-group">
                    <h3 for="producto">No Parte: <label style="color:green;">{{monitoreos[index].Producto}}</label></h3>
                    <input type="hidden" class="form-control" ng-model="idproducto" value="idproducto" id="Producto" />
                </div>     

                <div style="float:left; width:30%;">
                    <div class="input-group">
                        <span class="input-group-addon">Estatus</span>
                        <select id="Moni" ng-model="monitoreos[index].IdTipoEstatusMonitoreo" aria-describedby="Monitoreo" class="form-control input-sm" required>
                            <option value="{{tipo.IdTipoEstatusMonitoreo}}" ng-repeat="tipo in tipomonitoreo" >{{tipo.Descripcion}}</option>
                        </select>
                    </div>
                </div>
                <div style="float:left; width:60%;" >
                    <div class="input-group">
                        <span class="input-group-addon">Comentarios:</span>
                        <textarea cols="15" rows="5" class="form-control" ng-model-options="{updateOn: 'blur'}" ng-model="monitoreos[index].Comentarios" value="{{Comentarios}}"></textarea>
                    </div><br>
           
                    <fieldset id="btn-ciclo" >
                        <button class="btn btn-success" data-dismiss="modal" ng-click="SaveEstatusMonitoreo(index);" class="btn btn-default">Agregar</button>
                    </fieldset>
                </div><br><br>
                <h3 style="padding-top:30px" >Historial de No. Parte</h3>
                <div id="Resumen" style="float:left; width:80%; height:200px; overflow-y: scroll; margin-top:20px" >
                    <table>
                        <tr>
                            <th>Fecha</th>
                            <th>Estatus</th>
                            <th>Comentarios</th>
                        </tr>
                        <tr ng-repeat="resumen in resumenMonitoreo" >
                            <th>{{resumen.Fecha}}</th>
                            <th>{{resumen.Descripcion}}</th>
                            <th>{{resumen.Comentarios}}</th>
                        </tr>
                    </table>
                </div> 
            </div>
        
        </modal>
    </div>
</div>

