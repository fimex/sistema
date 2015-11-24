    <div class="panel panel-primary">

        <div id="capturaRechazadas">
            <div class="panel-heading">Captura de Series y Evidencias</div>
            <div class="contenido" >
                <div class="form-group left">
                    <div class="repetir" ng-repeat="datar in datos.preparacion">
                        <form enctype="multipart/form-data" id="formuploadajax_{{   $index+1}}" method="post">
                            <div class="titulo">Pieza {{piezaLetrero}} no. {{$index+1}}</div>
                            <div class="mid"><!--Contenido mitad izquierdo-->
                                <div class="contiene"><!--Parte superior mitad izquierda-->
                                    <div class="mid">
                                        <div class="contiene"><!--Contiene el motivo-->
                                            <select ng-model="datar.IdDefectoTipo" id="motivos_{{$index+1}}" name="motivos_{{$index+1}}">
                                                <option value="">-- Motivo</option>
                                                <option ng-repeat="defecto in defectos" value="{{defecto.IdDefectoTipo}}">{{defecto.NombreTipo}}</option>
                                            </select>
                                        </div>
                                        <div class="contiene"><!--contiene la serie-->
                                            <select ng-model="datar.IdSerie" id="series_{{$index+1}}" name="series_{{$index+1}}">
                                                <option value="" selected>--Serie</option>
                                                <option ng-repeat="serie in dSeries" value="{{serie.IdSerie}}">{{serie.Serie}}</option>
                                            </select>
                                        </div>
                                    </div><div class="mid"><!--contiene las observaciones-->
                                        <textarea ng-model="datar.Observaciones" placeholder="Escriba sus comentarios" id="observaciones_{{$index+1}}" name="observaciones_{{$index+1}}"></textarea>
                                    </div>
                                </div>
                                <div class="contiene"><!--Contiene espacio para imagen-->
                                    <div class="input">
                                        <input type="file" class="input-file" id="archivo_{{$index+1}}" name="archivo_{{$index+1}}" onchange="javascript:sendImagen(this.id)"/>
                                        Click para subir Imagen
                                    </div>
                                </div>
                            </div><div class="mid"><!--Contenido mitad derecho-->
                                <div class="imagen"><!--Contiene el preview de la imagen-->
                                    <img src="preview.png">
                                </div>
                            </div>
                        </form>
                    </div>                    
                </div>
            </div>
        </div>
    </div>