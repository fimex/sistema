<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\datos\Causas */

$this->title = 'Create Causas';
$this->params['breadcrumbs'][] = ['label' => 'Causas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="causas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
