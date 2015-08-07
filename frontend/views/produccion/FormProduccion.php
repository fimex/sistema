<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\URL;

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
            <td><?= $form->field($model, 'IdProduccion')->hiddenInput(['id'=>"IdProduccion"])->label("Datos de captura") ?></td>
            <td><?= $form->field($model, 'IdProduccionEstatus')->hiddenInput(['id'=>"IdProduccionEstatus"])->label("") ?></td>
            <td><?= $form->field($model, 'Fecha')->hiddenInput(['id'=>"FechaHidden",'style'=>'display:none;'])->label("") ?></td>
            <td><?= $form->field($model, 'IdMaquina')->hiddenInput(['id'=>"IdMaquinaHidden",'style'=>'display:none;'])->label("") ?></td>
        </tr>
        <tr>
            <td><?= $form->field($model, 'Fecha')->textInput([
                'id'=>"fecha",
                'class'=>"easyui-datebox",
                'value'=>$model->getAttributes()['Fecha']!=null ? $model->getAttributes()['Fecha'] : date('Y-m-d'),
                'data-options'=>"
                    formatter:myformatter,
                    parser:myparser,
                    onSelect: function(date){
                        fecha = date.getFullYear()+'-'+(date.getMonth()+1)+'-'+date.getDate();
                        $('#programacion').datagrid('load',{
                            Dia: fecha
                        });
                        $('#detalle').datagrid('load',{
                            Dia: fecha
                        });
                        $('#tiempo_muerto').datagrid('load',{
                            Dia: fecha,
                            IdMaquina: $('#maquina').val(),
                        });
                        $('#detalle').datagrid('getColumnOption','IdProductos').editor.options.queryParams = $('#detalle').datagrid('options').queryParams;
                    }
                "
            ]) ?></td>
        </tr>
        <tr>
            <td><?= $form->field($model, 'IdMaquina')->dropDownList(
                ArrayHelper::map(common\models\catalogos\VMaquinas::find("IdSubProceso = $subProceso")->all(), 'IdMaquina', 'ClaveMaquina'),[
                    'id'=>"maquina",
                    'class'=>"easyui-combobox",
                    'data-options'=>"onChange:Changes",
            ]) ?></td>
        </tr>
        <!--<tr>
            <td style="height: 35px"><strong> Aleacion</strong>
                <input width="20" id="aleacion" class="easyui-combobox" 
                        data-options="
                            url:'/Fimex/produccion/aleaciones',
                            method:'get',
                            valueField:'IdAleacion',
                            textField:'Identificador',
                            panelHeight:'100',  
                        ">
            </td>
        </tr>-->
        <tr>
            <td><?php if($model->getAttributes()['IdProduccionEstatus'] == 1 ): ?>
            <?= Html::Submitbutton('Cerrar Captura', [
                'id'=>'new',
                'class' => 'easyui-linkbutton',
                'onclick'=>'submitForm()',
                'name'=>'Cerrar',
            ]) ?>
            <?php else: ?>
            <?= Html::Submitbutton('Iniciar Captura', [
                'id'=>'save',
                'class' => 'easyui-linkbutton',
                'onclick'=>'submitForm()',
                'name'=>'Iniciar',
            ]) ?>
            <?php endif; ?></td>
        </tr>
    </table>
    <?php ActiveForm::end(); ?>

</div><!-- FormProduccionDetalle -->

<?php
$this->registerJS("
    var estatus = ".$model->getAttributes()['IdProduccionEstatus'].";
    if(estatus == 1){
        $('#fecha').datebox({ disabled: true });
        $('#maquina').combobox({ disabled: true });
        $('#horno').textbox({ disabled:true });
        $('#colada').textbox({disabled:true});
        $('#lance').textbox({disabled:true});
    }
    
");

$this->registerJS("
    
    function Changes(){
        var v = $('#maquina').combobox('getValue');
        $.ajax({
		type: 'POST',
		url: '/Fimex/produccion/hornos?maquina='+v,
		data: {  },
		success: function(data){
                    $('#horno').textbox('setValue',data);
		},
		dataType: 'html'
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

         $('#formlances').form('submit',{
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
