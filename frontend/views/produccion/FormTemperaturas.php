<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use\common\models\Grid;

$id = "temperaturas";

echo Html::beginTag('div',['id'=>'tbTemperaturas']);

    echo Html::a('Agregar',"javascript:void(0)",[
        'id'=>'add',
        'class'=>"easyui-linkbutton",
        'data-options'=>"iconCls:'icon-add',plain:true",
        'onclick'=>"append('$id')"
    ]);
    Html::a('Guardar',"javascript:void(0)",[
        'id'=>'save',
        'class'=>"easyui-linkbutton",
        'data-options'=>"iconCls:'icon-save',plain:true",
        'onclick'=>"accept('$id')"
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
        method:'get',
        remoteSort:false,
        multiSort:true,
        striped:true,
        queryParams:{
            produccion:$('#IdProduccion').val(),
        },
        url:'/Fimex/produccion/temperatura',
        loadMsg: 'Cargando datos',
        onLoadSuccess:function(data){
        },
        onDblClickRow: function(index){onClickRow(index,'$id')},
        toolbar: '#tbTemperaturas',
        columns:[[
            {title:'IdTemperatura',field:'IdTemperatura',hidden:true,editor:{type:'textbox'}},
            {title:'IdProduccion',field:'IdProduccion',hidden:true,editor:{type:'textbox'}},
            {title:'IdMaquina',field:'IdMaquina',editor:{type:'combobox',options:{
                url:'/Fimex/programacion/data_maquina?subProceso=$subProceso',
                valueField:'IdMaquina',
                textField:'Identificador',
                panelWidth:265,
                queryParams:{
                    proceso:2
                }
            }}},
            {title:'Fecha',field:'Fecha',hidden:true,align:'center',editor:{type:'timespinner'}},
            {title:'Temperatura',field:'Temperatura',width:80,align:'center',editor:{type:'numberspinner'}},
            {title:'Temperatura2',field:'Temperatura2',width:80,align:'center',editor:{type:'numberspinner'}},
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

<table id="<?=$id?>" style='height:50%' class="easyui-datagrid datagrid-f" title="Registro de Temperaturas" ></table>