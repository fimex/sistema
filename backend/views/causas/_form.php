<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\catalogos\CausasTipo;
use common\models\catalogos\SubProcesos;

/* @var $this yii\web\View */
/* @var $model common\models\datos\Causas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="causas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'IdCausaTipo')->dropDownList(ArrayHelper::map(CausasTipo::find()->all(),'IdCausaTipo', 'Descripcion')) ?>
    <?= $form->field($model, 'Indentificador')->textInput() ?>
    <?= $form->field($model, 'Descripcion')->textInput() ?>
    <?= $form->field($model, 'IdSubProceso')->dropDownList(ArrayHelper::map(SubProcesos::find()->all(),'IdSubProceso', 'Descripcion')) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
