<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\models\Grid;
use yii\helpers\URL;

//var_dump($model->getMarcas());exit;
$id = 'productos';
$id2 = "Almas";
$id3 = "Filtros";
$id4 = "Camisas";
$id5 = "Cajas";


echo Html::beginTag('div',['id'=>'tbProductos']);
   echo "Seleccionar Cliente:".Html::activeDropDownList($model, 'IdMarca', ArrayHelper::map($marcas,'IdMarca','Marca'));
    echo Html::a('Actualizar',"javascript:void(0)",[
        'class'=>"easyui-linkbutton",
        'data-options'=>"iconCls:'icon-reload',plain:true",
        'onclick'=>"getChanges('#$id')"
    ]);
    
echo Html::endTag('div');


$grid = new Grid([
    'id'=>$id,
    'style'=>'width:100%;height:200px',
    'onClickRow'=> "
        function (index,row){

            $('#Moldeo').load('/fimex/productos/moldeo?id='+row.IdProducto+'&area=$area'); 
            $('#Series').load('/fimex/productos/series?id='+row.IdProducto+'&area=$area'); 

            $('#$id2').datagrid({
                singleSelect:true,
                method:'post',
                remoteSort:false,
                multiSort:true,
                striped:true,
               
                url:'/fimex/productos/almas?id='+row.IdProducto,
                loadMsg: 'Cargando datos',
                onLoadSuccess:function(data){
                },
                onDblClickRow: function(index){onClickRow(index,'$id2')},
                toolbar: '#tbAlmas',
                
                columns:[[
                    {title:'IdProducto',field:'IdProducto',hidden:true,editor:{type:'textbox'}},
                    {
                        title:'Tipo alma',
                        field:'IdAlmaTipo',
                        width:150,
                        align:'center',
                        editor:{
                            type:'combobox',
                            options:{
                                url:'/fimex/productos/data_tipos?id=almas',
                                valueField:'IdAlmaTipo',
                                textField:'Descripcion',
                                panelWidth:200,
                            }
                        },
                        formatter:function(value,row,index){
                            return row.DescripTipo;
                        },
                    },
                    {
                        title:'Material Caja',
                        field:'IdAlmaMaterialCaja',
                        width:150,
                        align:'center',
                        editor:{
                            type:'combobox',
                            options:{
                                url:'/fimex/productos/data_tipos?id=materialcaja',
                                valueField:'IdAlmaMaterialCaja',
                                textField:'Descripcion',
                                panelWidth:200,
                            }
                        },
                        formatter:function(value,row,index){
                            return row.DescripMaterial;
                        },
                    },
                    {
                        title:'Alma Receta',
                        field:'IdAlmaReceta',
                        width:150,
                        align:'center',
                        editor:{
                            type:'combobox',
                            options:{
                                url:'/fimex/productos/data_tipos?id=receta',
                                valueField:'IdAlmaReceta',
                                textField:'Descripcion',
                                panelWidth:200,
                    
                            }
                        },
                        formatter:function(value,row,index){
                            return row.DescripReceta;
                        },
                    },
                    {title:'Existencia',field:'Existencia',width:80,align:'center',editor:{type:'numberspinner'}},
                    {title:'Piezas Molde',field:'PiezasMolde',width:120,align:'center',editor:{type:'numberspinner'}},
                    {title:'Piezas Caja',field:'PiezasCaja',width:120,align:'center',editor:{type:'numberspinner'}},
                    {title:'Peso',field:'Peso',width:80,align:'center',editor:{type:'numberspinner'}},
                    {title:'Tiempo Llenado',field:'TiempoLlenado',width:120,align:'center',editor:{type:'numberspinner'}},
                    {title:'Tiempo Fraguado',field:'TiempoFraguado',width:120,align:'center',editor:{type:'numberspinner'}},
                    {title:'Tiempo Gaseo Directo',field:'TiempoGaseoDirecto',width:150,align:'center',editor:{type:'numberspinner'}},
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
            
            $('#$id3').datagrid({
                singleSelect:true,
                method:'post',
                remoteSort:false,
                multiSort:true,
                striped:true,
               
                url:'/fimex/productos/filtros?id='+row.IdProducto,
                loadMsg: 'Cargando datos',
                onLoadSuccess:function(data){
                },
                onDblClickRow: function(index){onClickRow(index,'$id3')},
                toolbar: '#tbFiltros',
                columns:[[
                    {title:'IdProducto',field:'IdProducto',hidden:true,editor:{type:'textbox'}},
                    {
                        title:'Tipo Filtro',
                        field:'IdFiltroTipo',
                        width:150,
                        align:'center',
                        editor:{
                            type:'combobox',
                            options:{
                                url:'/fimex/productos/data_tipos?id=filtro',
                                valueField:'IdFiltroTipo',
                                textField:'Descripcion',
                                panelWidth:200,
                                method:'get',                               
                            }
                        },
                        formatter:function(value,row,index){
                            return row.Descripcion;
                        },
                    },
                  //  {title:'Tipo Filtro',field:'IdFiltroTipo',width:80,align:'center',editor:{type:'numberspinner'}},
                    {title:'Cantidad',field:'Cantidad',width:120,align:'center',editor:{type:'numberspinner'}},
                    
                    {field:'action',title:'',width:80,align:'center',
                        formatter:function(value,row,index){
                            if (row.editing){
                                return '<a href=\"#\" class=\"easyui-linkbutton\" onclick=\"saverow(this,\'$id3\')\">Guardar</a>';
                            }else{
                                return '<a href=\"#\" class=\"easyui-linkbutton\" onclick=\"editrow(this,\'$id3\')\">Editar</a>';
                            }
                        }
                    },
                    {field:'action2',title:'',width:80,align:'center',
                        formatter:function(value,row,index){
                            if (row.editing){
                                return '<a href=\"#\" class=\"easyui-linkbutton\" onclick=\"cancelrow(this,\'$id3\')\">Cancelar</a>';
                            }else{
                                return '<a href=\"#\" class=\"easyui-linkbutton\" onclick=\"deleterow(this,\'$id3\')\">Eliminar</a>';
                            }

                        }
                    },
                ]],
                onBeforeEdit:function(index,row){
                    row.editing = true;
                    updateActions(index,'$id3');
                },
                onAfterEdit:function(index,row){
                    row.editing = false;
                    updateActions(index,'$id3');
                },
                onCancelEdit:function(index,row){
                    row.editing = false;
                    updateActions(index,'$id3');
                },
                
            });
            

            $('#$id4').datagrid({
                singleSelect:true,
                method:'post',
                remoteSort:false,
                multiSort:true,
                striped:true,
               
                url:'/fimex/productos/camisas?id='+row.IdProducto,
                loadMsg: 'Cargando datos',
                onLoadSuccess:function(data){
                },
                onDblClickRow: function(index){onClickRow(index,'$id4')},
                toolbar: '#tbCamisas',
                columns:[[
                    {title:'IdProducto',field:'IdProducto',hidden:true,editor:{type:'textbox'}},
                    {
                        title:'Tipo de Camisa',
                        field:'IdCamisaTipo',
                        width:150,
                        align:'center',
                        editor:{
                            type:'combobox',
                            options:{
                                url:'/fimex/productos/data_tipos?id=camisa',
                                valueField:'IdCamisaTipo',
                                textField:'Descripcion',
                                panelWidth:200,
                            }
                        },
                        formatter:function(value,row,index){
                            return row.Descripcion;
                        },
                    },
                   //{title:'Tipo Camisa',field:'IdCamisaTipo',width:80,align:'center',editor:{type:'numberspinner'}},
                    {title:'Cantidad',field:'Cantidad',width:120,align:'center',editor:{type:'numberspinner'}},
                    
                    {field:'action',title:'',width:80,align:'center',
                        formatter:function(value,row,index){
                            if (row.editing){
                                return '<a href=\"#\" class=\"easyui-linkbutton\" onclick=\"saverow(this,\'$id4\')\">Guardar</a>';
                            }else{
                                return '<a href=\"#\" class=\"easyui-linkbutton\" onclick=\"editrow(this,\'$id4\')\">Editar</a>';
                            }
                        }
                    },
                    {field:'action2',title:'',width:80,align:'center',
                        formatter:function(value,row,index){
                            if (row.editing){
                                return '<a href=\"#\" class=\"easyui-linkbutton\" onclick=\"cancelrow(this,\'$id4\')\">Cancelar</a>';
                            }else{
                                return '<a href=\"#\" class=\"easyui-linkbutton\" onclick=\"deleterow(this,\'$id4\')\">Eliminar</a>';
                            }

                        }
                    },
                ]],
                onBeforeEdit:function(index,row){
                    row.editing = true;
                    updateActions(index,'$id4');
                },
                onAfterEdit:function(index,row){
                    row.editing = false;
                    updateActions(index,'$id4');
                },
                onCancelEdit:function(index,row){
                    row.editing = false;
                    updateActions(index,'$id4');
                },
                
            });
            

            $('#$id5').datagrid({
                singleSelect:true,
                method:'post',
                remoteSort:false,
                multiSort:true,
                striped:true,
               
                url:'/fimex/productos/cajas?id='+row.IdProducto,
                loadMsg: 'Cargando datos',
                onLoadSuccess:function(data){
                },
                onDblClickRow: function(index){onClickRow(index,'$id5')},
                toolbar: '#tbCajas',
                columns:[[
                    {title:'IdProducto',field:'IdProducto',hidden:true,editor:{type:'textbox'}},
                    {
                        title:'Tipo Caca',
                        field:'IdTipoCaja',
                        width:180,
                        align:'center',
                        editor:{
                            type:'combobox',
                            options:{
                                url:'/fimex/productos/data_tipos?id=cajas',
                                valueField:'IdTipoCaja',
                                textField:'Tamano',
                                panelWidth:200,
                                method:'get',                               
                            }
                        },
                        formatter:function(value,row,index){
                            return row.Tamano;
                        },
                    },
                    {title:'Cajas',field:'PiezasXCaja',width:120,align:'center',editor:{type:'numberspinner'}},
                   //{title:'Cajas',field:'Cajas',width:120,align:'center'},
                    
                    {field:'action',title:'',width:80,align:'center',
                        formatter:function(value,row,index){
                            if (row.editing){
                                return '<a href=\"#\" class=\"easyui-linkbutton\" onclick=\"saverow(this,\'$id5\')\">Guardar</a>';
                            }else{
                                return '<a href=\"#\" class=\"easyui-linkbutton\" onclick=\"editrow(this,\'$id5\')\">Editar</a>';
                            }
                        }
                    },
                    {field:'action2',title:'',width:80,align:'center',
                        formatter:function(value,row,index){
                            if (row.editing){
                                return '<a href=\"#\" class=\"easyui-linkbutton\" onclick=\"cancelrow(this,\'$id5\')\">Cancelar</a>';
                            }else{
                                return '<a href=\"#\" class=\"easyui-linkbutton\" onclick=\"deleterow(this,\'$id5\')\">Eliminar</a>';
                            }

                        }
                    },
                ]],
                onBeforeEdit:function(index,row){
                    row.editing = true;
                    updateActions(index,'$id5');
                },
                onAfterEdit:function(index,row){
                    row.editing = false;
                    updateActions(index,'$id5');
                },
                onCancelEdit:function(index,row){
                    row.editing = false;
                    updateActions(index,'$id5');
                },
                
            });
            
    
        }
    ",
    
    'toolbar'=> "'#tbProductos'",
    'dataOptions' => [
        
        'url'=> '/fimex/productos/data_productos',
        'singleSelect'=> true,
        'method'=> 'post',
        'remoteSort'=>false,
        'multiSort'=>true,
    ],
    'columns' => [
        [
            'IdProducto'=>[
                'label'=>'IdProducto',
                'data-options'=>[]
            ],
            'Identificacion'=>[
                'label'=>'Producto',
                'data-options'=>[]
            ],
            'ProductoCasting'=>[
                'label'=>'Casting',
                'data-options'=>[]
            ],
            'Descripcion'=>[
                'label'=>'Descripcion',
                'data-options'=>[]
            ],
            'ProductoCasting'=>[
                'label'=>'Casting',
                'data-options'=>[]
            ],
            'Aleacion'=>[
                'data-options'=>[]
            ]
        ]
    ]
]);

$grid->display();
$this->registerJS("
    $('#vmarcas-idmarca').change(function(){
        $('#$id').datagrid('load',{
            marca:$(this).val(),
            area:$area
        });
        $('#$id').datagrid('enableFilter');
    });
");

$this->registerJS("
    $.extend($.fn.datagrid.defaults.editors, {
        combogrid: {
            init: function(container, options){
                var input = $('<input type=\"text\" class=\"datagrid-editable-input\">').appendTo(container);
                input.combogrid(options);
                return input;
            },
            destroy: function(target){
                $(target).combogrid('destroy');
            },
            getValue: function(target){
                return $(target).combogrid('getValue');
            },
            setValue: function(target, value){
                $(target).combogrid('setValue', value);
            },
            resize: function(target, width){
                $(target).combogrid('resize',width);
            }
        },
    });
    var Productos = undefined;
    var gridIndex = {
        Almas:undefined,
        Filtros:undefined,
        Camisas:undefined,
        Cajas:undefined,
    };

    $('#$id2').datagrid({
        singleSelect:true,
        method:'get',
        remoteSort:false,
        multiSort:true,
        striped:true,
        url:'/fimex/productos/almas',
        loadMsg: 'Cargando datos',
        onLoadSuccess:function(data){
        },
        onClickRow: function(index,row){
            $('#rechazo').datagrid('load',{almas:row.IdProducto});
        },
        onDblClickRow: function(index){onClickRow(index,'$id2')},
        toolbar: '#tbAlmas',
        columns:[[
            {title:'IdProducto',field:'IdProducto',hidden:true,editor:{type:'textbox'}},
            {
                title:'Tipo alma',
                field:'IdAlmaTipo',
                width:150,
                align:'center',
                editor:{
                    type:'combogrid',
                    options:{
                        url:'/fimex/productos/data_tipos?id=almas',
                        valueField:'IdAlmaTipo',
                        textField:'Descrfipcion',
                        panelWidth:200,
                        columns:[[

                            {field:'Descrfipcion',title:'Descripcion',width:100},
                        ]],
                    }
                },
                formatter:function(value,row,index){
                    return row.DescripTipo;
                },
            },
            {
                title:'Material Caja',
                field:'IdAlmaMaterialCaja',
                width:150,
                align:'center',
                editor:{
                    type:'combogrid',
                    options:{
                        url:'/fimex/productos/data_tipos?id=materialcaja',
                        valueField:'IdAlmaMaterialCaja',
                        textField:'Dscripcion',
                        panelWidth:200,
                        columns:[[

                            {field:'Dscripcion',title:'Descripcion',width:100},
                        ]],
                    }
                },
                formatter:function(value,row,index){
                    return row.DescripMaterial;
                },
            },
            {
                title:'Alma Receta',
                field:'IdAlmaReceta',
                width:150,
                align:'center',
                editor:{
                    type:'combogrid',
                    options:{
                        url:'/fimex/productos/data_tipos?id=receta',
                        valueField:'IdAlmaReceta',
                        textField:'Descripcion',
                        panelWidth:200,
                        columns:[[

                            {field:'Descripcion',title:'Descripcion',width:100},
                        ]],
                    }
                },
                formatter:function(value,row,index){
                    return row.DescripReceta;
                },
            },
            {title:'Existencia',field:'Existencia',width:80,align:'center',editor:{type:'numberspinner'}},
            {title:'Piezas Molde',field:'PiezasMolde',width:120,align:'center',editor:{type:'numberspinner'}},
            {title:'Piezas Caja',field:'PiezasCaja',width:120,align:'center',editor:{type:'numberspinner'}},
            {title:'Peso',field:'Peso',width:80,align:'center',editor:{type:'numberspinner'}},
            {title:'Tiempo Llenado',field:'TiempoLlenado',width:120,align:'center',editor:{type:'numberspinner'}},
            {title:'Tiempo Fraguado',field:'TiempoFraguado',width:120,align:'center',editor:{type:'numberspinner'}},
            {title:'Tiempo Gaseo Directo',field:'TiempoGaseoDirecto',width:150,align:'center',editor:{type:'numberspinner'}},
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

    $('#$id3').datagrid({
        singleSelect:true,
        method:'get',
        remoteSort:false,
        multiSort:true,
        striped:true,

        url:'/fimex/productos/filtros',
        loadMsg: 'Cargando datos',
        onLoadSuccess:function(data){
        },
        onClickRow: function(index,row){
            $('#rechazo').datagrid('load',{almas:row.IdProducto});
        },
        onDblClickRow: function(index){onClickRow(index,'$id3')},
        toolbar: '#tbFiltros',
        columns:[[
            {title:'IdProducto',field:'IdProducto',hidden:true,editor:{type:'textbox'}},
            {
                title:'Tipo Filtro',
                field:'IdFiltroTipo',
                width:150,
                align:'center',
                editor:{
                    type:'combogrid',
                    options:{
                        url:'/fimex/productos/data_tipos?id=filtro',
                        valueField:'IdFiltroTipo',
                        textField:'Descripcion',
                        panelWidth:200,
                        columns:[[

                            {field:'Descripcion',title:'Descripcion',width:100},
                        ]],
                        onSelect:function(record){

                            var ed = $('#$id3').datagrid('getEditor', {index:gridIndex['$id3'],field:'IdFiltroTipo'}).target;

                            Productos = $(ed).combogrid('grid').datagrid('getSelected');

                            $('#$id3').datagrid('getRows')[gridIndex['$id3']]['IdFiltroTipo'] = Productos.IdFiltroTipo;


                        },
                    }
                },
                formatter:function(value,row,index){
                    return row.IdFiltroTipo;
                },
            },
          //  {title:'Tipo Filtro',field:'IdFiltroTipo',width:80,align:'center',editor:{type:'numberspinner'}},
            {title:'Cantidad',field:'Cantidad',width:120,align:'center',editor:{type:'numberspinner'}},

            {field:'action',title:'',width:80,align:'center',
                formatter:function(value,row,index){
                    if (row.editing){
                        return '<a href=\"#\" class=\"easyui-linkbutton\" onclick=\"saverow(this,\'$id3\')\">Guardar</a>';
                    }else{
                        return '<a href=\"#\" class=\"easyui-linkbutton\" onclick=\"editrow(this,\'$id3\')\">Editar</a>';
                    }
                }
            },
            {field:'action2',title:'',width:80,align:'center',
                formatter:function(value,row,index){
                    if (row.editing){
                        return '<a href=\"#\" class=\"easyui-linkbutton\" onclick=\"cancelrow(this,\'$id3\')\">Cancelar</a>';
                    }else{
                        return '<a href=\"#\" class=\"easyui-linkbutton\" onclick=\"deleterow(this,\'$id3\')\">Eliminar</a>';
                    }

                }
            },
        ]],
        onBeforeEdit:function(index,row){
            row.editing = true;
            updateActions(index,'$id3');
        },
        onAfterEdit:function(index,row){
            row.editing = false;
            updateActions(index,'$id3');
        },
        onCancelEdit:function(index,row){
            row.editing = false;
            updateActions(index,'$id3');
        },

    });


    $('#$id4').datagrid({
        singleSelect:true,
        method:'get',
        remoteSort:false,
        multiSort:true,
        striped:true,

        url:'/fimex/productos/camisas',
        loadMsg: 'Cargando datos',
        onLoadSuccess:function(data){
        },
        onClickRow: function(index,row){
            $('#rechazo').datagrid('load',{almas:row.IdProducto});
        },
        onDblClickRow: function(index){onClickRow(index,'$id4')},
        toolbar: '#tbCamisas',
        columns:[[
            {title:'IdProducto',field:'IdProducto',hidden:true,editor:{type:'textbox'}},
            {
                title:'Tipo de Camisa',
                field:'IdCamisaTipo',
                width:150,
                align:'center',
                editor:{
                    type:'combogrid',
                    options:{
                        url:'/fimex/productos/data_tipos?id=camisa',
                        valueField:'IdCamisaTipo',
                        textField:'Descripcion',
                        panelWidth:200,
                        columns:[[

                            {field:'Descripcion',title:'Descripcion',width:100},
                        ]],
                    }
                },
                formatter:function(value,row,index){
                    return row.IdCamisaTipo;
                },
            },
           //{title:'Tipo Camisa',field:'IdCamisaTipo',width:80,align:'center',editor:{type:'numberspinner'}},
            {title:'Cantidad',field:'Cantidad',width:120,align:'center',editor:{type:'numberspinner'}},

            {field:'action',title:'',width:80,align:'center',
                formatter:function(value,row,index){
                    if (row.editing){
                        return '<a href=\"#\" class=\"easyui-linkbutton\" onclick=\"saverow(this,\'$id4\')\">Guardar</a>';
                    }else{
                        return '<a href=\"#\" class=\"easyui-linkbutton\" onclick=\"editrow(this,\'$id4\')\">Editar</a>';
                    }
                }
            },
            {field:'action2',title:'',width:80,align:'center',
                formatter:function(value,row,index){
                    if (row.editing){
                        return '<a href=\"#\" class=\"easyui-linkbutton\" onclick=\"cancelrow(this,\'$id4\')\">Cancelar</a>';
                    }else{
                        return '<a href=\"#\" class=\"easyui-linkbutton\" onclick=\"deleterow(this,\'$id4\')\">Eliminar</a>';
                    }

                }
            },
        ]],
        onBeforeEdit:function(index,row){
            row.editing = true;
            updateActions(index,'$id4');
        },
        onAfterEdit:function(index,row){
            row.editing = false;
            updateActions(index,'$id4');
        },
        onCancelEdit:function(index,row){
            row.editing = false;
            updateActions(index,'$id4');
        },

    });
    

    $('#$id5').datagrid({
        singleSelect:true,
        method:'get',
        remoteSort:false,
        multiSort:true,
        striped:true,
        url:'/fimex/productos/cajas',
        loadMsg: 'Cargando datos',
        onLoadSuccess:function(data){
        },
        onDblClickRow: function(index){onClickRow(index,'$id5')},
        toolbar: '#tbCajas',
        columns:[[
            {title:'IdProducto',field:'IdProducto',hidden:true,editor:{type:'textbox'}},
            {
                title:'Tipo Caja',
                field:'IdTipoCaja',
                width:180,
                align:'center',
                editor:{
                    type:'combogrid',
                    options:{
                        url:'/fimex/productos/data_tipos?id=cajas',
                        valueField:'IdTipoCaja',
                        textField:'Tamano',
                        panelWidth:200,
                        columns:[[

                            {field:'Tamaño',title:'Tamano',width:100},
                        ]],
                        onSelect:function(record){

                            var ed = $('#$id5').datagrid('getEditor', {index:gridIndex['$id5'],field:'IdTipoCaja'}).target;

                            Productos = $(ed).combogrid('grid').datagrid('getSelected');
                            
                            $('#$id5').datagrid('getRows')[gridIndex['$id5']]['IdTipoCaja'] = Productos.IdTipoCaja;

                        },
                    }
                },
                formatter:function(value,row,index){
                    return row.IdTipoCaja;
                },
            },
           // {title:'Cantidad',field:'Cantidad',width:120,align:'center',editor:{type:'numberspinner'}},
            {title:'Cajas',field:'PiezasXCaja',width:120,align:'center'},

            {field:'action',title:'',width:80,align:'center',
                formatter:function(value,row,index){
                    if (row.editing){
                        return '<a href=\"#\" class=\"easyui-linkbutton\" onclick=\"saverow(this,\'$id5\')\">Guardar</a>';
                    }else{
                        return '<a href=\"#\" class=\"easyui-linkbutton\" onclick=\"editrow(this,\'$id5\')\">Editar</a>';
                    }
                }
            },
            {field:'action2',title:'',width:80,align:'center',
                formatter:function(value,row,index){
                    if (row.editing){
                        return '<a href=\"#\" class=\"easyui-linkbutton\" onclick=\"cancelrow(this,\'$id5\')\">Cancelar</a>';
                    }else{
                        return '<a href=\"#\" class=\"easyui-linkbutton\" onclick=\"deleterow(this,\'$id5\')\">Eliminar</a>';
                    }

                }
            },
        ]],
        onBeforeEdit:function(index,row){
            row.editing = true;
            updateActions(index,'$id5');
        },
        onAfterEdit:function(index,row){
            row.editing = false;
            updateActions(index,'$id5');
        },
        onCancelEdit:function(index,row){
            row.editing = false;
            updateActions(index,'$id5');
        },

    });


    function onClickRow(indice,grid){
        var gridSelector = '#'+grid;
        if (gridIndex[grid] != indice){
            if (endEditing(grid,gridSelector)){
                $(gridSelector).datagrid('selectRow', indice);
                $(gridSelector).datagrid('beginEdit', indice);
                gridIndex[grid] = indice;
            } else {
                $(gridSelector).datagrid('selectRow', gridIndex[grid]);
            }
        }
    }

    function endEditing(grid,gridSelector){
        if (gridIndex[grid] == undefined){return true}
        if ($(gridSelector).datagrid('validateRow', gridIndex[grid])){
            $(gridSelector).datagrid('endEdit', gridIndex[grid]);
            gridIndex[grid] = undefined;
            return true;
        } else {
            return false;
        }
    }
    
    function updateActions(index,grid){
        $('#'+grid).datagrid('updateRow',{
            index: index,
            row:{}
        });
    }
    function getRowIndex(target){
        var tr = $(target).closest('tr.datagrid-row');
        return parseInt(tr.attr('datagrid-row-index'));
    }
    function cancelrow(target,grid){
        $('#'+grid).datagrid('cancelEdit', getRowIndex(target));
    }
    
    function editrow(target,grid){
        $('#'+grid).datagrid('beginEdit', getRowIndex(target));
    }
    
    function deleterow(target,grid){
        $.messager.confirm('Confirm','Seguro que desea eliminar el registro?',function(r){
            if (r){
                gridSelector = '#'+grid;
                rows = $(gridSelector).datagrid('getRows');
                console.log(rows[getRowIndex(target)]);
                $.get('".URL::to('/fimex/productos/deleteproductos')."',
                    {
                        data: JSON.stringify(rows[getRowIndex(target)]),
                        grid: grid
                    },
                    function(data,status){
                        console.log(data);
                        if(status == 'success' ){
                            $(gridSelector).datagrid('load');
                        }else{
                            reject(grid);
                            alert('Error al guardar los datos');
                        }
                    }
                );
            }
        });
    }
     var Producto = undefined;
    function saverow(target,grid){
    
        gridSelector = '#'+grid;
        $(gridSelector).datagrid('endEdit', getRowIndex(target));
        
        console.log($(gridSelector).datagrid('getChanges'));
        var dat = $(gridSelector).datagrid('getChanges');
        
       
        if(dat.length == 0){
            return false
        }
        console.log(dat);
        dat = JSON.stringify(dat);
        //alert(dat);
        $.get('".URL::to('/fimex/productos/save')."',
            {
                data: dat,
                grid: grid
            },
            function(data,status){
                console.log(data);
                if(status == 'success' ){
                    $(gridSelector).datagrid('load');
                }else{
                    reject(grid);
                    alert('Error al guardar los datos');
                }
            }
        );
    }
    
    function append(grid){
        var gridSelector = '#'+grid;
        if (endEditing(grid,gridSelector)){
            var data = '';
        
            $(gridSelector).datagrid('appendRow',data);
            gridIndex[grid] = $(gridSelector).datagrid('getRows').length-1;
            $(gridSelector).datagrid('selectRow', gridIndex[grid])
                    .datagrid('beginEdit', gridIndex[grid]);
        }
    }
    

    function accept(grid){
        var gridSelector = '#'+grid;
            var row = $('#Almas').datagrid('getSelected');
          //  if (row){
                alert('Item ID:'+row.Existencia);
            //}
        if (endEditing(grid,gridSelector)){
            var dat = $(gridSelector).datagrid('getChanges');
            if(dat.length == 0){
                return false
            }
            
            console.log(dat);
            dat = JSON.stringify(dat);
            $.get('".URL::to('/fimex/productos/save')."',
                {
                    data: dat,
                    grid: grid
                },
                function(data,status){
                    console.log(data);
                    if(status == 'success' ){
                        $(gridSelector).datagrid('load');
                    }else{
                        reject(grid);
                        alert('Error al guardar los datos');
                    }
                }
            );
            $(gridSelector).datagrid('acceptChanges');
            if(grid == 'detalle'){
                $('#tbRechazo .easyui-linkbutton').linkbutton('enable');
                $('#tbTM .easyui-linkbutton').linkbutton('enable');
                $('#detalle #add').linkbutton('enable');
            }
            dat= undefined;
        }
    }
    
    function insert(grid){
        var idProducto = $('#productos-idproducto').val();                    
        var row = $('#'+grid).datagrid('getSelected');
        if (row){
                var index = $('#'+grid).datagrid('getRowIndex', row);
        } else {
                index = 0;
        }
        $('#'+grid).datagrid('insertRow', {
                index: index,
                row:{
                    IdProducto : idProducto
                }
        });

            
        $('#'+grid).datagrid('selectRow',index);
        $('#'+grid).datagrid('beginEdit',index);
    }
    
    function getChanges(grid){
        $(grid).datagrid('load');
    }
    
    function onAfterEdit(grid){
        accept(grid);
    }
    function onUnselect(grid){
        onAfterEdit(grid);
    }


    function submitForm(forms){

         $('#param-'+forms).form('submit',{
            success:function(data){
                if(data == true){
                     //area:$area
                    //$.messager.alert('Info', 'Datos actualizados', 'info');
                }
                return false;
            }
        });  

    }


",$this::POS_END);
?>
<hr />
<h2>Datos de moldeo</h2>



<div class="easyui-layout" style="width:100%;height:340px;">
    <div data-options="region:'center',border:false">
        <div class="easyui-layout" data-options="fit:true">

            <div data-options="region:'west',border:false" style="width:750px; height:290px;" >
                <div id="Moldeo" class="easyui-panel" title="Moldeo" style="width:700px;height:220px;padding:10px;margin-bottom: 25px; float:left;"></div>
            </div>

            <div data-options="region:'center',border:false" style="width:350px; height:60%;" >
                <div id="Series" class="easyui-panel" title="Series" style="width:350px;height:200px;padding:10px;margin-bottom: 25px; float:right;">
                   
                </div>
            </div>

        </div>
    </div>
</div>

<div class="easyui-layout" style="width:100%;height:400px;">
    <div data-options="region:'center',border:false">
        <div class="easyui-layout" data-options="fit:true">
            <div data-options="region:'west',border:true,split:false" style="width:33%; height:670px;">
                <table id="<?=$id2?>" class="easyui-datagrid datagrid-f" title="Almas" ></table>
            </div>
            <div data-options="region:'center',border:true" style="width:33%; height:60%;">
                <table id="<?=$id3?>" class="easyui-datagrid datagrid-f" title="Filtros" ></table>
            </div>
            <div data-options="region:'east',border:true" style="width:33%; height:60%;" >
                <table id="<?=$id4?>"  class="easyui-datagrid datagrid-f" title="Camisas" ></table>
            </div>
        </div>
    </div>
</div>

<div class="easyui-layout" style="width:100%;height:400px;">
    <div data-options="region:'center',border:false">
        <div class="easyui-layout" data-options="fit:true">
            <div data-options="region:'west',border:true" style="width:33%; height:60%;" >
                <table id="<?=$id5?>"  class="easyui-datagrid datagrid-f" title="Cajas" ></table>
            </div>
        </div>
    </div>
</div>
<!--<div id="s" class="easyui-panel" title="ssss" style="width:800px;height:100%;padding:10px;">
    <table id="<?=$id2?>" style='height:40%; float: left ' class="easyui-datagrid datagrid-f" title="Almas" ></table>
    <table id="<?=$id3?>" style='height:40%; float: right' class="easyui-datagrid datagrid-f" title="Filtros" ></table>
    <table id="<?=$id4?>" style='height:40%' class="easyui-datagrid datagrid-f" title="Camisas" ></table>
</div>-->

<?php


echo Html::beginTag('div',['id'=>'tbAlmas']);
    
    echo Html::a('Agregar',"javascript:void(0)",[
        'id'=>'add',
        'class'=>"easyui-linkbutton",
        'data-options'=>"iconCls:'icon-add',plain:true",
        'onclick'=>"insert('$id2')"
    ]);
    
echo Html::endTag('div');


echo Html::beginTag('div',['id'=>'tbFiltros']);
    
    echo Html::a('Agregar',"javascript:void(0)",[
        'id'=>'add',
        'class'=>"easyui-linkbutton",
        'data-options'=>"iconCls:'icon-add',plain:true",
        'onclick'=>"insert('$id3')"
    ]);
    
echo Html::endTag('div');

echo Html::beginTag('div',['id'=>'tbCamisas']);
    
    echo Html::a('Agregar',"javascript:void(0)",[
        'id'=>'add',
        'class'=>"easyui-linkbutton",
        'data-options'=>"iconCls:'icon-add',plain:true",
        'onclick'=>"insert('$id4')"
    ]);
    
echo Html::endTag('div');


echo Html::beginTag('div',['id'=>'tbCajas']);
    
    echo Html::a('Agregar',"javascript:void(0)",[
        'id'=>'add',
        'class'=>"easyui-linkbutton",
        'data-options'=>"iconCls:'icon-add',plain:true",
        'onclick'=>"insert('$id5')"
    ]);
    
echo Html::endTag('div');

?>