<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\models\produccion\ProduccionesDetalle */
/* @var $form ActiveForm */
?>
<div class="FormProduccionDetalle">
    <?php $form = ActiveForm::begin([
        'id'=>'produccion',
        //'enableAjaxValidation'=>true,
    ]); ?>
    <table>
        <tr>
            <td>
                <?= Html::hiddenInput('IdProduccion',$IdProduccion,[
                'id'=>"IdProduccion",
            ]) ?>
                <b>Fecha:</b> <?= Html::textInput('fecha',date('Y-m-d'),[
                'id'=>"fecha",
                'class'=>"easyui-datebox",
                'data-options'=>"
                    formatter:myformatter,
                    parser:myparser,
                    onSelect: function(date){
                        fecha = date.getFullYear()+'-'+(date.getMonth()+1)+'-'+date.getDate();
                        $('#programacion').datagrid('load',{
                            Dia: date.getFullYear()+'-'+(date.getMonth()+1)+'-'+date.getDate()
                        });
                        $('#tiempo_muerto').datagrid('load',{
                            Dia: fecha,
                            IdMaquina: $('#maquina').val(),
                        });
                        actualizaDataGrid();
                    }
                "
            ]) ?></td>
        </tr>
        <tr>
            <td><b>Maquina:</b> <?= Html::dropDownList('maquina',NULL,
                ArrayHelper::map(common\models\catalogos\VMaquinas::find()->where("IdSubProceso = $subProceso")->all(), 'IdMaquina', 'ClaveMaquina'),[
                    'id'=>"maquina",
                    'class'=>"easyui-combobox",
                    'data-options'=>"
                        onSelect: actualizaDataGrid,
                    "
            ]) ?></td>
            <td><b>Empleado:</b> <?= Html::dropDownList('IdEmpleado',$IdProduccion,
                ArrayHelper::map(common\models\catalogos\VEmpleados::find()->where("IDENTIFICACION LIKE '2-6' AND IdEmpleadoEstatus <> 2")->orderBy('NombreCompleto')->all(), 'IdEmpleado', 'NombreCompleto'),[
                    'id'=>"empleado",
                    'class'=>"easyui-combobox",
                    'data-options'=>"
                        onSelect: actualizaDataGrid,
                    "
            ]) ?></td>
        </tr>
    </table>
    <?php ActiveForm::end(); ?>

</div><!-- FormProduccionDetalle -->
<?php
$this->registerJS("
    var dia = new Date();
    
    function actualizaDataGrid(){
    
        $('#detalle').datagrid('load',{
            IdSubProceso:$subProceso,
            Dia: fecha,
            IdEmpleado: $('#empleado').val(),
            IdMaquina: $('#maquina').val(),
        });
        
        $('#tbProduccion').datagrid('load',{
            IdSubProceso:$subProceso,
            Dia: fecha,
            IdEmpleado: $('#empleado').val(),
            IdMaquina: $('#maquina').val(),
        });
    }

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
    
    function submitForm(){
        $('#produccion').form('submit',{
            success:function(data){
                if(data == true){
                    $.messager.alert('Info', 'Datos actualizados', 'info');
                }
                return false;
            }
        });
    }
",$this::POS_END);
?>