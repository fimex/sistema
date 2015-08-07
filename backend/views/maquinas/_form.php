<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\catalogos\CentrosTrabajo;

/* @var $this yii\web\View */
/* @var $model common\models\catalogos\Maquinas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="maquinas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'IdCentroTrabajo')->dropDownList(ArrayHelper::map(CentrosTrabajo::find()->all(),'IdCentroTrabajo','Descripcion')) ?>

    <?= $form->field($model, 'Identificador')->textInput() ?>

    <?= $form->field($model, 'Descripcion')->textInput() ?>

    <?= $form->field($model, 'Consecutivo')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
