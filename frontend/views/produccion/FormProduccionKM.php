<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use\common\models\Grid;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

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
        url:'/Fimex/produccion/detalle2',
        loadMsg: 'Cargando datos',
        onLoadSuccess:function(data){
        },
        /*onClickRow: function(index,row){
            //gridIndex['$id']=index
            //addCiclos(index,$subProceso)
            //$('#rechazo').datagrid('load',{detalle:row.IdProduccionDetalle});
        },*/
        onDblClickRow: function(index){onClickRow(index,'$id')},
        toolbar: '#tbProduccion',
        columns:[[
            {title:'mmm',field:''},
            ]],
        columns:[[
            {title:'IdProgramacion',field:'IdProgramacion',hidden:true},
            {title:'IdProgramacionSemana',field:'IdProgramacionSemana',hidden:true},
            {title:'IdProgramacionDia',field:'IdProgramacionDia',hidden:true},
            {title:'IdPedido',field:'IdPedido',width:80,align:'center',hidden:true},
            {title:'IdArea',field:'IdArea',width:80,align:'center',hidden:true},
            {title:'Pr',field:'prioridadSemana',width:50,align:'center'},
            {title:'Producto',field:'Producto',width:80,align:'center'},
            {title:'Aleacion',field:'Aleacion',width:80,align:'center'},
            {title:'Ciclos',field:'ciclos',width:80,align:'center',
                formatter:function(value,row,index){
                    return (row.hechasProduccion) / 2;
                },
            },
            //{title:'Pzas X Molde',field:'PiezasMolde',width:80,align:'center'},
            {title:'Prg',field:'Programadas',width:100,align:'center',
                styler: function(value,row,index){
                    return 'background-color:#dddddd';
                }
            },
            {title:'CIC OK',field:'OkCic',width:80,align:'center'},
            /*{field:'action',title:'',width:20,align:'center',
                formatter:function(value,row,index){
                    return '<a href=\"#\" style=\"font-size:x-large;color:green;\" onclick=\"addC(this,\'$id\')\">-</a>';
                },
                styler: function(value,row,index){
                    return 'background-color:#dddddd';
                }
            },*/
            {field:'action2',title:'',width:20,align:'center',
                formatter:function(value,row,index){
                    return '<a href=\"#\" style=\"font-size:x-large;color:green;\" onclick=\"addC(this,\'$id\')\">+</a>';
                },
                styler: function(value,row,index){
                    return 'background-color:#dddddd';
                }
            },
            {title:'CIC RECH',field:'rechazadasProduccion',width:80,align:'center'},
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
            /*{title:'OK',field:'Total',width:100,align:'center',
                formatter:function(value,row,index){
                    return row.hechasProduccion - row.rechazadasProduccion;
                },
                styler: function(value,row,index){
                    return 'background-color:#dddddd';
                }
            },*/
            
            /*{field:'restante',title:'Faltan',width:100,align:'center',
                formatter:function(value,row,index){
                    return row.programadasDia - (row.hechasProduccion - row.rechazadasProduccion);
                },
                styler: function(value,row,index){
                    return 'background-color:#dddddd';
                }
            },*/
            {title:'M LLenados',field:'',width:80,align:'center'},
            {title:'M Cerrados',field:'',width:80,align:'center'},
            
            {field:'action4',title:'',width:20,align:'center',
                formatter:function(value,row,index){
                    return '<a href=\"#\" style=\"font-size:x-large;color:green;\" onclick=\"addrow(this,\'rechazo\')\">+/-</a>';
                },
                styler: function(value,row,index){
                    return 'background-color:#dddddd';
                }
            },
            
            {title:'V OK',field:'',width:80,align:'center'},
            {title:'V Rech',field:'',width:80,align:'center'},
            
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

<div id="d" style="display: none" >
    <div id="dlg" class="easyui-dialog" title="Toolbar and Buttons" style="width:500px;height:370px;padding:10px;">
        
        <form id="fm" method="post" novalidate enctype="multipart/form-data">
            <div style="font-size:19px;margin-bottom: 15px" >No. Parte <label><input style="border:0;" name="Producto" required="true"></label> </div>
            <table width="370" border="0" >
                <tr>
                    <td height="150" valign="top" >
                        <input type="radio" name="parte_molde" value="cabeza" class="easyui-validatebox" checked="checked" /> Cabeza<br>
                        <input type="radio" name="parte_molde" value="c1" class="easyui-validatebox" /> C1 <br>
                        <input type="radio" name="parte_molde" value="c2" class="easyui-validatebox" /> C2 <br>
                        <input type="radio" name="parte_molde" value="c3" class="easyui-validatebox" /> C3 <br>
                        <input type="radio" name="parte_molde" value="c4" class="easyui-validatebox" /> C4 <br>
                    </td>
                    <td width="40" ></td>
                    <td valign="top" >
                        <div class="fitem">
                            <label>Serie:</label>
                            <input name="Serie" id="Serie" class="easyui-validatebox" required="true">
                        </div>
                        <div style="margin-top:35px" class="fitem">
                            <label>Comentarios:</label><br>
                            <textarea cols="35" rows="5" id="comentario" name="comentario" required="true"></textarea>
                        </div>
                    </td>
                </tr>
                <tr><td colspan="3" height="20" ></td></tr>
                <tr >
                    <td><div><input type="radio" name="opcion" value="1" class="easyui-validatebox" checked="checked" /> Agregar<br></div></td>
                    <td width="75" > <div><input type="radio" name="opcion" value="2" class="easyui-validatebox" /> Eliminar <br></div></td>
                    <td><div style="margin-left:30px"  ><a href="#" class="easyui-linkbutton" onclick="addCimolde();" >Aceptar</a></div></td>
                </tr>
            </table>
            
            <input type="hidden" name="Producto" class="easyui-validatebox" required="true">
            <input type="hidden" id="IdProducto" name="IdProducto" class="easyui-validatebox" required="true">
            <input type="hidden" id="IdTurno" name="IdTurno" class="easyui-validatebox" required="true">
        </form>
        
    </div>
</div>
<table id="<?=$id?>" style='height:50%' class="easyui-datagrid datagrid-f" title="Registro de Produccion"></table>

