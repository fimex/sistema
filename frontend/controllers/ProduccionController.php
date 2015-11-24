<?php

namespace frontend\controllers;

use Yii;
use frontend\models\produccion\TiemposMuerto;
use frontend\models\produccion\Temperaturas;
use frontend\models\produccion\MaterialesVaciado;
use frontend\models\produccion\ProduccionesDetalle;
use frontend\models\produccion\ProduccionesDefecto;
use frontend\models\produccion\Producciones;
use frontend\models\produccion\CiclosVarel;
use frontend\models\programacion\ProgramacionesDia;

use frontend\models\produccion\VCapturaExceleada;
use frontend\models\programacion\VProgramacionesDia;
use common\models\catalogos\VDefectos;
use common\models\catalogos\Maquinas;
use common\models\catalogos\Areas;
use common\models\datos\Causas;
use common\models\catalogos\Materiales;
use common\models\catalogos\Lances;
use common\models\dux\Aleaciones;

abstract class ProduccionController extends \yii\web\Controller
{
    abstract function actionSaveDetalle();
    abstract function actionSaveProduccion();
     
    function actionIndex(){
        return $this->render('index');
    }
}