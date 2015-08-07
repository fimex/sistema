<?php
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\catalogos\Lances */
/* @var $form yii\widgets\ActiveForm */
//var_dump($model); exit;
?>

<div class="FormLances">
    <?php $form = ActiveForm::begin(['id'=>'formlances' ]); ?>
    <table style="float: right">
        <tr> 
            <?php if($lances == ""){ ?> 
                <td style="height: 70px" > <label>Cons Horno </label> <input class="easyui-textbox" type="text" value="" style="width:100px"></td>
                <td style="height: 10px" > <label>Id Aleacion </label> <input class="easyui-textbox" type="text" value="" style="width:100px"></td>
            <?php }else{ ?>
                <td style="height: 10px; padding-top: 76px">
                    <?= $form->field($lances, 'HornoConsecutivo')->textInput([ 'style'=>'width:100px;',
                    'id'=>"horno",
                    'class'=>"easyui-textbox",
                    'value'=>$lances->getAttributes()['HornoConsecutivo']!=null ? $lances->getAttributes()['HornoConsecutivo'] : 0,
                    ]) ?>
                </td>
                <td style="height:10px; padding-top: 76px">
                    <?= $form->field($lances, 'Colada')->textInput([ 'style'=>'width:100px;',
                    'id'=>"colada",
                    'class'=>"easyui-textbox",
                    'value'=>$lances->getAttributes()['Colada']!=null ? $lances->getAttributes()['Colada'] : 0,
                    ]) ?>
                </td>
            <?php } ?>
        </tr>
        <tr>
            <?php if($lances == ""){ ?>
                <td style="height: 10px" > <label>Colada </label> <input class="easyui-textbox" type="text" value="" style="width:100px"></td>
                <td style="height: 70px" > <label>Lance </label> <input class="easyui-textbox" type="text" value="" style="width:100px"></td>
            <?php }else{ ?>
         
                <td>
                    <?= $form->field($lances, 'IdAleacion')->dropDownList(
                    ArrayHelper::map(common\models\dux\Aleaciones::find()->all(), 'IdAleacion', 'Identificador'),[
                        'id'=>"aleacion2",
                        'class'=>"easyui-combobox",
                    ]) ?>
                </td>
                <td > 
                    <?= $form->field($lances, 'Lance')->textInput([ 'style'=>'width:100px;',
                       'id'=>"lance",
                       'class'=>"easyui-textbox",
                       'value'=>$lances->getAttributes()['Lance']!=null ? $lances->getAttributes()['Lance'] : 0,     
                    ]) ?> 
                </td>
             <?php } ?>
        </tr>
    </table>
    
    <table style="float:left" >
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
                ArrayHelper::map(common\models\catalogos\VMaquinas::find("IdSubProceso = $subProceso")->all(), 'IdMaquina', 'Identificador'),[
                    'id'=>"maquina",
                    'class'=>"easyui-combobox",
                    'data-options'=>"onChange:Changes",
            ]) ?></td>
        </tr>
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
        $('#aleacion2').textbox({disabled:true});
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

    






