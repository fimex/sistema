<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\catalogos\Defectos */

$this->title = $model->IdDefecto;
$this->params['breadcrumbs'][] = ['label' => 'Defectos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="defectos-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->IdDefecto], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->IdDefecto], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Está seguro de eliminar este elemento?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'IdDefecto',
            'IdDefectoTipo',
            'IdSubProceso',
            'IdArea',
        ],
    ]) ?>

</div>
