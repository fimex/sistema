  <?php

use yii\helpers\Html;
use yii\helpers\URL;

$area = Yii::$app->session->get('area');
$area = $area['IdArea'];
$fiel = 'ExitPTB'; $colspan = 'colspan="8"';
if($area == 4){ 
    $fiel = 'ExitGPT'; $colspan = 'colspan="7"'; 
}elseif($area == 3){  
    $fiel = 'ExitPTB'; $colspan = 'colspan="6"';}
?>
<div class="panel panel-default">
    <div class="panel-body">
    </div>
    <div id="opacidad" ng-show="isLoading"></div>
    <div class="animacionGiro" ng-show="isLoading"></div>
    <div id="semanal" class="scrollable">
    <table ng-table fixed-table-headers="semanal" class="table table-striped table-bordered table-hover" id="semana" >
        <thead>
            <tr>
                <th ng-show="mostrar" style="min-width: 30px" rowspan="2"></th>
            <?php if($area == 2){ ?>
                <th ng-show="mostrar" style="max-width: 100px"  rowspan="2">
                    Cliente<br />
                    <span ng-click="orden('Marca',1)" class="seleccion glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span>
                    <span ng-click="orden('Marca',2)" class="seleccion glyphicon glyphicon-triangle-top"aria-hidden="true"></span>
                    <span ng-click="orden('Marca',3)" class="seleccion glyphicon glyphicon-remove" aria-hidden="true"></span>
                    <br />
                    <input class="form-control" ng-model="filtro.cliente" />
                </th>
            <?php } ?>
            <?php if($area == 3){ ?>
                <th ng-show="mostrar" style="min-width: 30px" rowspan="2"></th>
            
                <th ng-show="mostrar" style="min-width: 100px;font-size: 10pt" rowspan="2">
                    Orden<br />
                    <span ng-click="orden('OrdenCompra',1)" class="seleccion glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span>
                    <span ng-click="orden('OrdenCompra',2)" class="seleccion glyphicon glyphicon-triangle-top"aria-hidden="true"></span>
                    <span ng-click="orden('OrdenCompra',3)" class="seleccion glyphicon glyphicon-remove" aria-hidden="true"></span>
                    <br />
                    <input class="form-control" ng-model="filtro.orden" />
                </th>
                <?php } ?>
                <th ng-show="mostrar" style="min-width: 200px" rowspan="2">
                    Descripcion<br />
                    <span ng-click="orden('Descripcion',1)" class="seleccion glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span>
                    <span ng-click="orden('Descripcion',2)" class="seleccion glyphicon glyphicon-triangle-top"aria-hidden="true"></span>
                    <span ng-click="orden('Descripcion',3)" class="seleccion glyphicon glyphicon-remove" aria-hidden="true"></span>
                    <br />
                    <input class="form-control" ng-model="filtro.descripcion" />
                </th>
                <th ng-show="mostrar" style="min-width: 200px" rowspan="2">
                    Cod Cliente<br />
                    <span ng-click="orden('Producto',1)" class="seleccion glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span>
                    <span ng-click="orden('Producto',2)" class="seleccion glyphicon glyphicon-triangle-top"aria-hidden="true"></span>
                    <span ng-click="orden('Producto',3)" class="seleccion glyphicon glyphicon-remove" aria-hidden="true"></span>
                    <br />
                    <input class="form-control" ng-model="filtro.casting" />
                </th>
                <th style="min-width: 200px" rowspan="2">
                    No Parte<br />
                    <span ng-click="orden('Producto',1)" class="seleccion glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span>
                    <span ng-click="orden('Producto',2)" class="seleccion glyphicon glyphicon-triangle-top"aria-hidden="true"></span>
                    <span ng-click="orden('Producto',3)" class="seleccion glyphicon glyphicon-remove" aria-hidden="true"></span>
                    <br />
                    <input class="form-control" ng-model="filtro.producto" />
                </th>
                <th ng-show="mostrar" style="max-width: 100px" rowspan="2">
                    Aleacion<br />
                    <span ng-click="orden('Aleacion',1)" class="seleccion glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span>
                    <span ng-click="orden('Aleacion',2)" class="seleccion glyphicon glyphicon-triangle-top"aria-hidden="true"></span>
                    <span ng-click="orden('Aleacion',3)" class="seleccion glyphicon glyphicon-remove" aria-hidden="true"></span>
                    <br />
                    <input class="form-control" ng-model="filtro.aleacion" />
                </th>
               
                <th rowspan="2">Pzas Pedido</th>  
            <?php if($area == 3){ ?>
                <th rowspan="2" style="max-width: 50px">
                    Fun<br />
                    <input class="form-control" ng-model="filtro.SemanaActual" />
                </th>
            <?php } ?>
                <th <?= $colspan; ?>>Existencias Almacenes</th>
            <?php if($area == 2){ ?>
                <th rowspan="2" valign="middle">PZAS <BR>FALT</th>
                <th rowspan="2" >MOLD <BR>FALT</th>
                <th rowspan="2">MOLD <BR>PROG</th>
                <th style="max-width: 100px" rowspan="2">Cic K</th>
                <th style="max-width: 100px" rowspan="2">Cic V</th>
                <th style="max-width: 100px" rowspan="2">
                    Area <br />
                    <input class="form-control" ng-model="filtro.AreaAct" />
                </th>
            <?php } ?>
            <?php if($area == 3){ ?>
                <th colspan="2">Maquinado</th>
                <th colspan="2">Casting</th>
                <th colspan="2">Programacion</th>
                <th style="max-width: 100px" style="max-width: 100px" rowspan="2">Prog</th>
            <?php } ?>
                <?php for($x=1;$x<=6;$x++):?>
                <?php $class = $x % 2 != 0 ?'par' : 'impar'; ?>
                <th class="<?=$class?>" colspan="4">Semana {{semanas.semana<?=$x?>.week}},{{semanas.semana<?=$x?>.year}}</th>
                <?php endfor;?>
            </tr>
            <tr>
            <?php if($area == 2){ ?>
                <th style="max-width: 50px" >PLA</th>
                <th style="max-width: 50px" >PLA2</th>
                <th style="max-width: 50px" >CTA</th>
                <th style="max-width: 50px" >CTA2</th>
                <th style="max-width: 50px" >PMA</th>
                <th style="max-width: 50px" >PMA2</th>
                <th style="max-width: 50px" >PTA</th>
                <th style="max-width: 50px" >TRA</th>
            <?php } ?>
            <?php if($area == 3){ ?>
                <th style="max-width: 50px" >PLB</th>
                <th style="max-width: 50px" >CTB</th>
                <th style="max-width: 50px" >PCC</th>
                <th style="max-width: 50px" >PMB</th>
                <th style="max-width: 50px" >PTB</th>
                <th style="max-width: 50px" >TRB</th>
                <th style="max-width: 50px" >Exist</th>
                <th style="max-width: 50px" >Falta</th>
                <th style="max-width: 50px" >Exist</th>
                <th style="max-width: 50px" >Falta</th>
            <?php } ?>
            <?php if($area == 4){ ?>
                <th style="max-width: 50px" >Term.</th>
                <th style="max-width: 50px" >Cast.</th>
                <th style="max-width: 50px" >Maq.</th>
                <th style="max-width: 50px" >GPT1</th>
                <th style="max-width: 50px" >GPP</th>
                <th style="max-width: 50px" >GPTA</th> 
                <th style="max-width: 50px" >GPC</th>
                <th style="max-width: 50px" >Exist</th>
                <th style="max-width: 50px" >Falta</th>
                <th style="max-width: 50px" >Exist</th>
                <th style="max-width: 50px" >Falta</th>
            <?php } ?>
            <?php if($area == 3){ ?>
                <th valign="middle">Pzas</th>
                <th>Mol</th>
            <?php } ?>
                <?php for($x=1;$x<=6;$x++):?>
                <?php $class = $x % 2 != 0 ?'par' : 'impar'; ?>
                <th class="<?=$class?>">
                    Pr<br />
                    <span ng-click="orden('Prioridad<?=$x?>',1)" class="seleccion glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span>
                    <span ng-click="orden('Prioridad<?=$x?>',2)" class="seleccion glyphicon glyphicon-triangle-top"aria-hidden="true"></span>
                    <span ng-click="orden('Prioridad<?=$x?>',3)" class="seleccion glyphicon glyphicon-remove" aria-hidden="true"></span>
                </th>
                <th class="<?=$class?>">
                    Prg<br />
                    <span ng-click="orden('Programadas<?=$x?>',1)" class="seleccion glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span>
                    <span ng-click="orden('Programadas<?=$x?>',2)" class="seleccion glyphicon glyphicon-triangle-top"aria-hidden="true"></span>
                    <span ng-click="orden('Programadas<?=$x?>',3)" class="seleccion glyphicon glyphicon-remove" aria-hidden="true"></span>
                </th>
                <th class="<?=$class?>2">
                    H<br />
                    <span ng-click="orden('Hechas<?=$x?>',1)" class="seleccion glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span>
                    <span ng-click="orden('Hechas<?=$x?>',2)" class="seleccion glyphicon glyphicon-triangle-top"aria-hidden="true"></span>
                    <span ng-click="orden('Hechas<?=$x?>',3)" class="seleccion glyphicon glyphicon-remove" aria-hidden="true"></span>
                </th>
            <?php if($area == 2){ ?>
                <th class="<?=$class?>2">
                    F<br />
                    <span ng-click="orden('Programadas<?=$x?>',1)" class="seleccion glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span>
                    <span ng-click="orden('Programadas<?=$x?>',2)" class="seleccion glyphicon glyphicon-triangle-top"aria-hidden="true"></span>
                    <span ng-click="orden('Programadas<?=$x?>',3)" class="seleccion glyphicon glyphicon-remove" aria-hidden="true"></span>
                </th>
            <?php }else{ ?>
                    <th class="<?=$class?>2">
                        Hrs<br />
                        <span ng-click="orden('Programadas<?=$x?>',1)" class="seleccion glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span>
                        <span ng-click="orden('Programadas<?=$x?>',2)" class="seleccion glyphicon glyphicon-triangle-top"aria-hidden="true"></span>
                        <span ng-click="orden('Programadas<?=$x?>',3)" class="seleccion glyphicon glyphicon-remove" aria-hidden="true"></span>
                    </th>
            <?php } endfor;?>
            </tr>
        </thead>
        <tbody style="font-size: 10pt">
            <tr style="{{programacion.class}}"
                ng-click="aleacion = programacion.Aleacion;"
                ng-repeat="programacion in programaciones | orderBy:arr | filter:{
                    Orden2:filtro.orden2,
                    OrdenCompra:filtro.orden,
                    Producto:filtro.producto,
                    ProductoCasting:filtro.casting,
                    Descripcion:filtro.descripcion,
                    FechaEmbarque:filtro.embarque,
                    FechaEnvio:filtro.envio,
                    Aleacion:filtro.aleacion,
                    Marca:filtro.cliente,
                    AreaAct:filtro.AreaAct,
                    SemanaActual:filtro.SemanaActual
                }"
                ng-click="setSelected(programacion);"
                ng-class="{warning:selected.IdProgramacion == programacion.IdProgramacion}">
                <th ng-show="mostrar" > <input type="checkbox" class="form-control" name="Cerrado[]" value="{{programacion.IdProgramacion}}"  /></th>
            <?php if($area == 3){ ?>
                <th ng-show="mostrar" >{{programacion.OrdenCompra}}</th>
            <?php } ?>
                <th ng-show="mostrar" style="max-width: 100px">{{programacion.Marca}}</th>
                <th title="{{programacion.Descripcion}}" ng-show="mostrar" >{{programacion.Descripcion | uppercase | limitTo : 15}}</th>
                <th title="{{programacion.producto}}" ng-show="mostrar" >{{programacion.ProductoCasting | uppercase | limitTo : 15}}</th>
                <th>{{programacion.Producto}}</th>
                <th ng-show="mostrar" style="max-width: 100px">{{programacion.Aleacion}}</th>
                <th style="max-width: 50px">{{programacion.SaldoCantidad}}</th>
                <th style="max-width: 50px" class="info">{{programacion.PLA == 0 ? '' : programacion.PLA}}</th>
                <th style="max-width: 50px" class="info">{{programacion.PLA2 == 0 ? '' : programacion.PLA2}}</th>
                <th style="max-width: 50px" class="info">{{programacion.CTA == 0 ? '' : programacion.CTA}}</th>
                <th style="max-width: 50px" class="info">{{programacion.CTA2 == 0 ? '' : programacion.CTA2}}</th>
                <th style="max-width: 50px" class="info">{{programacion.PMA == 0 ? '' : programacion.PMA}}</th>
                <th style="max-width: 50px" class="info">{{programacion.PMA2 == 0 ? '' : programacion.PMA2}}</th>
                <th style="max-width: 50px" class="info">{{programacion.PTA == 0 ? '' : programacion.PTA}}</th>
                <th style="max-width: 50px" class="info">{{programacion.TRA == 0 ? '' : programacion.TRA}}</th>
            <?php if($area == 2){ ?>
                <th valign="middle">{{programacion.FaltaCasting <= 0 ? '' : programacion.FaltaCasting }}</th>
                <th>{{ programacion.FaltaCasting <= 0 ? '' : programacion.FaltaCasting/programacion.PiezasMolde | number : 0 }}</th>
                <th>{{((1 * programacion.Programadas1) + (1 * programacion.Programadas2) + (1 * programacion.Programadas3) + (1 * programacion.Programadas4)) | number : 1}}</th>
                <th style="max-width: 100px">{{programacion.CiclosMolde || ''}}</th>
                <th style="max-width: 100px">{{programacion.CiclosVarel || ''}}</th>
                <th style="max-width: 100px">{{programacion.AreaAct}}</th>
            <?php } ?>
            <?php if($area == 3){ ?>
                <th class="active"><input style="width: 50px;" ng-model="programado"></th>
                <th class="active">{{programado / programacion.PiezasMolde | number:0}}</th>
                <th class="active">{{programacion.Programadas == 0 ? '' : programacion.Programadas * programacion.PiezasMolde}}</th>
            <?php } ?>
            <?php for($x=1;$x<=6;$x++): ?>
                <?php $class = $x % 2 != 0 ?'par' : 'impar'; ?>
                <th class="<?=$class?>"><input style="width: 50px;" ng-model-options="{updateOn: 'blur'}" ng-focus="setSelected(programacion);" ng-change="saveProgramacionSemanal(programacion,<?=$x?>);" ng-model="programacion.Prioridad<?=$x?>" value="{{programacion.Prioridad<?=$x?>}}"></th>
                <th class="<?=$class?>"><input style="width: 50px;" ng-model-options="{updateOn: 'blur'}" ng-focus="setSelected(programacion);" ng-change="saveProgramacionSemanal(programacion,<?=$x?>);" ng-model="programacion.Programadas<?=$x?>" value="{{programacion.Programadas<?=$x?>}}"></th>
                <th class="<?=$class?>2">{{programacion.Llenadas<?=$x?>}}</th>
                <th class="<?=$class?>2">{{(programacion.Programadas<?=$x?> - programacion.Llenadas<?=$x?>) | number : 1}}</th>
            <?php endfor; ?>
            </tr>
        </tbody>
    </table>
    </div>
