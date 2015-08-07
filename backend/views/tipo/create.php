<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\catalogos\AlmasTipo */

$this->title = 'Crear Tipo de Almas';
$this->params['breadcrumbs'][] = ['label' => 'Tipos de Almas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="almas-tipo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
