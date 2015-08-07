<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use\common\models\Grid;

$id2 = "Almas";

$this->registerJS("
    $('#$id2').datagrid({
        singleSelect:true,
        method:'post',
        remoteSort:false,
        multiSort:true,
        striped:true,

        url:'/fimex/productos/almas?id='+row.IdProductoCasting,
        loadMsg: 'Cargando datos',
        onLoadSuccess:function(data){
        },
        onClickRow: function(index,row){
            $('#rechazo').datagrid('load',{almas:row.IdProductoCasting});
        },
        onDblClickRow: function(index){onClickRow(index,'$id2')},
        toolbar: '#tbProduccion',
        columns:[[

            //{title:'Producto',field:'IdProducto',width:80,align:'center',editor:{type:'numberspinner'}},
            {
                title:'Tipo alma',
                field:'IdAlmaTipo',
                width:150,
                align:'center',
                editor:{
                    type:'combogrid',
                    options:{
                        url:'/fimex/productos/data_matrialcaja',
                        valueField:'IdAlmaTipo',
                        textField:'Descrfipcion',
                        panelWidth:200,
                        columns:[[

                            {field:'Descrfipcion',title:'Descripcion',width:100},
                        ]], 
                    }
                },
                formatter:function(value,row,index){
                    return row.IdAlmaTipo;
                },
            },
            {title:'Existencia',field:'Existencia',width:80,align:'center',editor:{type:'numberspinner'}},
            {title:'Piezas Molde',field:'PiezasMolde',width:120,align:'center',editor:{type:'numberspinner'}},
            {title:'Piezas Caja',field:'PiezasCaja',width:120,align:'center',editor:{type:'numberspinner'}},
            {title:'Peso',field:'Peso',width:80,align:'center',editor:{type:'numberspinner'}},
            {title:'Tiempo Llenado',field:'TiempoLlenado',width:120,align:'center',editor:{type:'numberspinner'}},
            {title:'Tiempo Fraguado',field:'TiempoFraguado',width:120,align:'center',editor:{type:'numberspinner'}},
            {title:'Tiempo Gaseo Directo',field:'TiempoGaseoDirectro',width:150,align:'center',editor:{type:'numberspinner'}},
            {title:'Tiempo Gaseo Indirecto',field:'TiempoGaseoIndirecto',width:160,align:'center',editor:{type:'numberspinner'}},

            {field:'action',title:'',width:80,align:'center',
                formatter:function(value,row,index){
                    if (row.editing){
                        return '<a href=\"#\" class=\"easyui-linkbutton\" onclick=\"saverow(this,\'$id2\')\">Guardar</a>';
                    }else{
                        return '<a href=\"#\" class=\"easyui-linkbutton\" onclick=\"editrow(this,\'$id2\')\">Editar</a>';
                    }
                }
            },
            {field:'action2',title:'',width:80,align:'center',
                formatter:function(value,row,index){
                    if (row.editing){
                        return '<a href=\"#\" class=\"easyui-linkbutton\" onclick=\"cancelrow(this,\'$id2\')\">Cancelar</a>';
                    }else{
                        return '<a href=\"#\" class=\"easyui-linkbutton\" onclick=\"deleterow(this,\'$id2\')\">Eliminar</a>';
                    }

                }
            },
        ]],
        onBeforeEdit:function(index,row){
            row.editing = true;
            updateActions(index,'$id2');
        },
        onAfterEdit:function(index,row){
            row.editing = false;
            updateActions(index,'$id2');
        },
        onCancelEdit:function(index,row){
            row.editing = false;
            updateActions(index,'$id2');
        },

    });
",$this::POS_END);
?>

<table id="<?=$id2?>" style='height:50%' class="easyui-datagrid datagrid-f" title="Almas" ></table>