<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\catalogos\FiltrosTipo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="filtros-tipo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Identificador')->textInput() ?>

    <?= $form->field($model, 'Descripcion')->textInput() ?>

    <?= $form->field($model, 'CantidadPorPaquete')->textInput() ?>

    <?= $form->field($model, 'DUX_CodigoPesos')->textInput() ?>

    <?= $form->field($model, 'DUX_CodigoDolares')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
