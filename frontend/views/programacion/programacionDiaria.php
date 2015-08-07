<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\URL;
use common\models\Grid;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\programacion\ProgramacionesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $title;
$semana = $semanas['semana1']['value'];
$this->params['breadcrumbs'][] = $this->title;

$dias = ['Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo'];

$year = $semanas['semana1']['año'];
$week = $semanas['semana1']['semana'];
$fecha = strtotime($year."W".$week."1");
$fecha = date('Y-m-d',$fecha);
$dia = ['Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo'];

$id = 'programacion_diaria';
echo Html::beginTag('div',['id'=>'tbDiaria']);
    echo "Ver: ".Html::tag("input","",[
        'id'=>'semana1',
        'type'=>'week',
        'value'=>$semana
    ]);
    echo " Turno: ".Html::activeDropDownList($turnos, 'IdTurno', ArrayHelper::map($turnos->find()->all(),'IdTurno','Descripcion'));
    echo Html::a('Guardar',"javascript:void(0)",[
        'class'=>"easyui-linkbutton",
        'data-options'=>"iconCls:'icon-save',plain:true",
        'onclick'=>"accept('#$id')"
    ]);
    echo Html::a('Actualizar',"javascript:void(0)",[
        'class'=>"easyui-linkbutton",
        'data-options'=>"iconCls:'icon-reload',plain:true",
        'onclick'=>"getChanges('#$id')"
    ]);
echo Html::endTag('div');
        
