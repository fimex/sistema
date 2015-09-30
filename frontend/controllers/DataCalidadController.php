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
        $data = '';
        $data = isset($_POST) ? $_POST : $data;
        $data = isset($_GET) ? $_GET : $data;
        $model2 = [];
        //var_dump($data);
        $model = Parmediciones::find()
            ->where($data)
            ->joinWith('medicionesDimenciones')
            ->asArray()
            ->all();

        $x = 0;
        $pza = '';
        
        foreach ($model as &$mod){
            $mod2 = $mod;
            unset($mod['medicionesDimenciones']);
            
            foreach ($mod['medicionesDimenciones'] as $piezas){
                $model2[] = $mod['medicionesDimenciones'];
            }
        }
        
        return(json_encode($model));
    }
    
    public function actionSaveCliente(){
        
    }
}
