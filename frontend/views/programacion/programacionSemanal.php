  <?php

use yii\helpers\Html;
use yii\helpers\URL;

$fiel = 'ExitPTB'; $colspan = 'colspan="8"';
if($IdArea == 4){ 
    $fiel = 'ExitGPT'; $colspan = 'colspan="7"'; 
}elseif($IdArea == 3){  
    $fiel = 'ExitPTB'; $colspan = 'colspan="6"';}
?>
<div class="panel panel-default">
    <div class="panel-body"></div>
    <div id="opacidad" ng-show="isLoading"></div>
    <div class="animacionGiro" ng-show="isLoading"></div>
    <div id="semanal" class="scrollable">
    <table fixed-table-headers="semanal" cell-fixed="semanal" class="table table-striped table-bordered table-hover">
        <?php if($IdArea == 3): ?>
        <thead>
            <tr>
                <th ng-show="mostrar" style="min-width: 30px" rowspan="2"></th>
                <th ng-show="mostrar" style="min-width: 100px;font-size: 10pt" rowspan="2">
                    <ordenamiento title="Orden" element="OrdenCompra" arreglo="arr"></ordenamiento>
                    <input class="form-control" ng-model="filtro.orden" />
                    
                </th>
                <th ng-show="mostrar" style="min-width: 200px" rowspan="2">
                    <ordenamiento title="Descripcion" element="Descripcion" arreglo="arr"></ordenamiento>
                    <input class="form-control" ng-model="filtro.descripcion" />
                </th>
                <th ng-show="mostrar" style="max-width: 100px" rowspan="2">
                    
                    <ordenamiento title="Fecha Cliente" element="FechaEmbarque" arreglo="arr"></ordenamiento>
                    <input class="form-control" ng-model="filtro.embarque" />
                </th>
                <th ng-show="mostrar" style="max-width: 100px" rowspan="2">
                    <ordenamiento title="Fecha Embarque" element="FechaEnvio" arreglo="arr"></ordenamiento>
                    <input class="form-control" ng-model="filtro.envio" />
                </th>
                <th ng-show="mostrar" style="max-width: 100px" rowspan="2">
                    <ordenamiento title="Aleacion" element="Aleacion" arreglo="arr"></ordenamiento>
                    <input class="form-control" ng-model="filtro.aleacion" />
                </th>
                <th ng-show="mostrar" style="max-width: 100px" rowspan="2">
                    <ordenamiento title="Cliente" element="Marca" arreglo="arr"></ordenamiento>
                    <input class="form-control" ng-model="filtro.cliente" />
                </th>
                <th style="max-width: 100px" rowspan="2">
                    <ordenamiento title="Producto" element="Producto" arreglo="arr"></ordenamiento>
                    <input class="form-control" ng-model="filtro.producto" />
                </th>
                <th style="max-width: 100px" rowspan="2">
                    <ordenamiento title="Casting" element="ProductoCasting" arreglo="arr"></ordenamiento>
                    <input class="form-control" ng-model="filtro.casting" />
                </th>
                <th rowspan="2" style="max-width: 50px">
                    <ordenamiento title="Ped" element="SaldoCantidad" arreglo="arr"></ordenamiento>
                </th>
                <th rowspan="2" style="max-width: 50px">
                    <ordenamiento title="Fun" element="SemanaActual" arreglo="arr"></ordenamiento>
                    <input class="form-control" ng-model="filtro.SemanaActual" />
                </th>
                <th <?= $colspan; ?>>Existencias Almacenes</th>
                <th colspan="2">Maquinado</th>
                <th colspan="2">Casting</th>
                <th colspan="2">Programacion</th>
                <th style="max-width: 100px" style="max-width: 100px" rowspan="2">Prog</th>
                <?php for($x=1;$x<=4;$x++):?>
                <?php $class = $x % 2 != 0 ?'par' : 'impar'; ?>
                <th class="<?=$class?>" colspan="4">Semana {{semanas.semana<?=$x?>.week}},{{semanas.semana<?=$x?>.year}}</th>
                <?php endfor;?>
            </tr>
            <tr>
                <th style="max-width: 50px" class="info">PLB</th>
                <th style="max-width: 50px" class="info">CTB</th>
                <th style="max-width: 50px" class="info" >PCC</th>
                <th style="max-width: 50px" class="info" >PMB</th>
                <th style="max-width: 50px" class="info" >PTB</th>
                <th style="max-width: 50px" class="info" >TRB</th>
                <th style="max-width: 50px" class="warning" >Exist</th>
                <th style="max-width: 50px" class="warning" >Falta</th>
                <th style="max-width: 50px" class="warning" >Exist</th>
                <th style="max-width: 50px" class="warning" >Falta</th>
                <th valign="middle">Pzas</th>
                <th>Mol</th>
                <?php for($x=1;$x<=4;$x++):?>
                <?php $class = $x % 2 != 0 ?'par' : 'impar'; ?>
                <th class="<?=$class?>">
                    <ordenamiento title="Pr" element="Prioridad<?=$x?>" arreglo="arr"></ordenamiento>
                </th>
                <th class="<?=$class?>">
                    <ordenamiento title="Prg" element="Programadas<?=$x?>" arreglo="arr"></ordenamiento>
                </th>
                <th class="<?=$class?>2">
                    <ordenamiento title="H" element="Hechas<?=$x?>" arreglo="arr"></ordenamiento>
                </th>
                <th class="<?=$class?>2">
                    <ordenamiento title="Hrs" element="Programadas<?=$x?>" arreglo="arr"></ordenamiento>
                </th>
                <?php endfor;?>
            </tr>
        </thead>
        <tbody style="font-size: 10pt">
            <tr style="{{programacion.class}}" 
                <?php if($IdProceso == 2):?>ng-show="programacion.PLB > 0 || programacion.PLB2 > 0 "<?php endif;?>
                ng-repeat="programacion in programaciones | filter:{
                    Orden2:filtro.orden2,
                    OrdenCompra:filtro.orden,
                    Producto:filtro.producto,
                    ProductoCasting:filtro.casting,
                    Descripcion:filtro.descripcion,
                    FechaEmbarque:filtro.embarque,
                    FechaEnvio:filtro.envio,
                    Aleacion:filtro.aleacion,
                    Marca:filtro.cliente,
                    SemanaActual:filtro.SemanaActual,
                    Estatus:filtro.Estatus
        } | orderBy:arr" ng-click="setSelected(programacion);" ng-class="{warning:selected.IdProgramacion == programacion.IdProgramacion}">
                <th class="fixed" ng-show="mostrar" > <input type="checkbox" class="form-control" name="Cerrado[]" value="{{programacion.IdProgramacion}}"  /></th>
                <th ng-show="mostrar" >{{programacion.OrdenCompra}}</th>
                <th title="{{programacion.Descripcion}}" ng-show="mostrar" >{{programacion.Descripcion | uppercase | limitTo : 15}}</th>
                <th ng-show="mostrar" style="min-width: 150px">{{programacion.FechaEmbarque | date:'dd-MMM-yyyy'}}</th>
                <th ng-show="mostrar" ><input type="date" style="width:135px;height: 25px;" ng-disabled="programacion.Estatus == 'Cerrado'" ng-change="saveEnvio(programacion.IdPedido,programacion.FechaEnvio);" ng-model="programacion.FechaEnvio" format-date></th>
                <th ng-show="mostrar" style="max-width: 100px">{{programacion.Aleacion}}</th>
                <th ng-show="mostrar" style="max-width: 100px">{{programacion.Marca}}</th>
                <th class="fixed" style="mix-width: 100px">{{programacion.Producto}}</th>
                <th class="fixed" style="max-width: 100px">{{programacion.ProductoCasting}}</th>
                <td style="width: 50px">{{programacion.Ensamble == 2 ? programacion.Cantidad : programacion.SaldoCantidad}}</td>
                <th style="max-width: 50px">{{programacion.SemanaActual}}</th>
                <th style="max-width: 50px" class="info">{{programacion.PLB == 0 ? '' : programacion.PLB}}</th>
                <th style="max-width: 50px" class="info">{{programacion.CTB == 0 ? '' : programacion.CTB}}</th>
                <th style="max-width: 50px" class="info">{{programacion.PCC == 0 ? '' : programacion.PCC}}</th>
                <th style="max-width: 50px" class="info">{{programacion.PMB == 0 ? '' : programacion.PMB}}</th>
                <th style="max-width: 50px" class="info">{{programacion.PTB == 0 ? '' : programacion.PTB}}</th>
                <th style="max-width: 50px" class="info">{{programacion.TRB == 0 ? '' : programacion.TRB}}</th>
                <th style="max-width: 50px" class="warning">{{programacion.ExitMaquinado}}</th>
                <th style="max-width: 50px" class="warning">{{programacion.FaltaMaquinado}}</th>
                <th style="max-width: 50px" class="warning">{{programacion.ExitCasting}}</th>
                <th style="max-width: 50px" class="warning">{{programacion.FaltaCasting}}</th>
                <th class="active"><input style="width: 50px;" ng-model="programado"></th>
                <th class="active">{{programado / programacion.PiezasMolde | number:0}}</th>
                <th class="active">{{programacion.Programadas == 0 ? '' : programacion.Programadas * programacion.PiezasMolde}}</th>
            <?php for($x=1;$x<=4;$x++): ?>
                <?php $class = $x % 2 != 0 ?'par' : 'impar'; ?>
                <th class="<?=$class?>"><input style="width: 50px;" ng-disabled="programacion.Estatus == 'Cerrado' || TipoUsuario != 1" ng-model-options="{updateOn: 'blur'}" ng-focus="setSelected(programacion);" ng-change="saveProgramacionSemanal(programacion,<?=$x?>);" ng-model="programacion.Prioridad<?=$x?>" value="{{programacion.Prioridad<?=$x?>}}"></th>
                <th class="<?=$class?>"><input style="width: 50px;" ng-disabled="programacion.Estatus == 'Cerrado' || TipoUsuario != 1" ng-model-options="{updateOn: 'blur'}" ng-focus="setSelected(programacion);" ng-change="saveProgramacionSemanal(programacion,<?=$x?>);" ng-model="programacion.Programadas<?=$x?>" value="{{programacion.Programadas<?=$x?>}}"></th>
                <th class="<?=$class?>2">{{programacion.Llenadas<?=$x?>}}</th>
                <th class="<?=$class?>2">{{(programacion.Programadas<?=$x?> / programacion.MoldesHora) | number : 1}}</th>
            <?php endfor; ?>
            </tr>
        </tbody>
        <?php endif;?>
        <?php if($IdArea == 2): ?>
        <thead>
            <tr>
                <th ng-show="mostrar" style="min-width: 30px" rowspan="2"></th>
                <th ng-show="mostrar" style="max-width: 100px"  rowspan="2">
                    <ordenamiento title="Cliente" element="Marca" arreglo="arr"></ordenamiento>
                    <input class="form-control" ng-model="filtro.cliente" />
                    
                </th>
                <th ng-show="mostrar" style="min-width: 200px" rowspan="2">
                    <ordenamiento title="Descripcion" element="Descripcion" arreglo="arr"></ordenamiento>
                    <input class="form-control" ng-model="filtro.descripcion" />
                </th>
                <th ng-show="mostrar" style="min-width: 200px" rowspan="2">
                    <ordenamiento title="Cod Cliente" element="ProductoCasting" arreglo="arr"></ordenamiento>
                    <input class="form-control" ng-model="filtro.casting" />
                </th>
                <th style="min-width: 200px" rowspan="2">
                    <ordenamiento title="No Parte" element="Producto" arreglo="arr"></ordenamiento>
                    <input class="form-control" ng-model="filtro.producto" />
                </th>
                <th ng-show="mostrar" style="max-width: 100px" rowspan="2">
                    <ordenamiento title="Aleacion" element="Aleacion" arreglo="arr"></ordenamiento>
                    <input class="form-control" ng-model="filtro.aleacion" />
                </th>
               
                <th rowspan="2">Pzas Pedido</th>  
                <th <?= $colspan; ?>>Existencias Almacenes</th>
                <th rowspan="2" valign="middle">PZAS <BR>FALT</th>
                <th rowspan="2" >MOLD <BR>FALT</th>
                <th rowspan="2">MOLD <BR>PROG</th>
                <th style="max-width: 100px" rowspan="2">Cic K</th>
                <th style="max-width: 100px" rowspan="2">Cic V</th>
                <th style="max-width: 100px" rowspan="2">
                    Area <br />
                    <input class="form-control" ng-model="filtro.AreaAct" />
                </th>
                <?php for($x=1;$x<=6;$x++):?>
                <?php $class = $x % 2 != 0 ?'par' : 'impar'; ?>
                <th class="<?=$class?>" colspan="4">Semana {{semanas.semana<?=$x?>.week}},{{semanas.semana<?=$x?>.year}}</th>
                <?php endfor;?>
            </tr>
            <tr>
                <th style="max-width: 50px" >PLA</th>
                <th style="max-width: 50px" >PLA2</th>
                <th style="max-width: 50px" >CTA</th>
                <th style="max-width: 50px" >CTA2</th>
                <th style="max-width: 50px" >PMA</th>
                <th style="max-width: 50px" >PMA2</th>
                <th style="max-width: 50px" >PTA</th>
                <th style="max-width: 50px" >TRA</th>
                <?php for($x=1;$x<=6;$x++):?>
                <?php $class = $x % 2 != 0 ?'par' : 'impar'; ?>
                <th class="<?=$class?>">
                    <ordenamiento title="Pr" element="Prioridad<?=$x?>" arreglo="arr"></ordenamiento>
                </th>
                <th class="<?=$class?>">
                    <ordenamiento title="Prg" element="Programadas<?=$x?>" arreglo="arr"></ordenamiento>
                </th>
                <th class="<?=$class?>2">
                    <ordenamiento title="H" element="Hechas<?=$x?>" arreglo="arr"></ordenamiento>
                </th>
                <th class="<?=$class?>2">
                    F
                </th>
                <?php endfor;?>
            </tr>
        </thead>
        <tbody style="font-size: 10pt">
            <tr style="{{programacion.class}}"
                ng-click="aleacion = programacion.Aleacion;"
                <?php if($IdProceso == 2):?>ng-show="programacion.PLA > 0 || programacion.PLA2 > 0 "<?php endif;?>
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
                <th valign="middle">{{programacion.FaltaCasting <= 0 ? '' : programacion.FaltaCasting }}</th>
                <th>{{ programacion.FaltaCasting <= 0 ? '' : programacion.FaltaCasting/programacion.PiezasMolde | number : 0 }}</th>
                <th>{{((1 * programacion.Programadas1) + (1 * programacion.Programadas2) + (1 * programacion.Programadas3) + (1 * programacion.Programadas4)) | number : 1}}</th>
                <th style="max-width: 100px">{{programacion.CiclosMolde || ''}}</th>
                <th style="max-width: 100px">{{programacion.CiclosVarel || ''}}</th>
                <th style="max-width: 100px">{{programacion.AreaAct}}</th>
            <?php for($x=1;$x<=6;$x++): ?>
                <?php $class = $x % 2 != 0 ?'par' : 'impar'; ?>
                <th class="<?=$class?>"><input style="width: 50px;" ng-model-options="{updateOn: 'blur'}" ng-disabled="TipoUsuario != 1" ng-focus="setSelected(programacion);" ng-change="saveProgramacionSemanal(programacion,<?=$x?>);" ng-model="programacion.Prioridad<?=$x?>" value="{{programacion.Prioridad<?=$x?>}}"></th>
                <th class="<?=$class?>"><input style="width: 50px;" ng-model-options="{updateOn: 'blur'}" ng-disabled="TipoUsuario != 1" ng-focus="setSelected(programacion);" ng-change="saveProgramacionSemanal(programacion,<?=$x?>);" ng-model="programacion.Programadas<?=$x?>" value="{{programacion.Programadas<?=$x?>}}"></th>
                <th class="<?=$class?>2">{{programacion.Llenadas<?=$x?>}}</th>
                <th class="<?=$class?>2">{{(programacion.Programadas<?=$x?> - programacion.Llenadas<?=$x?>) | number : 1}}</th>
            <?php endfor;?>
            </tr>
        </tbody>
        <?php endif;?>
    </table>
    </div>