$this->registerJS("
    $('#semana1').change(function(){
        load_grid($(this).val(),$('#turnos-idturno').val());
    });
    
    $('#vmarcas-idmarca').change(function(){
        
        $('#$id').datagrid('enableFilter');
    });
    $('#turnos-idturno').change(function(){
        $('#$id').datagrid('load',{
            turno:$(this).val(),
            
        });
    });
");
$this->registerJS("
    var ProgramacionIndex = undefined;
    
    function load_grid(semana,turno){
        location.href ='/fimex/programacion/diaria?&AreaProceso=$AreaProceso&subProceso=$IdSubProceso&semana=' + semana;
    }
    
    function endEditing(grid){
        if (ProgramacionIndex == undefined){return true}
        if ($(grid).datagrid('validateRow', ProgramacionIndex)){
            $(grid).datagrid('endEdit', ProgramacionIndex);
            ProgramacionIndex = undefined;
            return true;
        } else {
            return false;
        }
    }
    
    function append(grid){
        if (endEditing(grid)){
            $(grid).datagrid('appendRow');
            ProgramacionIndex = $(grid).datagrid('getRows').length-1;
            $(grid).datagrid('selectRow', ProgramacionIndex)
                .datagrid('beginEdit', ProgramacionIndex);
        }
    }
    function accept(grid){
        if (endEditing(grid)){
            var data = $(grid).datagrid('getChanges');
            $.get('".URL::to('/fimex/programacion/save_diario')."',
                {
                    IdAreaProceso:$AreaProceso,
                    Data: data
                },
                function(data,status){
                    if(status == 'success' ){
                        $(grid).datagrid('load',{turno:$('#turnos-idturno').val()});
                        $('#resultado').html(data);
                        \$var = $(grid).datagrid('getChanges');
                    }else{
                        reject('#$id');
                        alert('Error al guardar los datos');
                    }
                }
            );
        }
    }
    
    function del(id){
        $.post('".URL::to('/fimex/programacion/delete_diario')."',
            {IdProgramacionDia: id},
            function(data,status){
                $('#$id').datagrid('load',{turno:$('#turnos-idturno').val()});
            }
        );
    }
    
    function getChanges(grid){
        $(grid).datagrid('load',{turno:$('#turnos-idturno').val()});
    }
    
    function onAfterEdit(grid){
        accept('#$id');
    }
    function onUnselect(){
        onAfterEdit('#$id');
    }
",$this::POS_END);
?>
<table id="<?= $id ?>" class="easyui-datagrid datagrid-f" title="" style="height:600px" data-options="
    url:'/fimex/programacion/data_diaria?AreaProceso=<?=$AreaProceso?>&semana=<?=$semana?>&subProceso=<?=$IdSubProceso?>',
    singleSelect:false,
    method:'post',
    collapsible:true,
    remoteSort:false,
    multiSort:true,
    showFooter:true,
    loadMsg: 'Cargando datos',
    onAfterEdit: onAfterEdit,
    onDblClickRow: 
        function (index){
            if (ProgramacionIndex != index){
                if (endEditing('#programacion_diaria')){
                    $('#programacion_diaria').datagrid('selectRow', index);
                    $('#programacion_diaria').datagrid('beginEdit', index);
                    ProgramacionIndex = index;
                } else {
                    $('#programacion_diaria').datagrid('selectRow', ProgramacionIndex);
                }
            }
    },
    toolbar: '#tbDiaria'
">
    <thead data-options="frozen:true">
        <tr>
            <th data-options="field:'IdProgramacion',width:50,hidden:true,editor:{type:'numberbox',options:{precision:0,editable:false}}">Id</th>
            <th data-options="field:'IdTurno',hidden:true">Turno</th>
            <th data-options="field:'Producto',sortable:true,width:200">Producto</th>
            <th data-options="field:'ProductoCasting',sortable:true,width:200">Casting</th>
            <th data-options="field:'FechaEmbarque',sortable:true,width:100">Embarque</th>
            <th data-options="field:'Aleacion',sortable:true,hidden:true,width:100">Aleacion</th>
            <th data-options="field:'Marca',sortable:true,width:100">Cliente</th>
            <th data-options="field:'Presentacion',sortable:true,hidden:true,width:100">Presentacion</th>
            <th data-options="field:'Cantidad',sortable:true,width:65">Cantidad</th>
            <th data-options="field:'TotalProgramado',align:'center',width:50">Total programado</th>
            <th data-options="field:'IdProgramacionSemana',hidden:true,align:'center',width:80">IdProgramacionSemana</th>
            <th data-options="field:'IdAreaProceso',hidden:true,align:'center',width:80">IdAreaProceso</th>
            <th data-options="field:'Anio',align:'center',hidden:true,width:80">Anio</th>
            <th data-options="field:'Semana',align:'center',hidden:true,width:80">Semana</th>
            <th data-options="field:'Prioridad',width:80,align:'center'">Prioridad</th>
            <th data-options="field:'Programadas',width:80,align:'center'">Programadas</th>
            <th data-options="field:'Hechas',width:80,align:'center'">Hechas</th>
            <th data-options="field:'Dia1',width:80,hidden:true,align:'center'">Dia1</th>
            <th data-options="field:'Dia2',width:80,hidden:true,align:'center'">Dia2</th>
            <th data-options="field:'Dia3',width:80,hidden:true,align:'center'">Dia3</th>
            <th data-options="field:'Dia4',width:80,hidden:true,align:'center'">Dia4</th>
            <th data-options="field:'Dia5',width:80,hidden:true,align:'center'">Dia5</th>
            <th data-options="field:'Dia6',width:80,hidden:true,align:'center'">Dia6</th>
            <th data-options="field:'Dia7',width:80,hidden:true,align:'center'">Dia7</th>
            <th data-options="field:'PiezasMolde',width:80,align:'center',
                formatter:function(value,row,index){
                if(parseInt(row.Cantidad) / parseInt(row.PiezasMolde) != 'NaN'){ return row.PiezasMolde; }else{ return parseInt(row.Cantidad) / parseInt(row.PiezasMolde);}
               
                },
            ">Moldes</th>
        </tr>
    </thead>
    <thead>
        <tr>
            <?php for($x=0;$x<7;$x++):?>
            <th colspan="5" data-options="field:'<?=$x?>'"><?=$dias[$x]?> <?= date('d-m-Y',strtotime("$fecha +$x Day"))?></th>
            <?php endfor;?>
        </tr>
        <tr>
            <?php for($x=1;$x<=7;$x++):?>
            <th data-options="field:'Prioridad<?=$x?>',width:50,align:'center',editor:{type:'numberspinner',options:{precision:0}}">Pr</th>
            <th data-options="field:'Maquina<?=$x?>',width:50,align:'center',editor:{type:'combobox',options:{
                url:'/fimex/programacion/data_maquina?area=<?=$area?>&subProceso=<?=$IdSubProceso?>',
                valueField:'IdMaquina',
                textField:'ClaveMaquina',
                panelWidth:265,
                queryParams:{
                    proceso:2
                },
            }}">Maq</th>
            <th data-options="field:'Programadas<?=$x?>',width:50,align:'center',editor:{type:'numberspinner',options:{precision:0}}">Prg</th>
            <th data-options="field:'Hechas<?=$x?>',width:50,align:'center'">H</th>
            <th data-options="
                field:'action<?=$x?>',width:50,align:'center',
                formatter:function(value,row,index){
                    if(row.IdProgramacionDia<?=$x?> != null && row.Hechas<?=$x?> == null){
                        return '<a href=\'#\' onclick=\'del(' + row.IdProgramacionDia<?=$x?> + ')\'>X</a>';
                    }
                    return '';
                }
            "></th>
            <?php endfor;?>
        </tr>
    </thead>
</table>