<?php
use yii\widgets\ActiveForm;

?>

<div class="FormCons">
    <?php $form = ActiveForm::begin(); ?>
    <table border="0" >
        <tr style="height: 35px" >
            <td></td>
        </tr>
        <tr  style="height: 39px" >
            <td></td>
         
        </tr>
        <tr>
            <td>
                <?php if($model == ""){ ?>
            <td style="height: 70px" > <label>Cons </label> <input class="easyui-textbox" id="horno" value="" style="width:100px"></td>
                <?php }else{ ?>
                <td>
                    <?= $form->field($model, 'Consecutivo')->textInput([ 'style'=>'width:100px;',
                    'id'=>"horno",
                    'class'=>"easyui-textbox",
                    'value'=>$model->getAttributes()['Consecutivo']!=null ? $model->getAttributes()['Consecutivo'] : 0,
                    ]) ?>
                </td>
                <?php } ?>
                </td> 
        </tr>
        <tr  style="height: 35px" >
            <td> 
             
            </td>
         
        </tr>

    </table>
    <?php ActiveForm::end(); ?>

</div>





