<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\catalogos\FiltrosTipo */

$this->title = 'Actualizar Filtro: ' . ' ' . $model->IdFiltroTipo;
$this->params['breadcrumbs'][] = ['label' => 'Filtros Tipos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->IdFiltroTipo, 'url' => ['view', 'id' => $model->IdFiltroTipo]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="filtros-tipo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
