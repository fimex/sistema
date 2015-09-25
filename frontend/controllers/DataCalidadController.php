<?php

namespace frontend\controllers;

use frontend\models\calidad\CatClientes;
use frontend\models\calidad\CatDimensiones;
use frontend\models\calidad\CatInspeccion;
use frontend\models\calidad\CatMuestreo;
use frontend\models\calidad\CatPartes;
use frontend\models\calidad\Mediciones;
use frontend\models\calidad\MedicionesDimenciones;
use frontend\models\calidad\Parmediciones;
use frontend\models\calidad\Parmuestreo;
use frontend\models\calidad\VCapturas;

class DataCalidadController extends \yii\web\Controller
{
    public function actionCatalogos(){
        $model = CatClientes::find()->where($_GET)->with('catPartes')->orderBy('Cliente')->asArray()->all();
        return(json_encode($model));
    }
    
    public function actionMediciones(){
        $model = VCapturas::find()
            ->where($_GET)
            ->orderBy('cliente')
            ->asArray()
            ->all();
        
        foreach ($model as &$mod){
            $dimenciones = CatDimensiones::find()
                ->where([
                    'no_parte' => $mod['IdNoParte'],
                    'operacion' => $mod['operacion']
                ])
            ->asArray()
            ->all();
            $mod['dimenciones'] = $dimenciones;
        }
        
        return(json_encode($model));
    }
    
    public function actionCapturas(){
        //var_dump($_POST);
        $model = Parmediciones::find()
            ->where($_POST)
            ->with('medicionesDimenciones')
            ->asArray()
            ->all();
        
        return(json_encode($model));
    }
    
    public function actionSaveCliente(){
        
    }

}
