<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\datos\Causas */

$this->title = $model->IdCausa;
$this->params['breadcrumbs'][] = ['label' => 'Causas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="causas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->IdCausa], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->IdCausa], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'IdCausa',
            'IdCausaTipo',
            'Indentificador',
            'Descripcion',
            'IdSubProceso',
        ],
    ]) ?>

</div>
