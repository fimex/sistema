<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\PinturaControlSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pintura-control-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_pintura') ?>

    <?= $form->field($model, 'fecha') ?>

    <?= $form->field($model, 'turno') ?>

    <?= $form->field($model, 'Motivo') ?>

    <?= $form->field($model, 'pintura') ?>

    <?php // echo $form->field($model, 'den_ini') ?>

    <?php // echo $form->field($model, 'den_fin') ?>

    <?php // echo $form->field($model, 'serie') ?>

    <?php // echo $form->field($model, 'pin_nueva') ?>

    <?php // echo $form->field($model, 'pin_recicl') ?>

    <?php // echo $form->field($model, 'comentarios') ?>

    <?php // echo $form->field($model, 'nomina') ?>

    <?php // echo $form->field($model, 'alcohol') ?>

    <?php // echo $form->field($model, 'area') ?>

    <?php // echo $form->field($model, 'base') ?>

    <?php // echo $form->field($model, 'base_cant') ?>

    <?php // echo $form->field($model, 'timestamp') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
