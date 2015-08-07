<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\URL;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\programacion\ProgramacionesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$columns['Producto'] = [
    'label'=>'Producto',
    'data-options'=>['width'=>80,'align'=>'center','editor'=>['type'=>'numberspinner','options'=>['precision'=>0]]]
];
$columns['Prioridad']=[
    'label'=>'Pr',
    'data-options'=>['width'=>80,'align'=>'center','editor'=>['type'=>'numberspinner','options'=>['precision'=>0]]]
];
$columns['Programadas']=[
    'label'=>'P',
    'data-options'=>['width'=>80,'align'=>'center']
];
$columns['Hechas']=[
    'label'=>'H',
    'data-options'=>['width'=>80,'align'=>'center']
];


$id = 'programacion';
?>
<table id="<?= $id ?>" class="easyui-datagrid datagrid-f" title="" style="height:600px" data-options="
    url:'/Fimex/existencias/existencia?almacen=<?=$almacen?>',
    singleSelect:false,
    method:'get',
    collapsible:true,
    remoteSort:false,
    multiSort:true,
    loadMsg: 'Cargando datos',
">
    <thead>
        <tr>
            <th data-options="field:'Producto'">Producto</th>
            <th data-options="field:'Existencia',formatter:function(value){return parseInt(value)*1;}">Existencia</th>
        </tr>
    </thead>
</table>