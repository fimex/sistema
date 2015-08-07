<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\URL;

/* @var $this yii\web\View */
/* @var $model common\models\catalogos\Productos */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="productos-form">

    <?php 
    $form = ActiveForm::begin([
        'id'=>'param-moldeo',
        'enableAjaxValidation'=>true,
    ]); ?>
    
    <table>
        <tr>
            <td><?= $form->field($model, 'PiezasMolde')->textInput(['class' => 'f1 easyui-textbox']) ?></td>
            <td><?= $form->field($model, 'CiclosMolde')->textInput(['class' => 'f1 easyui-textbox']) ?></td>
        </tr>
        <tr>
            <td><?= $form->field($model, 'PesoCasting')->textInput(['class' => 'f1 easyui-textbox']) ?></td>
            <td><?= $form->field($model, 'PesoArania')->textInput(['class' => 'f1 easyui-textbox']) ?></td>
        </tr>
        <tr>
            <td><?= $form->field($model, 'FechaMoldeo')->checkbox(['class' => 'f1 easyui-textbox']) ?></td>
            <td>
                    <?php
                    if ($_GET['area'] == 2) {
                   
                        echo $form->field($model, 'IdAreaAct')->dropDownList(
                        ArrayHelper::map(common\models\datos\AreaActual::find()->all(), 'IdAreaAct', 'Identificador'),[
                            'id'=>"areaactual",
                            'class'=>"easyui-combobox",
                        ]); 
                    }
                    ?>
            </td>
        </tr>
        <tr style="display: none" >
            <td><?= $form->field($model, 'IdProducto')->textInput(['class' => 'f1 easyui-checkbox']) ?></td>
            <td></td>
        </tr>
    </table>
    <div class="form-group">
        <?= Html::Button('Guardar', [
            'class' => 'btn btn-primary',
            'onclick'=>'submitForm("moldeo")'
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

