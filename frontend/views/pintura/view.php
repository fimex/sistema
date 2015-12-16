<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\produccion\PinturaControl */

$this->title = $model->id_pintura;
$this->params['breadcrumbs'][] = ['label' => 'Pintura', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pintura-control-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
		<?= Html::a('Regresar', ['.'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Update', ['update', 'id' => $model->id_pintura], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_pintura], [
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
            'id_pintura',
            'fecha',
            'turno',
            'Motivo',
            'pintura',
            'den_ini',
            'den_fin',
            'serie',
            'pin_nueva',
            'pin_recicl',
            'comentarios',
            'nomina',
            'alcohol',
            'area',
            'base',
            'base_cant',
           
        ],
    ]) ?>

</div>
