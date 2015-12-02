    <div class="panel panel-primary">

        <div id="capturaRechazadas">
            <div class="panel-heading">Captura de Series y Evidencias</div>
            <div class="contenido" >
                <div class="form-group left">
                    <div class="repetir" ng-repeat="datar in datos.preparacion">
                        <form enctype="multipart/form-data" ng-attr-id="{{'formuploadajax_'+$index}}" method="post">
                            <div class="titulo">Pieza {{piezaLetrero}} no. {{$index+1}}</div>
                            <div class="mid"><!--Contenido mitad izquierdo-->
                                <div class="contiene"><!--Parte superior mitad izquierda-->
                                    <div class="mid">
                                        <div class="contiene"><!--Contiene el motivo-->
                                            <select ng-model="datar.IdDefectoTipo" ng-attr-id="{{'motivos_'+$index}}" name="motivos">
                                                <option value="">-- Motivo</option>
                                                <option ng-repeat="defecto in defectos" value="{{defecto.IdDefectoTipo}}">{{defecto.NombreTipo}}</option>
                                            </select>
                                        </div>
                                        <div class="contiene"><!--contiene la serie-->
                                            <select ng-model="datar.IdSerie" ng-attr-id="{{'series_'+$index}}" name="series">
                                                <option value="" selected>--Serie</option>
                                                <option ng-repeat="serie in dSeries" value="{{serie.IdSerie}}">{{serie.Serie}}</option>
                                            </select>
                                        </div>
                                    </div><div class="mid"><!--contiene las observaciones-->
                                        <textarea ng-model="datar.Observaciones" placeholder="Escriba sus comentarios" ng-attr-id="{{'observaciones_'+$index}}" name="observaciones"></textarea>
                                    </div>
                                </div>
                                <div class="contiene"><!--Contiene espacio para imagen-->
                                    <div class="input">
                                        <input type="file" class="input-file" ng-attr-id="{{'archivo_'+$index}}" name="{{'archivo_'+$index}}" ng-model="archivo_$index" onchange="sendImagen(this.id)"/>
                                        Click para subir Imagen
                                    </div>
                                </div>
                                <input type="hidden" name="nombreImagen" ng-model="nombreImagen" id="nombreImagen" value="{{'archivo_'+$index}}" >
                            </div><div class="mid">
                                <!--<div class="imagen" id="imagen_{{$index+1}}">
                                    <img src="preview.png">
                                </div>-->
                            </div>
                        </form>
                    </div>                    
                </div>
            </div>
        </div>
    </div>