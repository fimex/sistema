<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use\common\models\Grid;

$id = "detalle";

echo Html::beginTag('div',['id'=>'tbProduccion']);

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
        striped:false,
        queryParams:{
            IdSubProceso:$subProceso,
            Dia:$('#fecha').val(),
        },
        url:'/fimex/produccion/detalle2',
        loadMsg: 'Cargando datos',
        onLoadSuccess:function(data){
        },
        onClickRow: function(index,row){
            //gridIndex['$id']=index
            //onClickRow(index,'$id')
            $('#rechazo').datagrid('load',{detalle:row.IdProduccionDetalle});
        },
        onDblClickRow: function(index){onClickRow(index,'$id')},
        toolbar: '#tbProduccion',
        columns:[[
            {title:'IdProgramacion',field:'IdProgramacion',hidden:true},
            {title:'IdProgramacionSemana',field:'IdProgramacionSemana',hidden:true},
            {title:'IdProgramacionDia',field:'IdProgramacionDia',hidden:true},
            {title:'IdPedido',field:'IdPedido',width:80,align:'center',hidden:true},
            {title:'IdArea',field:'IdArea',width:80,align:'center',hidden:true},
            {title:'Producto',field:'Producto',width:80,align:'center'},
            {title:'Pzas X Molde',field:'PiezasMolde',width:80,align:'center'},
            {title:'Ciclos',field:'ciclos',width:80,align:'center',
                formatter:function(value,row,index){
                    return (row.hechasProduccion) / 2;
                },
            },
            {title:'Hechas',field:'hechasProduccion',width:80,align:'center'},
            /*{field:'action',title:'',width:20,align:'center',
                formatter:function(value,row,index){
                    return '<a href=\"#\" style=\"font-size:x-large;color:green;\" onclick=\"addrow(this,\'$id\')\">-</a>';
                },
                styler: function(value,row,index){
                    return 'background-color:#dddddd';
                }
            },*/
            {field:'action2',title:'',width:20,align:'center',
                formatter:function(value,row,index){
                    return '<a href=\"#\" style=\"font-size:x-large;color:green;\" onclick=\"addrow(this,\'$id\')\">+</a>';
                },
                styler: function(value,row,index){
                    return 'background-color:#dddddd';
                }
            },
            {title:'RECH',field:'rechazadasProduccion',width:80,align:'center'},
            /*{field:'action3',title:'',width:20,align:'center',
                formatter:function(value,row,index){
                    return '<a href=\"#\" style=\"font-size:x-large;color:red;\" onclick=\"addrow(this,\'rechazo\')\">-</a>';
                },
                styler: function(value,row,index){
                    return 'background-color:#dddddd';
                }
            },*/
            {field:'action4',title:'',width:20,align:'center',
                formatter:function(value,row,index){
                    return '<a href=\"#\" style=\"font-size:x-large;color:red;\" onclick=\"addrow(this,\'rechazo\')\">+</a>';
                },
                styler: function(value,row,index){
                    return 'background-color:#dddddd';
                }
            },
            {title:'OK',field:'Total',width:100,align:'center',
                formatter:function(value,row,index){
                    return row.hechasProduccion - row.rechazadasProduccion;
                },
                styler: function(value,row,index){
                    return 'background-color:#dddddd';
                }
            },
            {title:'Programadas',field:'programadasDia',width:100,align:'center',
                styler: function(value,row,index){
                    return 'background-color:#dddddd';
                }
            },
            {field:'restante',title:'Faltan',width:100,align:'center',
                formatter:function(value,row,index){
                    return row.programadasDia - (row.hechasProduccion - row.rechazadasProduccion);
                },
                styler: function(value,row,index){
                    return 'background-color:#dddddd';
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

<table id="<?=$id?>" style='height:50%' class="easyui-datagrid datagrid-f" title="Registro de Produccion" ></table>