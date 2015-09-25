<?php
use yii\helpers\Html;
use yii\helpers\URL;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */ 

if (isset($_GET['semana'])){
    $semana = $_GET['semana'];
    $semana2 = explode('-W',$_GET['semana']);
    $semanas = $semana2[1];
}  else {
    $semana = date("Y")."-W".date("W");
    $semanas = date("W");
}
$cantidad = isset($_GET['cantidad']) ? $_GET['cantidad'] : 4;
?>

<div style="margin-bottom: 10px">
    <input id="semana" type="week" value="<?= $semana ?>">
    <label>Semanas</label>
    <input id="cantidadS" class="easyui-textbox" style="width:80px">
    
    <a href="#" class="easyui-linkbutton" onclick="filtrar(this);" >Filtrar</a>
</div>

<div class="reporte-ete">
    <table style="width:100%" id="ff" class="table table-striped">
        <thead>
            <tr>
                <th>Aleacion</th>
                <?php for ($i = 0; $i < $cantidad; $i++):?>
                    <?php $sem = $semanas + $i;?>
                    <?php $totalSemana[$sem] = 0;?>
                    <th>Sem <?=$sem?></th>'
                <?php endfor;?>
                <th>Total Araña</th>
            </tr>
        </thead>
        <tbody>
            <?php $total = 0;?>
            <?php foreach($model as $detail): ?>
            <tr>
                <th><?= $detail['Aleacion'] ?> </th>
                <?php $PesoTot = 0;?>
                <?php for ($i = 0; $i < $cantidad; $i++):?>
                    <?php $sem = $semanas + $i;?>
                    <?php $detail[$sem] = round($detail[$sem],2);?>
                    <?php $totalSemana[$sem] += $detail[$sem];?>
                    <?php $PesoTot += $detail[$sem];?>
                <th><?= $detail[$sem]?></th>
                <?php endfor;?>
                <?php $total += $PesoTot; ?>
                <th><?=$PesoTot?></th>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th>Total</th>
                <?php for ($i = 0; $i < $cantidad; $i++):?>
                    <?php $sem = $semanas + $i;?>
                    <th><?= $totalSemana[$sem]?></th>
                <?php endfor;?>
                <th><?=$total?> </th>  
            </tr>
        </tfoot>
    </table>
</div>

<div class="reporte-ete">
    <table style="width:100%" id="ff" class="table table-striped">
        <thead>
            <tr>
                <th>Aleacion</th>
                <?php for ($i = 0; $i < $cantidad; $i++):?>
                    <?php $sem = $semanas + $i;?>
                    <?php $totalSemana[$sem] = 0;?>
                    <th>Sem <?=$sem?></th>
                <?php endfor;?>
                <th>Total Casting</th>
            </tr>
        </thead>
        <tbody>
            <?php $total = 0;?>
            <?php foreach($model2 as $detail2): ?>
            <tr>
                <th><?= $detail2['Aleacion'] ?> </th>
                <?php $PesoTot = 0;?>
                <?php for ($i = 0; $i < $cantidad; $i++):?>
                    <?php $sem = $semanas + $i;?>
                    <?php $detail2[$sem] = round($detail2[$sem],2);?>
                <?php $totalSemana[$sem] += $detail2[$sem];?>
                    <?php $PesoTot += $detail2[$sem];?>
                <th><?= $detail2[$sem]?></th>
                <?php endfor;?>
                <?php $total += $PesoTot; ?>
                <th><?=$PesoTot?></th>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th>Total</th>
                <?php for ($i = 0; $i < $cantidad; $i++):?>
                    <?php $sem = $semanas + $i;?>
                    <th><?= $totalSemana[$sem]?></th>
                <?php endfor;?>
                <th><?=$total?> </th>  
            </tr>
        </tfoot>
    </table>

</div>

<script>
    function filtrar(){
        var cantidad = $('#cantidadS').textbox('getValue');	// get datebox value
        var semana = $('#semana').val();	// get datebox value
        //var anio = $('#anio').val();    
        document.location = '/fimex/reportes/material?cantidad='+cantidad+'&semana='+semana;
    }   
</script>

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
</script>