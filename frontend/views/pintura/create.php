<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\produccion\PinturaControl */

$this->title = 'Pintura Control (nuevo registro)';
$this->params['breadcrumbs'][] = ['label' => 'Pintura Controls', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pintura-control-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
