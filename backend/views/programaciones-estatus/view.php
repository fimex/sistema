<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\catalogos\ProgramacionesEstatus */

$this->title = $model->IdProgramacionEstatus;
$this->params['breadcrumbs'][] = ['label' => 'Estatuses de Programaciones ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="programaciones-estatus-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->IdProgramacionEstatus], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->IdProgramacionEstatus], [
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
            'IdProgramacionEstatus',
            'Identificador',
            'Descripcion',
        ],
    ]) ?>

</div>
