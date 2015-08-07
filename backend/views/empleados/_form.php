<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\catalogos\Turnos;

/* @var $this yii\web\View */
/* @var $model common\models\catalogos\Empleados */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="empleados-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Nomina')->textInput() ?>

    <?= $form->field($model, 'ApellidoPaterno')->textInput() ?>

    <?= $form->field($model, 'ApellidoMaterno')->textInput() ?>

    <?= $form->field($model, 'Nombre')->textInput() ?>

    <?= $form->field($model, 'IdEstatus')->textInput() ?>

    <?= $form->field($model, 'RFC')->textInput() ?>

    <?= $form->field($model, 'IMSS')->textInput() ?>

    <?= $form->field($model, 'IdDepartamento')->textInput() ?>

    <?= $form->field($model, 'IdTurno')->dropDownList(ArrayHelper::map(Turnos::find()->all(),'IdTurno', 'Descripcion')) ?>

    <?= $form->field($model, 'IdPuesto')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