</div>
<?php 
if($area == 2){
?>
<div id="encabezado" class="row">
    <div ng-repeat="resumen in resumenes" class="col-md-3">
        <table ng-class="{par:$index % 2 == 0, impar:$index % 2 != 0}" class="table table-bordered table-hover">
            <tr>
                <th rowspan="2">Resumen</th>
                <th colspan="4">Semana {{resumen.Semana}},{{resumen.Anio}}</th>
            </tr>
            <tr>
                <th>K</th>
                <th>V</th>
                <th>E</th>
            </tr>
            <tr>
                <th>TON PRG</th>
                <th>{{resumen.TonPrgK == 0 ? 0 : resumen.TonPrgK | currency:'':3}}</th>
                <th>{{resumen.TonPrgV | currency:'':3}}</th>
                <th>{{resumen.TonPrgE | currency:'':3}}</th>
            </tr>
            <tr>
                <th>TON VAC</th>
                <th>{{resumen.TonVacK | currency:'':0}}</th>
                <th>{{resumen.TonVacV | currency:'':0}}</th>
                <th>{{resumen.TonVacE | currency:'':0}}</th>
            </tr>
            <tr>
                <th>CICLOS</th>
                <th>{{resumen.CiclosK}}</th>
                <th>{{resumen.CiclosV}}</th>
                <th>{{resumen.CiclosE}}</th>
            </tr>
            <tr>
                <th>MOLD PRG</th>
                <th>{{resumen.MolPrgK}}</th>
                <th>{{resumen.MolPrgV}}</th>
                <th>{{resumen.MolPrgE}}</th>
            </tr>
            <tr>
                <th>Total {{aleacion}}</th>
                <th colspan="3" ng-repeat="Aleacion in resumen.aleaciones" ng-if="Aleacion.Aleacion == aleacion">{{Aleacion.Total}}</th>
            </tr>
        </table>
    </div>
</div>
<?php } ?>
