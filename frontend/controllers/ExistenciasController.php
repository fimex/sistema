<?php

namespace frontend\controllers;

use Yii;
use common\models\catalogos\VExistencias;

class ExistenciasController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    public function actionExistencia()
    {
        $existencias = VExistencias::find()->where(['Almacen'=>$_GET['almacen']])->asArray()->all();
        
        return json_encode([
            'total'=>count($existencias),
            'rows'=>$existencias,
        ]);
    }

}
