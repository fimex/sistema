<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\catalogos\FiltrosTipo */

$this->title = 'Create Filtros';
$this->params['breadcrumbs'][] = ['label' => 'Filtros', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="filtros-tipo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
