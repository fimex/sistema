<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\catalogos\SubProcesos;
use common\models\catalogos\Areas;

/* @var $this yii\web\View */
/* @var $model common\models\catalogos\Materiales */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="materiales-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Identificador')->textInput() ?>

    <?= $form->field($model, 'Descripcion')->textInput() ?>

    <?= $form->field($model, 'IdSubProceso')->dropDownList(ArrayHelper::map(SubProcesos::find()->all(),'IdSubProceso', 'Descripcion')) ?>

    <?= $form->field($model, 'IdArea')->dropDownList(ArrayHelper::map(Areas::find()->all(),'IdArea', 'Descripcion')) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
