<?php
    use yii\helpers\Html;
    use yii\grid\GridView;
    use yii\widgets\ActiveForm;
    use yii\helpers\ArrayHelper;
    use yii\helpers\URL;

    /* @var $this yii\web\View */
    /* @var $dataProvider yii\data\ActiveDataProvider */
    $sem = 0;
    $tota1 = 0; $tota2 = 0; $tota3 = 0; $tota4 = 0; $tota5 = 0; $tota6 = 0; $tota7 = 0; $tota8 = 0; 
    $tota9 = 0; $tota10 = 0; $tota11 = 0; $tota12 = 0; $tota13 = 0; $tota14 = 0; $tota15 = 0; $tota16 = 0; $tota17 = 0; 
    $maquina = '';
    if(isset($_GET['maquina'])) $maquina =  $_GET['maquina'];
    $turno = isset($_GET['IdTurno']) ? $_GET['IdTurno'] : 1;
?>
<div style="margin-bottom: 20px" >
    <form id="form_ete" class="easyui-form" method="get">
        <label>Fecha ini: </label><input id="fecha_ini" value="<?php if(isset($_GET['ini'])) echo $_GET['ini']; ?>" class="easyui-datebox" style="width:200px" data-options="formatter:myformatter,parser:myparser" type="text" >
        <label>Fecha fin: </label><input id="fecha_fin" value="<?php if(isset($_GET['fin'])) echo $_GET['fin']; ?>" class="easyui-datebox" style="width:200px" data-options="formatter:myformatter,parser:myparser" >
        <label>Turno: </label>
        <input width="20" id="turno" value="<?= $turno;?>" class="easyui-combobox" 
                        data-options="
                            url:'/fimex/angular/turnos',
                            method:'get',
                            valueField:'IdTurno',
                            textField:'Descripcion',
                            panelHeight:'100',  
                        ">
        <label>Maquina: </label>
        <input width="20" id="maquina" value="<?= $maquina ?>" class="easyui-combobox" 
                        data-options="
                            url:'/fimex/angular/maquinas?IdSubProceso=6&IdArea=3',
                            method:'get',
                            valueField:'IdMaquina',
                            textField:'ClaveMaquina',
                            panelHeight:'100',  
                        ">
        <a href="#" class="easyui-linkbutton" onclick="Filtrar();" >Filtrar</a>
    </form>
