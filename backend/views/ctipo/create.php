<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\catalogos\CamisasTipo */

$this->title = 'Crear Tipos de Camisa';
$this->params['breadcrumbs'][] = ['label' => 'Tipos de Camisas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="camisas-tipo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
