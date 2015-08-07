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
                    parser:myparser
               
                "
            ]) ?></td>
        
            
           <td><b>Turno:</b> <?= Html::dropDownList('turno',NULL,
                ArrayHelper::map(common\models\catalogos\Turnos::find()->all(), 'IdTurno', 'Descripcion'),[
                    'id'=>"turno",
                    'class'=>"easyui-combobox",
            ]) ?></td>
           <td> <a href="#" class="easyui-linkbutton" onclick="cargarDatos();" >Aceptar</a> </td>
        </tr>
        
        <tr>
            <td colspan="3" ><b>Maquina:</b> <?= Html::dropDownList('maquina',NULL,
                ArrayHelper::map(common\models\catalogos\VMaquinas::find("IdSubProceso = $subProceso")->all(), 'IdMaquina', 'Identificador'),[
                    'id'=>"maquina",
                    'class'=>"easyui-combobox",
            ]) ?></td>
            
        </tr>
     
    </table>
    <?php ActiveForm::end(); ?>

</div><!-- FormProduccionDetalle -->
<?php
$this->registerJS("
");
$this->registerJS("
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
    
    function cargarDatos(){
        //var fecha = date.getFullYear()+'-'+(date.getMonth()+1)+'-'+date.getDate();
        
        $('#programacion').datagrid('load',{
             Dia: $('#fecha').datebox('getValue')
            //Dia: date.getFullYear()+'-'+(date.getMonth()+1)+'-'+date.getDate()
        });
     
        $('#detalle').datagrid('load',{
            'IdSubProceso':$subProceso,
            Turno:$('#turno').combobox('getValue'),
            Dia:  $('#fecha').datebox('getValue')
        });
    }
",$this::POS_END);
?>