</div>
<div class="reporte-ete" ng-app>
    <table id="ff" class="table table-striped">
        <tbody>
            <?php foreach ($resumen as $value => $key):?>
                <thead><tr><th colspan='20' > Semana <?=$value?> </th></tr>  </thead>
                <thead>
                    <tr>
                        <th>Fecha</th> 
                        <th>No. Parte</th>
                        <th>Inicio</th>
                        <th>Fin</th>
                        <th>T Disp</th>
                        <th>T Real</th>
                        <th>SU</th>
                        <th>MC</th>
                        <th>MP</th>
                        <th>TT</th>
                        <th>MI</th>
                        <th>MPRO</th>
                        <th>DISPO</th>
                        <th>P Esp</th>
                        <th>P Real</th>
                        <th>EFIC</th>
                        <th>Rec</th>
                        <th>OK</th>
                        <th>CAL</th>
                        <th>ETE</th>
                    </tr>
                </thead>
                <?php foreach ($model as $detail):?>
                    <?php $Ti = ( ( date('H',strtotime($detail['Inicio'])) * 60 ) + date('i',strtotime($detail['Inicio'])));?>
                    <?php if($detail['Semana'] == $value):?>
                         <tr style="color:#6E6E6E;font-weight: lighter" >
                            <th><?=$detail['Fecha']?></th>
                            <th><?=$detail['Identificacion']?></th>
                            <th><?= date('H:i',strtotime($detail['Inicio']))?></th>
                            <th><?= date('H:i',strtotime($detail['Fin']))?></th>
                            <th><?= $detail['TTOT']?></th>
                            <th><?= $detail['TDISPO']?></th>
                            <th><?= $detail['SU']?></th>
                            <th><?= $detail['MC']?></th>
                            <th><?= $detail['MP']?></th>
                            <th><?= $detail['TT']?></th>
                            <th><?= $detail['MI']?></th>
                            <th><?= $detail['MPRO']?></th>
                            <th><?=round($detail['DISPO'])."%"?></th>
                            <th><?=number_format($detail['PESPERADO'])?></th>
                            <th><?=number_format($detail['PREAL'])?></th>
                            <th><?=round($detail['EFICIENCIA'])."%"?></th>
                            <th>{{recha<?=$tota17?>}}</th>
                            <th>{{OK<?=$tota17?>}}</th>
                            <th>{{Cali<?=$tota17?>}}%</th>
                            <th><?=round($detail['ETE'])."%"?></th>
                        </tr>
                    <?php endif;?>
                <?php endforeach;?>
                <tr>
                    <th colspan="4" >Resumen de la Semana <?= $value ?> </th>
                    <th><?= $key['TTOT']?></th>
                    <th><?= $key['TDISPO']?></th>
                    <th><?= $key['SU']?></th>
                    <th><?= $key['MC']?></th>
                    <th><?= $key['MP']?></th>
                    <th><?= $key['TT']?></th>
                    <th><?= $key['MI']?></th>
                    <th><?= $key['MPRO']?></th>
                    <th><?= ($key['TDISPO'] == 0 ? 0 : round(($key['TDISPO']/$key['TTOT'])*100))."%"?></th>
                    <th><?= $key['PESPERADO']?></th>
                    <th><?= $key['PREAL']?></th>
                    <th><?= ($key['PREAL'] == 0 && $key['PESPERADO'] == 0? 0 : round(($key['PREAL']/$key['PESPERADO'])*100))."%"?></th>
                    <th ng-init="recha<?=$tota17?> = '<?= $key["Rechazadas"]?>'">{{recha<?=$tota17?>}}</th>
                    <th ng-init="OK<?=$tota17?> = <?=$key["OK"]?>">{{OK<?=$tota17?>}}</th>
                    <th ng-init="Cali<?=$tota17?> = <?= round($key["CALIDAD"])?>">{{Cali<?=$tota17?>}}%</th>
                    <th><?= round((($key['TDISPO'] == 0 ? 0 : ($key['TDISPO']/$key['TTOT'])) * ($key['PREAL'] == 0 ? 0 : ($key['PREAL']/$key['PESPERADO'])) * ($key["OK"] == 0 ? 0 :$key["OK"] / ($key["Rechazadas"] + $key["OK"])))*100)?>%</th>
                </tr>
                <?php 
                    $tota1 += $key['TTOT'];
                    $tota2 += $key['TDISPO'];
                    $tota3 += $key['SU'];
                    $tota4 += $key['MC'];
                    $tota5 += $key['MP'];
                    $tota6 += $key['TT'];
                    $tota7 += $key['MI'];
                    $tota8 += $key['MPRO'];

                    $tota10 += $key['PESPERADO'];
                    $tota11 += $key['PREAL'];
                    $tota12 += round($key['EFICIENCIA']/$key['TotalDA']);
                    $tota13 += $key['Rechazadas'];
                    $tota14 += $key['OK'];
                    $tota17 ++;
                ?>
            <?php endforeach;?>
            <tr>
                <th colspan="4" >TOTAL </th>
                <th><?= $tota1?></th>
                <th><?= $tota2?></th>
                <th><?= $tota3?></th>
                <th><?= $tota4?></th>
                <th><?= $tota5?></th>
                <th><?= $tota6?></th>
                <th><?= $tota7?></th>
                <th><?= $tota8?></th>
                <th><?= ($tota2 == 0 ? 0 : round(($tota2/$tota1)*100))?>%</th>
                <th><?= number_format($tota10)?></th>
                <th><?= number_format($tota11)?></th>
                <th><?= $tota12 == 0 ? 0:(round(($tota11/$tota10)*100))?>%</th>
                <th><?= $tota13?></th>
                <th><?= $tota14?></th>
                <th><?= ($tota14 == 0 ? 0 : round(($tota14/($tota13 + $tota14))*100))?>%</th>
                <th><?= round((($tota2 == 0 ? 0 : ($tota2/$tota1)) * ($tota11 == 0 ? 0 : $tota11/$tota10) * ($tota14 == 0 ? 0 : $tota14/($tota13 + $tota14)))* 100) ?>%</th>
            </tr>
        </tbody>
    </table>
</div>
<script type="text/javascript">
    function myformatter(date){
        var y = date.getFullYear();
        var m = date.getMonth()+1;
        var d = date.getDate();
        return y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d);
    }
    function myparser(s){
        if (!s) return new Date();
        var ss = (s.split('-'));
        var y = parseInt(ss[0],10);
        var m = parseInt(ss[1],10);
        var d = parseInt(ss[2],10);
        if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
            return new Date(y,m-1,d);
        } else {
            return new Date();
        }
    }
     function Filtrar(){
        var m = $('#maquina').combobox('getValue');
        var t = $('#turno').combobox('getValue');
        var ini = $('#fecha_ini').datebox('getValue');
        var fin = $('#fecha_fin').datebox('getValue');

        document.location = '/fimex/reportes/ete?IdTurno='+t+'&subProceso=<?= $_GET["subProceso"] ?>&ini='+ini+'&fin='+fin+'&maquina='+m;
    }    
</script>