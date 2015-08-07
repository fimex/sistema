<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\URL;

/* @var $this yii\web\View */
/* @var $model common\models\catalogos\Productos */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="series-form">

    <?php 
    $form = ActiveForm::begin([
        'id'=>'param-series',
        'enableAjaxValidation'=>true,
    ]); ?>

    <div style="display:none" >
        <?= $form->field($model, 'LlevaSerie')->textInput(['class' => 'f1 easyui-textbox', 'value'=>'Si']) ?>
    </div>

    <label>Lleva Serie</label><br><br>
    <?php
        if ($_GET['area'] == 2) {
       
            echo $form->field($model, 'IdParteMolde')->dropDownList(
            ArrayHelper::map(common\models\catalogos\PartesMolde::find()->all(), 'IdParteMolde', 'Identificador'),[
                'id'=>"partemolde",
                'class'=>"easyui-combobox",
            ]); 
        }
    ?>

    <div class="form-group">
        <?= Html::Button('Guardar', [
            'class' => 'btn btn-primary',
            'onclick'=>'submitForm("series")'
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

 