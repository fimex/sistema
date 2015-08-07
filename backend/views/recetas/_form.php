<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\catalogos\AlmasRecetas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="almas-recetas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Identificador')->textInput() ?>

    <?= $form->field($model, 'Descripcion')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
