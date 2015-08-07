<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\catalogos\CamisasTipo */

$this->title = 'Actualizar Tipo de Camisa : ' . ' ' . $model->IdCamisaTipo;
$this->params['breadcrumbs'][] = ['label' => 'Tipos Camisas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->IdCamisaTipo, 'url' => ['view', 'id' => $model->IdCamisaTipo]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="camisas-tipo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