</div>
<?php if ($IdArea == 3 && $IdProceso == 1): ?>
<div id="encabezado" class="row">
    <div ng-repeat="resumen in resumenes" class="col-md-3">
        <table ng-class="{par:$index % 2 == 0, impar:$index % 2 != 0}" class="table table-bordered table-hover">
            <tr>
                <th rowspan="2">Resumen</th>
                <th colspan="4">Semana {{resumen.Semana}},{{resumen.Anio}}</th>
            </tr>
            <tr>
                <th>Mol</th>
                <th>Ton</th>
                <th>Ton P</th>
                <th>Hrs</th>
            </tr>
            <tr>
                <th>PRG</th>
                <th>{{resumen.PrgMol}}</th>
                <th>{{resumen.PrgTon | currency:'':2}}</th>
                <th>{{resumen.PrgTonP | currency:'':2}}</th>
                <th>{{resumen.PrgHrs | currency:'':1}}</th>
            </tr>
            <tr>
                <th>PROD</th>
                <th>{{resumen.HecMol}}</th>
                <th>{{resumen.HecTon | currency:'':2}}</th>
                <th>{{resumen.HecTonP | currency:'':2}}</th>
                <th>{{resumen.HecHrs | currency:'':1}}</th>
            </tr>
            <tr>
                <th>% PROD</th>
                <th>{{((resumen.HecMol / resumen.PrgMol)*100)| currency:'':2}}%</th>
                <th>{{((resumen.HecTon / resumen.PrgTon)*100)| currency:'':2}}%</th>
                <th>{{((resumen.HecTonP / resumen.PrgTonP)*100)| currency:'':2}}%</th>
                <th>{{((resumen.HecHrs / resumen.PrgHrs)*100)| currency:'':2}}%</th>
            </tr>
        </table>
    </div>
</div>
<?php endif;?>
<?php if($IdArea == 2 && $IdProceso == 1): ?>
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
<?php endif;?>