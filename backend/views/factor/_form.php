<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\catalogos\AleacionesTipo;

/* @var $this yii\web\View */
/* @var $model common\models\catalogos\AleacionesTipoFactor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="aleaciones-tipo-factor-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'IdAleacionTipoFactor')->textInput() ?>

    <?= $form->field($model, 'IdAleacionTipo')->dropDownList(ArrayHelper::map(AleacionesTipo::find()->all(), 'IdAleacionTipo', 'Descripcion'))  ?>

    <?= $form->field($model, 'Fecha')->textInput() ?>

    <?= $form->field($model, 'Factor')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
