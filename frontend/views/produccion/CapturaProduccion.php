
<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\URL;

$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = $IdSubProceso;

$fecha = date('Y-m-d');

?>
<div style="width: 35%;" >
<?php if($IdSubProceso == 10):?>
    <?= $this->render('FormLances',[
        'lances'=>$lances, 
        'model'=>$produccion,
        'IdSubProceso'=>$IdSubProceso
    ]);?>
<?php else:?>
    <?= $this->render('FormProduccion',[
        'model'=>$produccion,
        'IdSubProceso'=>$IdSubProceso
    ]);?>
<?php endif;?>
</div>