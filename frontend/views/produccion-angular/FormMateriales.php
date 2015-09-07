<?php

use yii\helpers\Html;
use yii\helpers\URL;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\catalogos\Materiales;
use common\models\catalogos\Procesos;
use frontend\models\produccion\MaterialesVaciado;

$id = 'material';
$TM = new MaterialesVaciado();

echo Html::beginTag('div',['id'=>'tbMaterial']);

    echo Html::a('Agregar',"javascript:void(0)",[
        'id'=>'add',
        'class'=>"easyui-linkbutton",
        'data-options'=>"iconCls:'icon-add',plain:true",
        'onclick'=>"append('$id')"
    ]);
    echo Html::a('Actualizar',"javascript:void(0)",[
        'id'=>'refresh',
        'class'=>"easyui-linkbutton",
        'data-options'=>"iconCls:'icon-reload',plain:true",
        'onclick'=>"getChanges('$id')"
    ]);
echo Html::endTag('div');

$this->registerJS("
    $('#$id').datagrid({
        singleSelect:true,
        url:'/Fimex/produccion/material',
        queryParams:{
            produccion:'$model->IdProduccion'
        },
        method:'get',
        collapsible:false,
        remoteSort:false,
        multiSort:true,
        showFooter:true,
        loadMsg: 'Cargando datos',
        toolbar: '#tbMaterial',
        columns:[[
            {field:'IdMaterialVaciado',hidden:true,align:'center',editor:{type:'numberspinner',options:{precision:0}}},
            {field:'IdProduccion',hidden:true,align:'center',editor:{type:'numberspinner',options:{precision:0}}},
            {
                field:'IdMaterial',
                title:'Material',
                width:250,
                editor:{
                    type:'combobox',
                    options:{
                        url:'/Fimex/produccion/data_material?IdSubProceso=$subProceso',
                        method:'get',
                        valueField:'IdMaterial',
                        textField:'Descripcion',
                    }
                },
                formatter:function(value,row,index){
                    return row.Material;
                }
            },
            {field:'Cantidad',title:'Cantidad',width:80,align:'center',editor:{type:'numberspinner',options:{precision:2}}},
            {field:'action',title:'',width:80,align:'center',
                formatter:function(value,row,index){
                    if (row.editing){
                        return '<a href=\"#\" class=\"easyui-linkbutton\" onclick=\"saverow(this,\'$id\')\">Guardar</a>';
                    }else{
                        return '<a href=\"#\" class=\"easyui-linkbutton\" onclick=\"editrow(this,\'$id\')\">Editar</a>';
                    }
                }
            },
            {field:'action2',title:'',width:80,align:'center',
                formatter:function(value,row,index){
                    if (row.editing){
                        return '<a href=\"#\" class=\"easyui-linkbutton\" onclick=\"cancelrow(this,\'$id\')\">Cancelar</a>';
                    }else{
                        return '<a href=\"#\" class=\"easyui-linkbutton\" onclick=\"deleterow(this,\'$id\')\">Eliminar</a>';
                    }
                    
                }
            },
        ]],
        onBeforeEdit:function(index,row){
            row.editing = true;
            updateActions(index,'$id');
        },
        onAfterEdit:function(index,row){
            row.editing = false;
            updateActions(index,'$id');
        },
        onCancelEdit:function(index,row){
            row.editing = false;
            updateActions(index,'$id');
        },
    });
",$this::POS_END);
?>
<table id="<?=$id?>" style="height:50%" title="Material Agregados al Horno"></table>
